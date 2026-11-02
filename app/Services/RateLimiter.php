<?php
declare(strict_types=1);

namespace App\Services;

class RateLimiter
{
    private static string $cacheFile = '';

    private static function init(): void
    {
        if (empty(self::$cacheFile)) {
            self::$cacheFile = dirname(__DIR__, 2) . '/storage/logs/rate_limits.json';
        }
    }

    private static function getClientIp(): string
    {
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    public static function check(string $action, int $maxAttempts = 5, int $decaySeconds = 900): bool
    {
        self::init();
        $ip = self::getClientIp();
        $key = "{$action}:{$ip}";
        $data = self::readData();
        $now = time();

        if (isset($data[$key])) {
            $attempts = array_filter($data[$key], fn($time) => ($now - $time) < $decaySeconds);
            if (count($attempts) >= $maxAttempts) {
                return false;
            }
        }
        return true;
    }

    public static function hit(string $action, int $decaySeconds = 900): void
    {
        self::init();
        $ip = self::getClientIp();
        $key = "{$action}:{$ip}";
        $data = self::readData();
        $now = time();

        $attempts = isset($data[$key])
            ? array_filter($data[$key], fn($time) => ($now - $time) < $decaySeconds)
            : [];

        $attempts[] = $now;
        $data[$key] = $attempts;

        self::writeData($data);
    }

    public static function clear(string $action): void
    {
        self::init();
        $ip = self::getClientIp();
        $key = "{$action}:{$ip}";
        $data = self::readData();
        unset($data[$key]);
        self::writeData($data);
    }

    private static function readData(): array
    {
        if (!file_exists(self::$cacheFile)) {
            return [];
        }
        $content = @file_get_contents(self::$cacheFile);
        if (!$content) {
            return [];
        }
        $json = @json_decode($content, true);
        return is_array($json) ? $json : [];
    }

    private static function writeData(array $data): void
    {
        $dir = dirname(self::$cacheFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        @file_put_contents(self::$cacheFile, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
    }
}

