<?php
namespace App\Core;

class Cache {
    private static $cache = [];

    public static function get($key) {
        return self::$cache[$key] ?? null;
    }

    public static function set($key, $value, $ttl = 3600) {
        self::$cache[$key] = $value;
        // In production, use APCu or Redis
    }

    public static function clear() {
        self::$cache = [];
    }
}