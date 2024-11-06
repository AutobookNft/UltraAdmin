<?php

namespace App\Services\Logging;

use DateTime;

class UltraLogService
{
    protected $container;
    protected $logPath;
    protected $logLevel = 'info';

    public function __construct($container)
    {
        $this->container = $container;
        $this->logPath = __DIR__ . '/../../storage/logs/ultra.log';
    }

    public function log(string $message, string $level = 'info', array $context = []): void
    {
        $timestamp = (new DateTime())->format('Y-m-d H:i:s');
        $contextString = !empty($context) ? json_encode($context) : '';
        
        $logMessage = sprintf(
            "[%s] %s: %s %s\n",
            $timestamp,
            strtoupper($level),
            $message,
            $contextString
        );

        file_put_contents($this->logPath, $logMessage, FILE_APPEND);
    }

    public function info(string $message, array $context = []): void
    {
        $this->log($message, 'info', $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->log($message, 'error', $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->log($message, 'warning', $context);
    }

    public function debug(string $message, array $context = []): void
    {
        $this->log($message, 'debug', $context);
    }
} 