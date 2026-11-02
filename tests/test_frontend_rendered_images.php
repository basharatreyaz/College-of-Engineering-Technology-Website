<?php
/**
 * Test Frontend Rendered Images across all public routes
 */
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

// Mock session
\App\Services\Session::start();

// Router & App
$routes = [
    '/',
    '/about',
    '/programmes',
    '/programmes/b-tech-artificial-intelligence-engineering',
    '/programmes/b-tech-computer-engineering',
    '/programmes/b-tech-civil-engineering',
    '/programmes/b-tech-information-technology',
    '/programmes/b-tech-electronics-communication-engineering',
    '/departments',
    '/departments/computer-engineering',
    '/departments/artificial-intelligence-engineering',
    '/departments/civil-engineering',
    '/facilities',
    '/facilities/spacious-library',
    '/facilities/canteen-and-cafeteria',
    '/facilities/transport-facility',
    '/facilities/dedicated-100-mbps-internet',
    '/facilities/multipurpose-hall',
    '/facilities/computer-centre',
    '/faculty',
    '/admissions',
    '/apply',
    '/campus-life',
    '/events',
    '/events/inauguration-by-honble-lt-governor',
    '/events/annual-technical-boot-camp-2026',
    '/events/academic-induction-and-campus-orientation',
    '/notices',
    '/downloads',
    '/contact',
    '/careers',
    '/privacy',
    '/terms',
    '/chairmans-message',
    '/directors-message',
    '/principals-message'
];

$brokenOnFrontend = [];
$totalImagesChecked = 0;
$renderedImages = [];

$base = getBaseUrl(); // e.g. /kcet/public

foreach ($routes as $uri) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $uri;
    $_GET = [];
    $_POST = [];
    
    ob_start();
    try {
        $router = require ROOT_PATH . '/app/Routes/web.php';
        $router->dispatch();
        $html = ob_get_clean();
    } catch (\Throwable $e) {
        ob_end_clean();
        echo "Error visiting $uri: " . $e->getMessage() . "\n";
        continue;
    }

    // Extract all img src
    if (preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches)) {
        foreach ($matches[1] as $src) {
            $totalImagesChecked++;
            if (str_starts_with($src, 'data:') || str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
                continue;
            }
            $cleanPath = parse_url($src, PHP_URL_PATH);
            if ($base !== '' && str_starts_with($cleanPath, $base)) {
                $cleanPath = substr($cleanPath, strlen($base));
            }
            $cleanPath = ltrim($cleanPath, '/');
            $diskPath = ROOT_PATH . '/public/' . $cleanPath;
            $renderedImages[$cleanPath] = file_exists($diskPath);
            if (!file_exists($diskPath)) {
                $brokenOnFrontend[] = [
                    'route' => $uri,
                    'src' => $src,
                    'diskPath' => $diskPath
                ];
            }
        }
    }
}

echo "=== FRONTEND PAGES RENDER TEST ===\n";
echo "Total image tags checked across " . count($routes) . " routes: $totalImagesChecked\n";
echo "Unique images rendered: " . count($renderedImages) . "\n";
echo "Broken images found: " . count($brokenOnFrontend) . "\n\n";

if (!empty($brokenOnFrontend)) {
    echo "BROKEN IMAGES ON FRONTEND:\n";
    $uniqueBroken = [];
    foreach ($brokenOnFrontend as $b) {
        $uniqueBroken[$b['src']][] = $b['route'];
    }
    foreach ($uniqueBroken as $src => $routes) {
        echo "  [BROKEN] " . $src . " (on " . count($routes) . " routes: " . implode(', ', array_slice($routes, 0, 3)) . ")\n";
    }
} else {
    echo "SUCCESS: ZERO broken images found across all frontend pages!\n";
}

