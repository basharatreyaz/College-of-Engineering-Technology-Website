<?php
declare(strict_types=1);

/**
 * KCET Downloads & Syllabi Test Suite
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
\App\Services\Session::start();

echo "========================================================\n";
echo "   KCET Downloads & Branch/Semester Syllabi Tests\n";
echo "========================================================\n";

$passCount = 0;
$failCount = 0;

function assertDownloadTest(string $description, bool $condition): void {
    global $passCount, $failCount;
    if ($condition) {
        echo "  [PASS] {$description}\n";
        $passCount++;
    } else {
        echo "  [FAIL] {$description}\n";
        $failCount++;
    }
}

// 1. Verify all 46 PDF files exist on disk
$db = \App\Services\Database::getInstance();
$downloads = $db->query("SELECT * FROM downloads WHERE is_active = 1");
assertDownloadTest("Database has downloads records", count($downloads) >= 40);

$missingFiles = 0;
foreach ($downloads as $d) {
    $filePath = ROOT_PATH . '/public/' . $d['file_path'];
    if (!file_exists($filePath) || filesize($filePath) === 0) {
        $missingFiles++;
        echo "    Missing file: {$filePath}\n";
    }
}
assertDownloadTest("All downloadable PDF files physically exist with non-zero size (0 missing)", $missingFiles === 0);

// 2. Test Router & Downloads View Rendering
$router = require ROOT_PATH . '/app/Routes/web.php';

$testUrls = [
    '/downloads' => 'Downloads root',
    '/syllabus' => 'Syllabus dedicated root',
    '/syllabus/ai' => 'Syllabus AI dedicated route',
    '/syllabus/ce' => 'Syllabus CE dedicated route',
    '/downloads?cat=syllabus&branch=ai' => 'AI Branch Syllabus',
    '/downloads?cat=syllabus&branch=ce' => 'Computer Engineering Syllabus',
    '/downloads?cat=syllabus&branch=civil' => 'Civil Engineering Syllabus',
    '/downloads?cat=syllabus&branch=it' => 'Information Technology Syllabus',
    '/downloads?cat=syllabus&branch=ece' => 'Electronics & Communication Syllabus',
    '/downloads?cat=syllabus&branch=common' => 'Common 1st Year Syllabus',
    '/downloads?cat=prospectus' => 'Prospectus category',
    '/downloads?cat=forms' => 'Application forms category',
    '/downloads?cat=circular' => 'Circulars & Ordinances category',
];

foreach ($testUrls as $url => $label) {
    $parsed = parse_url($url);
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $parsed['path'];
    $_GET = [];
    if (!empty($parsed['query'])) {
        parse_str($parsed['query'], $_GET);
    }

    ob_start();
    try {
        $router->dispatch();
        $html = ob_get_clean();
        $hasContent = strlen($html) > 5000 && !str_contains($html, '404 - Page Not Found');
        assertDownloadTest("Route {$label} ({$url}) renders correctly", $hasContent);
    } catch (\Throwable $e) {
        ob_end_clean();
        assertDownloadTest("Route {$label} failed: " . $e->getMessage(), false);
    }
}

// 3. Test Structured Syllabus Data
$branches = \App\Services\SyllabusData::getBranches();
assertDownloadTest("SyllabusData returns 6 branch definitions", count($branches) === 6);

foreach (['ai', 'ce', 'civil', 'it', 'ece', 'common'] as $b) {
    assertDownloadTest("Branch '{$b}' is properly defined with semesters", isset($branches[$b]['semesters']) && count($branches[$b]['semesters']) >= 2);
}

echo "========================================================\n";
echo "   Test Results: {$passCount} Passed, {$failCount} Failed\n";
echo "========================================================\n";

if ($failCount > 0) exit(1);

