<?php

namespace Fabio\UltraAdmin\Helpers;

class PathHelper
{
    protected static string $basePath;

    public static function setBasePath(string $path): void
    {
        self::$basePath = rtrim($path, DIRECTORY_SEPARATOR);
    }

    public static function basePath(string $append = ''): string
    {
        return self::$basePath . DIRECTORY_SEPARATOR . ltrim($append, DIRECTORY_SEPARATOR);
    }

    public static function publicPath(string $append = ''): string
    {
        return self::basePath('public' . DIRECTORY_SEPARATOR . $append);
    }

    public static function configPath(string $append = ''): string
    {
        return self::basePath('config' . DIRECTORY_SEPARATOR . $append);
    }

    public static function routesPath(string $append = ''): string
    {
        return self::basePath('routes' . DIRECTORY_SEPARATOR . $append);
    }

    public static function routesView(string $append = ''): string
    {
        return self::basePath('resources'. DIRECTORY_SEPARATOR .'views' . DIRECTORY_SEPARATOR . $append);
    }
}