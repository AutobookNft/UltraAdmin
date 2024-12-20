<?php

use Fabio\UltraAdmin\Helpers\PathHelper;
use Fabio\UltraAdmin\Utils\EnvLoader;
use Fabio\UltraSecureUpload\Logging\CustomizeFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;


return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    | Example: ERROR_MANAGER_LOG_CHANNEL=error_manager
    |
    */

    'default' => EnvLoader::get('ULTRA_SECURE_UPLOAD_LOG_CHANNEL', "'ultra_secure_upload'"),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'single' => [
            'driver' => 'single',
            'path' => PathHelper::basePath('logs/ultra_secure_upload.log'),
            'level' => 'debug',
        ],
        'error_manager' => [
            'driver' => 'daily',
            'path' => PathHelper::basePath('logs/ultra_secure_upload.log'),
            'level' => 'debug',
            'days' => 7,
        ],
    ],

];
