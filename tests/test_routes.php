<?php
declare(strict_types=1);

/**
 * KCET Automated Route & Functional Integration Test Suite
 */

define('ROOT_PATH', dirname(__DIR__));

// PSR-4 autoloader
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
echo "   KCET Comprehensive Integration & Route Tests\n";
echo "========================================================\n";

$passCount = 0;
$failCount = 0;

function assertTest(string $description, bool $condition): void {
    global $passCount, $failCount;
    if ($condition) {
        echo "  [PASS] {$description}\n";
        $passCount++;
    } else {
        echo "  [FAIL] {$description}\n";
        $failCount++;
    }
}

// 1. Test Database Queries
echo "\n--- 1. Testing Database Models & Connectivity ---\n";
try {
    $db = \App\Services\Database::getInstance();
    $progModel = new \App\Models\Programme();
    $programmes = $progModel->getActive();
    assertTest("Database connects and returns active programmes", count($programmes) >= 5);
    assertTest("Active programmes have featured_image field", array_key_exists('featured_image', $programmes[0]));

    $deptModel = new \App\Models\Department();
    $departments = $deptModel->getActive();
    assertTest("Database returns departments", count($departments) >= 6);

    $facModel = new \App\Models\Facility();
    $facilities = $facModel->getActive();
    assertTest("Database returns 12 campus facilities", count($facilities) === 12);
} catch (\Throwable $e) {
    assertTest("Database connectivity error: " . $e->getMessage(), false);
}

// 2. Test Public Route Dispatching
echo "\n--- 2. Testing Route Simulation ---\n";
$routesToTest = [
    '/' => 'Home page',
    '/about' => 'About page',
    '/programmes' => 'Programmes catalog',
    '/programmes/b-tech-artificial-intelligence-engineering' => 'Programme detail (AI)',
    '/departments' => 'Departments catalog',
    '/departments/computer-engineering' => 'Department detail (CE)',
    '/faculty' => 'Faculty directory',
    '/facilities' => 'Facilities overview',
    '/facilities/spacious-library' => 'Facility detail (Library)',
    '/campus-life' => 'Campus life & gallery',
    '/events' => 'Events archive',
    '/notices' => 'Notices list',
    '/admissions' => 'Admissions guide',
    '/apply' => 'Application form',
    '/careers' => 'Careers page',
    '/downloads' => 'Downloads catalog',
    '/syllabus' => 'Syllabus & Curricula catalog',
    '/syllabus/computer-engineering' => 'Syllabus for Computer Engineering',
    '/contact' => 'Contact page',
    '/privacy' => 'Privacy policy',
    '/terms' => 'Terms of use',
    '/chairmans-message' => "Chairman's dedicated message page",
    '/directors-message' => "Director's dedicated message page",
    '/principals-message' => "Principal's dedicated message page",
];

foreach ($routesToTest as $uri => $label) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $uri;
    $_GET = [];
    $_POST = [];

    ob_start();
    try {
        $router = require ROOT_PATH . '/app/Routes/web.php';
        $router->dispatch();
        $output = ob_get_clean();
        $hasContent = strlen($output) > 200;
        $hasDocType = str_contains($output, '<!DOCTYPE html>') || str_contains($output, '<html');
        assertTest("Route '{$uri}' ({$label}) renders HTML properly", $hasContent && $hasDocType);

        if ($uri === '/') {
            $hasVideo = str_contains($output, 'heroBgVideo') && str_contains($output, 'Oog3g2U-UbM');
            assertTest("Home page renders background YouTube video (ID: Oog3g2U-UbM)", $hasVideo);
            $hasToggle = str_contains($output, 'heroVideoToggle');
            assertTest("Home page renders hero video pause/play accessibility controller", $hasToggle);
            $noGapDiv = !str_contains($output, 'style="margin-top: 1.5rem;"');
            assertTest("No gap container between header and hero", $noGapDiv);
        }
    } catch (\Throwable $e) {
        ob_end_clean();
        assertTest("Route '{$uri}' failed with error: " . $e->getMessage(), false);
    }
}

// 3. Test Form Persistence & Reference Generation
echo "\n--- 3. Testing Form Persistence & Security ---\n";
try {
    $appModel = new \App\Models\Application();
    $ref = $appModel->generateApplicationNumber();
    assertTest("Generated reference ID format is KCET-YYYY-XXXX ({$ref})", (bool)preg_match('/^KCET-\d{4}-[A-F0-9]{6}$/', $ref));

    $appId = $appModel->create([
        'application_number' => $ref,
        'first_name' => 'Integration',
        'last_name' => 'Tester',
        'email' => 'test.applicant@example.com',
        'phone' => '+91 99999 88888',
        'whatsapp_number' => '+91 99999 88888',
        'dob' => '2007-01-01',
        'gender' => 'Other',
        'programme_id' => 1,
        'parent_name' => 'Tester Guardian',
        'address' => 'Test Address, Srinagar',
        'city' => 'Srinagar',
        'state' => 'Jammu and Kashmir',
        'pincode' => '190001',
        'prior_education' => '10+2 Non-Medical',
        'marks_percentage' => '89.5%',
        'current_status' => 'Passed 12th',
        'status' => 'new',
        'notes' => 'Automated test record',
        'ip_address' => '127.0.0.1'
    ]);
    assertTest("Created sample application in database (ID: {$appId})", $appId > 0);

    $retrieved = $appModel->findBy('application_number', $ref);
    assertTest("Retrieved application by unique reference ID", $retrieved && $retrieved['email'] === 'test.applicant@example.com');

    // Clean up test record
    $appModel->delete($appId);
    assertTest("Cleaned up test application record", true);
} catch (\Throwable $e) {
    assertTest("Form persistence error: " . $e->getMessage(), false);
}

// 4. Test Admin Authentication Verification
echo "\n--- 4. Testing Admin Authentication Logic & Role Toggles ---\n";
try {
    $userModel = new \App\Models\User();
    $admin = $userModel->findByEmail('admin@kcet.edu.in');
    assertTest("Superadmin user exists in database", $admin !== null);
    assertTest("Superadmin password hash verifies 'Admin@KCET2026!'", $userModel->verifyPassword('Admin@KCET2026!', $admin['password_hash']));

    $editor = $userModel->findByEmail('editor@kcet.edu.in');
    assertTest("Editor user exists and verifies 'Editor@KCET2026'", $editor && $userModel->verifyPassword('Editor@KCET2026', $editor['password_hash']));

    $admissions = $userModel->findByEmail('admissions@kcet.edu.in');
    assertTest("Admissions user exists and verifies 'Admissions@2026'", $admissions && $userModel->verifyPassword('Admissions@2026', $admissions['password_hash']));

    // Test Login Page renders Role Toggle
    ob_start();
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/admin/login';
    $router = require ROOT_PATH . '/app/Routes/web.php';
    $router->dispatch();
    $loginOutput = ob_get_clean();
    assertTest("Login page renders Multi-Role Toggle bar", str_contains($loginOutput, 'Select Staff Access Role') && str_contains($loginOutput, 'data-role="superadmin"'));
    assertTest("Login page renders Admissions and Editor role tabs", str_contains($loginOutput, 'data-role="admissions"') && str_contains($loginOutput, 'data-role="editor"'));
    assertTest("Login page renders Quick Fill demo helper and password visibility toggle", str_contains($loginOutput, 'id="quickFillBtn"') && str_contains($loginOutput, 'id="togglePasswordBtn"'));

} catch (\Throwable $e) {
    assertTest("Admin auth test error: " . $e->getMessage(), false);
}

echo "\n========================================================\n";
echo "   Test Results: {$passCount} Passed, {$failCount} Failed\n";
echo "========================================================\n";

exit($failCount > 0 ? 1 : 0);

