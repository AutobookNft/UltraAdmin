<?php

namespace App\UConfig;

use App\UConfig\Contracts\ConfigInterface;
use App\UConfig\Types\DatabaseConfig;
use Fabio\UltraAdmin\UConfig\Types\DatabaseTableConfig;
use Fabio\UltraAdmin\UConfig\Types\GenericConfig;
use Fabio\UltraAdmin\UConfig\Types\LoggingConfig;
use Fabio\UltraAdmin\Utils\EnvLoader;

class UConfig
{
    // Array per memorizzare le istanze delle configurazioni
    protected static array $configInstances = [];

    // Directory di configurazione
    protected static string $configDir = __DIR__ . '/../../config/';

    protected static array $modifiedConfig = [];

    /**
     * Carica e valida una configurazione specifica basata sul tipo
     *
     * @param string $configType
     * @return ConfigInterface
     * @throws \Exception
     */
    public static function load(string $configType): ConfigInterface
    {
        if (!isset(self::$configInstances[$configType])) {
            $configClass = self::getConfigClass($configType);

            // Crea l'istanza della configurazione e carica i dati
            $configInstance = new $configClass();
            $configInstance->load();
            $configInstance->validate();

            // Salva l'istanza nel cache delle configurazioni
            self::$configInstances[$configType] = $configInstance;
        }

        return self::$configInstances[$configType];
    }

    /**
     * Ottiene la classe di configurazione corrispondente al tipo specificato
     *
     * @param string $configType
     * @return string
     * @throws \Exception
     */
    protected static function getConfigClass(string $configType): string
    {
        // Mappa dei tipi di configurazione ai nomi delle classi
        $configMapping = [
            'logging' => LoggingConfig::class,
            'database' => DatabaseConfig::class,
            'generic' => GenericConfig::class,
            'database_table' => DatabaseTableConfig::class,
        ];

        if (!isset($configMapping[$configType])) {
            throw new \Exception("Tipo di configurazione {$configType} non trovato.");
        }

        return $configMapping[$configType];
    }

    /**
     * Setta dinamicamente un valore di configurazione e aggiorna il file di configurazione
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value): void
    {
        try {
            $keys = explode('.', $key);
            $config = &self::$configInstances;
            $modifiedConfig = &self::$modifiedConfig;

            foreach ($keys as $k) {
                if (!isset($config[$k])) {
                    $config[$k] = [];
                }
                $config = &$config[$k];
                $modifiedConfig = &$modifiedConfig[$k]; // Tiene traccia solo dei cambiamenti
            }

            $oldValue = $config;
            $config = $value;
            $modifiedConfig = $value; // Registra l’aggiornamento
            self::logChange($key, $oldValue, $value); // Registra la modifica nel log
            self::persistConfigToFile();  // Salva le modifiche su file

        } catch (\Exception $e) {
            throw new \Exception("Errore durante l'impostazione della configurazione per la chiave '{$key}': " . $e->getMessage());
        }
    }

    /**
     * Persiste le modifiche di configurazione aggiornate su file
     *
     * @return void
     */
    protected static function persistConfigToFile(): void
    {
        $path = self::$configDir . 'dynamic_config.php';
        if (!empty(self::$modifiedConfig)) {
            file_put_contents($path, "<?php\n return " . var_export(self::$modifiedConfig, true) . ";\n");
            self::$modifiedConfig = []; // Resetta le modifiche dopo il salvataggio
        }
    }
    
    public static function logChange(string $key, $oldValue, $newValue): void
    {
        $logMessage = sprintf(
            "[%s] Configurazione '%s' modificata\nVecchio valore: '%s'\nNuovo valore: '%s'\n\n",
            date('Y-m-d H:i:s'),
            $key,
            json_encode($oldValue),
            json_encode($newValue)
        );
    
        file_put_contents(self::$configDir . 'config_changes.log', $logMessage, FILE_APPEND);
    }

    /**
     * Ricerca nelle configurazioni che contengono un termine specifico, anche in array annidati
     *
     * @param string $term
     * @param array $array
     * @param string $path
     * @return array
     */
    protected static function recursiveSearch(string $term, array $array, string $path = ''): array
    {
        $results = [];

        foreach ($array as $key => $value) {
            $currentPath = $path ? "{$path}.{$key}" : $key;

            if (is_string($value) && stripos($value, $term) !== false) {
                $results[$currentPath] = $value;
            } elseif (is_array($value)) {
                $results = array_merge($results, self::recursiveSearch($term, $value, $currentPath));
            }
        }

        return $results;
    }

    public static function search(string $term): array
    {
        return self::recursiveSearch($term, self::$configInstances);
    }

    /**
     * Cifra un valore sensibile
     *
     * @param string $value
     * @return string
     */
    public static function encryptValue(string $value): string
    {
        $key = EnvLoader::get('ENCRYPTION_KEY');
        $iv = EnvLoader::get('ENCRYPTION_IV');
        return openssl_encrypt($value, 'aes-256-cbc', $key, 0, $iv);
    }

    /**
     * Decifra un valore sensibile
     *
     * @param string $encrypted
     * @return string
     */
    public static function decryptValue(string $encrypted): string
    {
        $key = EnvLoader::get('ENCRYPTION_KEY');
        $iv = EnvLoader::get('ENCRYPTION_IV');
        return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
    }



    /**
     * Setta un valore di configurazione criptato
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public static function setSecure(string $key, string $value): void
    {
        self::set($key, self::encryptValue($value));
    }

    /**
     * Ottiene un valore di configurazione criptato
     *
     * @param string $key
     * @return string
     */
    public static function getSecure(string $key): string
    {
        $encryptedValue = self::$configInstances[$key] ?? null;
        return $encryptedValue ? self::decryptValue($encryptedValue) : null;
    }
}

