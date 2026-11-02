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

$routes = [
    '/chairmans-message',
    '/directors-message',
    '/principals-message',
    '/about',
    '/admissions',
    '/programmes',
    '/faculty',
    '/apply-success'
];

$standard = 'linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%)';

echo "Verifying page heading backgrounds across routes:\n";
$allMatch = true;

foreach ($routes as $route) {
    ob_start();
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $route;
    $_GET = [];
    $_POST = [];
    
    $router = require ROOT_PATH . '/app/Routes/web.php';
    $router->dispatch();
    $output = ob_get_clean();

    if (strpos($output, $standard) !== false) {
        echo "  [PASS] $route uses standard collegiate gradient\n";
    } else {
        echo "  [FAIL] $route DOES NOT use standard collegiate gradient!\n";
        $allMatch = false;
    }
}

if ($allMatch) {
    echo "\nSUCCESS: All page heading backgrounds are 100% unified!\n";
    exit(0);
} else {
    echo "\nERROR: Some page heading backgrounds differ!\n";
    exit(1);
}
