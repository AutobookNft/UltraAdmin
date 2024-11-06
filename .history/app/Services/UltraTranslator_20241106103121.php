<?php

namespace App\Services;

use InvalidArgumentException;
use RuntimeException;
use App\Security\UltraSecurityValidator;
use App\Helpers\PathHelper;
class UltraTranslator
{
    private string $locale;
    private array $translations = [];
    private string $fallbackLocale;
    private array $allowedLocales;
    private array $cache = [];
    private const MAX_NESTING_LEVEL = 5;
    private const ALLOWED_PARAMETER_PATTERN = '/^[a-zA-Z0-9_]+$/';

    public function __construct(
        private readonly UltraSecurityValidator $securityValidator,
        string $locale = 'it',
        string $fallbackLocale = 'it'
    ) {
        $this->allowedLocales = $this->loadAllowedLocales();
        $this->validateLocale($locale);
        $this->validateLocale($fallbackLocale);
        
        $this->locale = $locale;
        $this->fallbackLocale = $fallbackLocale;
        $this->loadTranslations();
    }

    private function loadAllowedLocales(): array
    {
        $configPath = PathHelper::configPath('languages.php');
        if (!file_exists($configPath)) {
            throw new RuntimeException('Configuration file languages.php not found');
        }

        $locales = require $configPath;
        if (!is_array($locales) || empty($locales)) {
            throw new RuntimeException('Invalid language configuration');
        }

        return $locales;
    }

    private function validateLocale(string $locale): void
    {
        if (!in_array($locale, $this->allowedLocales, true)) {
            throw new InvalidArgumentException(
                sprintf('Locale %s is not allowed. Allowed locales: %s', 
                    $locale, 
                    implode(', ', $this->allowedLocales)
                )
            );
        }
    }

    private function loadTranslations(): void
    {
        $path = $this->getValidatedPath($this->locale);
        if (!is_dir($path)) {
            $path = $this->getValidatedPath($this->fallbackLocale);
        }

        foreach (glob($path . '/*.php') as $file) {
            if (!$this->securityValidator->isFileSecure($file)) {
                throw new RuntimeException("Security validation failed for file: $file");
            }

            $key = basename($file, '.php');
            $translations = require $file;
            
            if (!is_array($translations)) {
                throw new RuntimeException("Invalid translation file format: $file");
            }

            $this->translations[$key] = $this->sanitizeTranslations($translations);
        }
    }

    private function getValidatedPath(string $locale): string
    {
        $path = PathHelper::langPath($locale);
        
        // Prevent directory traversal
        if (strpos(realpath($path), PathHelper::langPath()) !== 0) {
            throw new RuntimeException('Invalid language path detected');
        }

        return $path;
    }

    private function sanitizeTranslations(array $translations, int $level = 0): array
    {
        if ($level >= self::MAX_NESTING_LEVEL) {
            throw new RuntimeException('Maximum nesting level reached in translations');
        }

        foreach ($translations as $key => $value) {
            if (!is_string($key) || !preg_match(self::ALLOWED_PARAMETER_PATTERN, $key)) {
                throw new InvalidArgumentException('Invalid translation key format');
            }

            if (is_array($value)) {
                $translations[$key] = $this->sanitizeTranslations($value, $level + 1);
            } elseif (!is_string($value)) {
                throw new InvalidArgumentException('Translation values must be strings');
            }
        }

        return $translations;
    }

    public function get(string $key, array $replace = []): string
    {
        $cacheKey = $this->locale . '.' . $key . '.' . md5(serialize($replace));
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $this->validateTranslationKey($key);
        $this->validateParameters($replace);

        $keys = explode('.', $key);
        $file = array_shift($keys);
        
        $translation = $this->translations[$file] ?? [];
        foreach ($keys as $segment) {
            $translation = $translation[$segment] ?? null;
            if ($translation === null) {
                // Log missing translation
                error_log("Missing translation for key: $key in {$this->locale}");
                return $this->fallbackLocale !== $this->locale ? 
                    $this->withLocale($this->fallbackLocale, fn() => $this->get($key, $replace)) : 
                    $key;
            }
        }

        $result = $this->replaceParameters($translation, $replace);
        $this->cache[$cacheKey] = $result;

        return $result;
    }

    private function validateTranslationKey(string $key): void
    {
        if (strlen($key) > 255) {
            throw new InvalidArgumentException('Translation key too long');
        }

        if (!preg_match('/^[a-zA-Z0-9_\.]+$/', $key)) {
            throw new InvalidArgumentException('Invalid translation key format');
        }
    }

    private function validateParameters(array $parameters): void
    {
        foreach ($parameters as $key => $value) {
            if (!is_string($key) || !preg_match(self::ALLOWED_PARAMETER_PATTERN, $key)) {
                throw new InvalidArgumentException('Invalid parameter key format');
            }

            if (!is_scalar($value)) {
                throw new InvalidArgumentException('Parameter values must be scalar');
            }
        }
    }

    private function replaceParameters(string $translation, array $replace): string
    {
        return preg_replace_callback('/:([a-zA-Z0-9_]+)/', function($matches) use ($replace) {
            $key = $matches[1];
            return $replace[$key] ?? $matches[0];
        }, $translation);
    }

    public function withLocale(string $locale, callable $callback)
    {
        $previousLocale = $this->locale;
        $this->setLocale($locale);

        try {
            return $callback();
        } finally {
            $this->setLocale($previousLocale);
        }
    }

    public function setLocale(string $locale): void
    {
        $this->validateLocale($locale);
        if ($this->locale !== $locale) {
            $this->locale = $locale;
            $this->cache = [];
            $this->loadTranslations();
        }
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
} 