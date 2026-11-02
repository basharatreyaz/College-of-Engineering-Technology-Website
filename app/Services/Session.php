<?php
declare(strict_types=1);

namespace App\Services;

class Session
{
    private static bool $started = false;

    public static function start(): void
    {
        if (self::$started || session_status() === PHP_SESSION_ACTIVE) {
            self::$started = true;
            return;
        }

        $lifetime = (int)env('ADMIN_SESSION_LIFETIME', 7200);
        $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

        session_set_cookie_params([
            'lifetime' => $lifetime,
            'path' => '/',
            'domain' => '',
            'secure' => $isSecure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        session_start();
        self::$started = true;

        // Auto expire if inactive
        if (isset($_SESSION['_last_activity']) && (time() - $_SESSION['_last_activity'] > $lifetime)) {
            self::destroy();
            session_start();
        }
        $_SESSION['_last_activity'] = time();
    }

    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function regenerate(): void
    {
        self::start();
        session_regenerate_id(true);
    }

    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }
            session_destroy();
            self::$started = false;
        }
    }

    public static function flash(?string $type = null, ?string $message = null): mixed
    {
        self::start();

        if ($type !== null && $message !== null) {
            $_SESSION['_flash'][$type] = $message;
            return null;
        }

        if ($type !== null) {
            $msg = $_SESSION['_flash'][$type] ?? null;
            unset($_SESSION['_flash'][$type]);
            return $msg;
        }

        $flashes = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
        return $flashes;
    }

    public static function setOld(array $data): void
    {
        self::start();
        // Don't store passwords or sensitive tokens in old input
        unset($data['password'], $data['password_confirmation'], $data['csrf_token']);
        $_SESSION['_old_input'] = $data;
    }

    public static function getOld(string $key, mixed $default = ''): mixed
    {
        self::start();
        return $_SESSION['_old_input'][$key] ?? $default;
    }

    public static function clearOld(): void
    {
        self::start();
        unset($_SESSION['_old_input']);
    }
}

