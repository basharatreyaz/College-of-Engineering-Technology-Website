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

echo "--- Testing Sticky Sidebars ---\n";

// 1. Leadership Messages Sidebar
ob_start();
(new \App\Controllers\LeadershipController())->chairman();
$chairmanHtml = ob_get_clean();

if (str_contains($chairmanHtml, 'class="leader-sidebar"')) {
    echo "  [PASS] /chairmans-message renders <aside class=\"leader-sidebar\">\n";
} else {
    echo "  [FAIL] /chairmans-message missing leader-sidebar class\n";
}

// 2. Programme Detail Sidebar
ob_start();
(new \App\Controllers\ProgrammeController())->show('b-tech-artificial-intelligence-engineering');
$progHtml = ob_get_clean();

if (str_contains($progHtml, 'class="programme-sidebar"')) {
    echo "  [PASS] /programmes/{slug} renders <aside class=\"programme-sidebar\">\n";
} else {
    echo "  [FAIL] /programmes/{slug} missing programme-sidebar class\n";
}

// 3. CSS Rules Check
$css = file_get_contents(ROOT_PATH . '/public/assets/css/style.css');
if (str_contains($css, '.leader-sidebar') && str_contains($css, 'position: sticky')) {
    echo "  [PASS] style.css defines sticky positioning for .leader-sidebar\n";
} else {
    echo "  [FAIL] style.css missing sticky definition for .leader-sidebar\n";
}

if (str_contains($css, '.programme-sidebar') && str_contains($css, 'position: sticky')) {
    echo "  [PASS] style.css defines sticky positioning for .programme-sidebar\n";
} else {
    echo "  [FAIL] style.css missing sticky definition for .programme-sidebar\n";
}

if (str_contains($css, '@media (max-width: 991px)') && str_contains($css, '.detail-layout-grid')) {
    echo "  [PASS] style.css defines mobile/tablet 1-column collapse for .detail-layout-grid\n";
} else {
    echo "  [FAIL] style.css missing responsive collapse for .detail-layout-grid\n";
}

