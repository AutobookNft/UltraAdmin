<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita344bc2a5acd8d94ae5d0828808545b8
{
    public static $files = array (
        '97069e3c80a316f27efb182f47936d12' => __DIR__ . '/../..' . '/config/LoggerConfig.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'F' => 
        array (
            'Fabio\\UltraAdmin\\' => 17,
        ),
        'C' => 
        array (
            'Config\\' => 7,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'Fabio\\UltraAdmin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/config',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita344bc2a5acd8d94ae5d0828808545b8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita344bc2a5acd8d94ae5d0828808545b8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita344bc2a5acd8d94ae5d0828808545b8::$classMap;

        }, null, ClassLoader::class);
    }
}
