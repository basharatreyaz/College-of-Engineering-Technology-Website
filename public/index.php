<?php
declare(strict_types=1);

/**
 * KCET Website - Front Controller
 * Kashmir College of Engineering & Technology
 */

define('ROOT_PATH', dirname(__DIR__));

// Register PSR-4 autoloader for App namespace
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = ROOT_PATH . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Load helpers and environment
require_once ROOT_PATH . '/app/Helpers/helpers.php';

// Configure error reporting
$isDebug = (bool)env('APP_DEBUG', true);
if ($isDebug) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}

// Start session
\App\Services\Session::start();

// Production HTTP Security Headers
if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}

// Handle request
try {
    /** @var \App\Services\Router $router */
    $router = require_once ROOT_PATH . '/app/Routes/web.php';
    $router->dispatch();
} catch (\Throwable $e) {
    // Log exception to file
    $logDir = ROOT_PATH . '/storage/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    $logFile = $logDir . '/app.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "\n" . $e->getTraceAsString() . "\n\n";
    @file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);

    http_response_code(500);

    if ($isDebug) {
        echo "<!DOCTYPE html><html><head><title>Application Exception</title>";
        echo "<style>body{font-family:system-ui,-apple-system,sans-serif;background:#0f172a;color:#f8fafc;padding:30px;line-height:1.6;}";
        echo ".err-card{background:#1e293b;border-left:4px solid #ef4444;padding:24px;border-radius:8px;max-width:900px;margin:0 auto;}";
        echo "h1{color:#ef4444;margin-top:0;} pre{background:#0b1120;padding:16px;border-radius:6px;overflow-x:auto;color:#cbd5e1;font-size:13px;}</style></head><body>";
        echo "<div class='err-card'><h1>Application Exception</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " on line " . $e->getLine() . "</p>";
        echo "<h3>Stack Trace:</h3><pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre></div></body></html>";
    } else {
        echo "<!DOCTYPE html><html><head><title>500 Internal Error | KCET</title>";
        echo "<style>body{font-family:system-ui,-apple-system,sans-serif;text-align:center;padding:80px 20px;background:#f8fafc;color:#1e293b;}";
        echo "h1{font-size:48px;color:#0B2545;margin-bottom:10px;} p{font-size:18px;color:#64748b;max-width:500px;margin:0 auto 30px;}";
        echo "a{display:inline-block;padding:12px 24px;background:#0B2545;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;}</style></head><body>";
        echo "<h1>500 Internal Error</h1><p>We are experiencing a temporary technical glitch. Please try again or return to the homepage.</p>";
        echo "<a href='" . url('/') . "'>Return to KCET Homepage</a></body></html>";
    }
}

