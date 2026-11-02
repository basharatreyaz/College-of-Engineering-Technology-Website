<?php
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

$missing = [];
$found = [];

// 1. Scan views for hardcoded images
$viewFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ROOT_PATH . '/app/Views'));
foreach ($viewFiles as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getRealPath());
        
        // Find asset('assets/images/...')
        preg_match_all('/asset\(["\'](assets\/images\/[^"\']+)["\']\)/', $content, $m);
        foreach ($m[1] as $relPath) {
            $fullPath = ROOT_PATH . '/public/' . $relPath;
            if (!file_exists($fullPath)) {
                $missing[] = ['source' => 'View: ' . $file->getFilename(), 'path' => $relPath];
            } else {
                $found[$relPath] = true;
            }
        }
    }
}

// 2. Scan database tables for image references
$db = \App\Services\Database::getInstance()->getPdo();

$tables = [
    'facilities' => ['image', 'title'],
    'events' => ['featured_image', 'title'],
    'gallery_items' => ['image_url', 'title'],
    'faculty' => ['photo', 'name'],
    'departments' => ['hod_photo', 'name'],
];

foreach ($tables as $tbl => [$col, $nameCol]) {
    $rows = $db->query("SELECT id, $nameCol AS label, $col AS img FROM $tbl WHERE $col IS NOT NULL AND $col != ''")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $img = $row['img'];
        $fullPath = ROOT_PATH . '/public/' . ltrim($img, '/');
        if (!file_exists($fullPath)) {
            $missing[] = ['source' => "Table $tbl (ID {$row['id']} - {$row['label']})", 'path' => $img];
        } else {
            $found[$img] = true;
        }
    }
}

// 3. Scan CSS files for url(...)
$cssFiles = glob(ROOT_PATH . '/public/assets/css/*.css');
foreach ($cssFiles as $css) {
    $content = file_get_contents($css);
    preg_match_all('/url\(["\']?([^"\'\)]+)["\']?\)/', $content, $m);
    foreach ($m[1] as $rel) {
        if (str_starts_with($rel, 'data:') || str_starts_with($rel, 'http')) continue;
        $fullPath = realpath(dirname($css) . '/' . $rel);
        if (!$fullPath || !file_exists($fullPath)) {
            $missing[] = ['source' => 'CSS: ' . basename($css), 'path' => $rel];
        } else {
            $found[$rel] = true;
        }
    }
}

echo "=== IMAGE INTEGRITY REPORT ===\n";
echo "Total verified existing images: " . count($found) . "\n";
echo "Total missing image references: " . count($missing) . "\n\n";

if (!empty($missing)) {
    echo "MISSING IMAGES:\n";
    foreach ($missing as $item) {
        echo "  [MISSING] {$item['source']} -> {$item['path']}\n";
    }
} else {
    echo "All image references are valid and exist on disk!\n";
}
