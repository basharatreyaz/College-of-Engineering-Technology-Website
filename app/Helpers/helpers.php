<?php
declare(strict_types=1);

/**
 * Global Helper Functions for KCET Website
 */

if (!function_exists('loadEnv')) {
    function loadEnv(string $envFile): void
    {
        if (!file_exists($envFile)) {
            return;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }
            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                // Strip quotes if present
                if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                    (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
                    $value = substr($value, 1, -1);
                }
                if (!array_key_exists($key, $_ENV)) {
                    $_ENV[$key] = $value;
                    putenv("{$key}={$value}");
                }
            }
        }
    }
}

// Auto-load .env
$envPath = dirname(__DIR__, 2) . '/.env';
if (file_exists($envPath)) {
    loadEnv($envPath);
}

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $val = $_ENV[$key] ?? getenv($key);
        if ($val === false || $val === null) {
            return $default;
        }
        $lower = strtolower((string)$val);
        if ($lower === 'true') return true;
        if ($lower === 'false') return false;
        if ($lower === 'null') return null;
        return $val;
    }
}

if (!function_exists('e')) {
    /**
     * Escape HTML output securely.
     */
    function e(mixed $value): string
    {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('getBaseUrl')) {
    /**
     * Determine application base path dynamically or from APP_URL.
     */
    function getBaseUrl(): string
    {
        static $baseUrl = null;
        if ($baseUrl !== null) {
            return $baseUrl;
        }

        $appUrl = env('APP_URL');
        if (!empty($appUrl)) {
            // Parse path from APP_URL
            $parsed = parse_url($appUrl, PHP_URL_PATH);
            $baseUrl = rtrim($parsed ?? '', '/');
            return $baseUrl;
        }

        if (isset($_SERVER['SCRIPT_NAME'])) {
            $dir = dirname($_SERVER['SCRIPT_NAME']);
            $baseUrl = ($dir === '/' || $dir === '\\') ? '' : str_replace('\\', '/', $dir);
            return $baseUrl;
        }

        $baseUrl = '';
        return $baseUrl;
    }
}

if (!function_exists('url')) {
    /**
     * Generate an application URL.
     */
    function url(string $path = ''): string
    {
        $base = getBaseUrl();
        $path = '/' . ltrim($path, '/');
        
        // Return relative to web root or complete URL
        $full = ($base === '') ? $path : $base . $path;
        return $full === '' ? '/' : $full;
    }
}

if (!function_exists('asset')) {
    /**
     * Generate URL for public asset.
     */
    function asset(string $path): string
    {
        $path = ltrim($path, '/');
        return url('/' . $path);
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to another URL and exit.
     */
    function redirect(string $path, int $statusCode = 302): never
    {
        $target = str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
            ? $path
            : url($path);

        header("Location: {$target}", true, $statusCode);
        exit;
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Retrieve current CSRF token.
     */
    function csrf_token(): string
    {
        return \App\Services\Csrf::getToken();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF hidden input element.
     */
    function csrf_field(): string
    {
        $token = csrf_token();
        return '<input type="hidden" name="csrf_token" value="' . e($token) . '">';
    }
}

if (!function_exists('flash')) {
    /**
     * Set or get flash messages.
     */
    function flash(?string $type = null, ?string $message = null): mixed
    {
        return \App\Services\Session::flash($type, $message);
    }
}

if (!function_exists('old')) {
    /**
     * Retrieve previous form submission value.
     */
    function old(string $field, mixed $default = ''): mixed
    {
        return \App\Services\Session::getOld($field, $default);
    }
}

if (!function_exists('format_date')) {
    /**
     * Safe date formatting helper.
     */
    function format_date(?string $date, string $format = 'd M, Y'): string
    {
        if (empty($date)) {
            return '';
        }
        try {
            $dt = new \DateTime($date);
            return $dt->format($format);
        } catch (\Throwable) {
            return $date;
        }
    }
}

if (!function_exists('slugify')) {
    /**
     * Generate URL-friendly slug.
     */
    function slugify(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }
}

if (!function_exists('truncate')) {
    /**
     * Truncate string to specified length.
     */
    function truncate(?string $text, int $length = 140, string $append = '...'): string
    {
        if ($text === null) return '';
        $text = strip_tags($text);
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        return mb_substr($text, 0, $length) . $append;
    }
}

if (!function_exists('auth_user')) {
    /**
     * Get currently logged-in user.
     */
    function auth_user(): ?array
    {
        return \App\Services\Session::get('admin_user');
    }
}

if (!function_exists('has_role')) {
    /**
     * Check if authenticated user has one of the specified roles.
     */
    function has_role(string ...$roles): bool
    {
        $user = auth_user();
        if (!$user) {
            return false;
        }
        return in_array($user['role'], $roles, true);
    }
}

if (!function_exists('setting')) {
    /**
     * Get site setting value from database or fallback.
     */
    function setting(string $key, mixed $default = ''): mixed
    {
        static $settings = null;
        if ($settings === null) {
            try {
                $db = \App\Services\Database::getInstance();
                $rows = $db->query("SELECT setting_key, setting_value FROM site_settings");
                $settings = [];
                foreach ($rows as $row) {
                    $settings[$row['setting_key']] = $row['setting_value'];
                }
            } catch (\Throwable) {
                $settings = [];
            }
        }
        return $settings[$key] ?? $default;
    }
}

