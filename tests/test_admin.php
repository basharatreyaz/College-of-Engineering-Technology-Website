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

// Authenticate session as superadmin
\App\Services\Session::set('admin_user', [
    'id' => 1,
    'name' => 'Principal / Super Admin',
    'email' => 'admin@kcet.edu.in',
    'role' => 'superadmin',
    'status' => 'active'
]);

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin';
$_GET = [];
$_POST = [];

ob_start();
$router = require ROOT_PATH . '/app/Routes/web.php';
$router->dispatch();
$output = ob_get_clean();

if (str_contains($output, 'Institutional Dashboard') && str_contains($output, 'Recent Admission Applications')) {
    echo "ADMIN_DASHBOARD_OK\n";
    exit(0);
} else {
    echo "ADMIN_DASHBOARD_FAIL\n";
    echo substr($output, 0, 500);
    exit(1);
}

