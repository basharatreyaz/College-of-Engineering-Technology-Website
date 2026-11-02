<?php
declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = ROOT_PATH . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) require_once $file;
});

require_once ROOT_PATH . '/app/Helpers/helpers.php';
\App\Services\Session::start();

$router = require ROOT_PATH . '/app/Routes/web.php';

$startRoutes = [
    '/',
    '/about',
    '/programmes',
    '/departments',
    '/faculty',
    '/facilities',
    '/campus-life',
    '/events',
    '/notices',
    '/admissions',
    '/apply',
    '/careers',
    '/downloads',
    '/contact',
    '/privacy',
    '/terms',
    '/chairmans-message',
    '/directors-message',
    '/principals-message'
];

$allInternalLinks = [];
$brokenLinks = [];

foreach ($startRoutes as $route) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $route;
    $_GET = [];
    $_POST = [];

    ob_start();
    try {
        $router->dispatch();
        $html = ob_get_clean();
    } catch (\Throwable $e) {
        ob_end_clean();
        continue;
    }

    preg_match_all('/href=["\']([^"\']+)["\']/i', $html, $matches);
    foreach ($matches[1] as $href) {
        $href = trim($href);
        if (str_starts_with($href, 'http://') || str_starts_with($href, 'https://') ||
            str_starts_with($href, 'tel:') || str_starts_with($href, 'mailto:') ||
            str_starts_with($href, 'javascript:') || str_starts_with($href, '#') || empty($href)) {
            continue;
        }

        $path = parse_url($href, PHP_URL_PATH);
        if ($path && !in_array($path, $allInternalLinks)) {
            $allInternalLinks[] = $path;
        }
    }
}

foreach ($allInternalLinks as $rawPath) {
    $path = str_replace('/kcet/public', '', $rawPath);
    if ($path === '') $path = '/';

    if (str_starts_with($path, '/assets/') || str_starts_with($path, '/admin') || str_ends_with($path, '.png') || str_ends_with($path, '.jpg') || str_ends_with($path, '.svg') || str_ends_with($path, '.ico') || str_ends_with($path, '.pdf') || str_ends_with($path, '.xml') || str_contains($path, 'logout') || str_contains($path, 'sitemap') || str_contains($path, 'favicon')) {
        continue;
    }

    echo "Testing $path...\n";
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $path;
    $_GET = [];
    $_POST = [];

    ob_start();
    try {
        @$router->dispatch();
        $output = ob_get_clean();
        if (str_contains($output, '404 - Page Not Found') || str_contains($output, 'The page you requested')) {
            $brokenLinks[] = "Broken link (returns 404): $path";
        }
    } catch (\Throwable $e) {
        ob_end_clean();
        $brokenLinks[] = "Crash on $path: " . $e->getMessage();
    }
}

if (empty($brokenLinks)) {
    echo "SUCCESS: All " . count($allInternalLinks) . " internal links resolve correctly! 0 broken links.\n";
    exit(0);
} else {
    echo "WARNING: Found broken links:\n";
    foreach ($brokenLinks as $bl) {
        echo "  - $bl\n";
    }
    exit(1);
}
