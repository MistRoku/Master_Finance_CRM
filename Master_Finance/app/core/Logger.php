<?php
namespace App\Core;

class Logger {
    public static function log($message, $level = 'INFO') {
        $logFile = __DIR__ . '/../../app/logs/app.log';
        $timestamp = date('Y-m-d H:i:s');
        $entry = "[$timestamp] [$level] $message" . PHP_EOL;
        file_put_contents($logFile, $entry, FILE_APPEND);
    }

    public static function error($message) {
        self::log($message, 'ERROR');
    }
}