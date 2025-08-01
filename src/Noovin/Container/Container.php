<?php

namespace Noovin\Container;

class Container
{
    private static array $instances = [];

    public static function singleton(string $class): object
    {
        if (! array_key_exists($class, self::$instances)) {
            self::$instances[$class] = new $class;
        }

        return self::$instances[$class];
    }

    public static function resolve(string $class): object|null
    {
        return self::$instances[$class] ?? null;
    }
}
