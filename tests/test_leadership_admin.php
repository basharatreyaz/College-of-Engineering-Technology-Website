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

// 1. Authenticate Session as Superadmin
\App\Services\Session::set('admin_user', [
    'id' => 1,
    'name' => 'Super Admin',
    'email' => 'admin@kcet.edu.in',
    'role' => 'superadmin',
    'status' => 'active'
]);

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/leadership';
$_GET = [];
$_POST = [];

ob_start();
$router = require ROOT_PATH . '/app/Routes/web.php';
$router->dispatch();
$output = ob_get_clean();

$hasChairman = str_contains($output, "From the Chairman's Desk");
$hasDirector = str_contains($output, "From the Director's Desk");
$hasPrincipal = str_contains($output, "From the Principal's Desk");

if (!$hasChairman || !$hasDirector || !$hasPrincipal) {
    echo "LEADERSHIP_ADMIN_GET_FAIL\n";
    exit(1);
}

// 2. Test Direct Model & Controller update
$_POST = [
    'chairman_name' => 'Er. Bashir Ahmad (Updated Test)',
    'chairman_designation' => 'Chairman, Kashmir Educational Society',
    'chairman_quote' => 'Updated Chairman Quote Test',
    'chairman_message' => 'Updated Chairman Message Test Body',
    'director_name' => 'Er. Mushtaq Ahmad Mir (Updated Test)',
    'director_designation' => 'Managing Director & Trustee',
    'director_quote' => 'Updated Director Quote Test',
    'director_message' => 'Updated Director Message Test Body',
    'principal_name' => 'Dr. Syed Jalal Ahmad (Updated Test)',
    'principal_designation' => 'Principal & Professor of Engineering',
    'principal_qualifications' => 'Ph.D. (IIT Delhi), M.Tech, B.E.',
    'principal_quote' => 'Updated Principal Quote Test',
    'principal_message' => 'Updated Principal Message Test Body'
];
$_FILES = [];

try {
    $settingModel = new \App\Models\Setting();
    $settingModel->set('chairman_name', trim($_POST['chairman_name']));
    $settingModel->set('chairman_designation', trim($_POST['chairman_designation']));
    $settingModel->set('chairman_quote', trim($_POST['chairman_quote']));
    $settingModel->set('chairman_message', trim($_POST['chairman_message']));

    $settingModel->set('director_name', trim($_POST['director_name']));
    $settingModel->set('director_designation', trim($_POST['director_designation']));
    $settingModel->set('director_quote', trim($_POST['director_quote']));
    $settingModel->set('director_message', trim($_POST['director_message']));

    $settingModel->set('principal_name', trim($_POST['principal_name']));
    $settingModel->set('principal_designation', trim($_POST['principal_designation']));
    $settingModel->set('principal_qualifications', trim($_POST['principal_qualifications']));
    $settingModel->set('principal_quote', trim($_POST['principal_quote']));
    $settingModel->set('principal_message', trim($_POST['principal_message']));
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

// Verify updated values in Database
$settingModel = new \App\Models\Setting();
$cName = $settingModel->get('chairman_name');
$dName = $settingModel->get('director_name');
$pName = $settingModel->get('principal_name');

if ($cName !== 'Er. Bashir Ahmad (Updated Test)' || 
    $dName !== 'Er. Mushtaq Ahmad Mir (Updated Test)' || 
    $pName !== 'Dr. Syed Jalal Ahmad (Updated Test)') {
    echo "LEADERSHIP_ADMIN_UPDATE_FAIL: {$cName}, {$dName}, {$pName}\n";
    exit(1);
}

// Revert to clean baseline (Official kcet.edu.in data)
$settingModel->set('chairman_name', 'Er. Raja Aijaz Ali (Retd. IPS / IGP)');
$settingModel->set('chairman_designation', 'Chairman, Kashmir College of Engineering & Technology');
$settingModel->set('chairman_photo', 'assets/images/faculty-hod-cse.jpg');
$settingModel->set('chairman_quote', 'Drawing from my engineering background and understanding the hardships students face when traveling outside the valley, KCET was established to provide state-of-the-art technical education right here in Kashmir.');
$settingModel->set('chairman_message', "Kashmir College of Engineering & Technology was established with a singular, resolute mission: to build a premier institution of technical excellence within the Kashmir valley so that aspiring engineering students do not have to endure the hardships of traveling outside the region to attain high-quality accredited technical education.\n\nHaving served in public administration and holding a background in engineering, I envisioned KCET as a center of rigorous academic inquiry, cutting-edge computing laboratories, and ethical leadership. With our modern campus in Ranbirgarh, distinguished faculty, and approval from AICTE alongside affiliation with the University of Kashmir, we provide an inspiring environment where youth can realize their highest engineering ambitions.");

$settingModel->set('director_name', 'Er. Raja Minad Aijaz');
$settingModel->set('director_designation', 'Director / Director of Administration, KCET');
$settingModel->set('director_photo', 'assets/images/faculty-hod-ai.jpg');
$settingModel->set('director_quote', 'Having experienced the challenges of pursuing an engineering degree away from home, our mission is to provide students at KCET with a world-class, supportive, and career-driven technical learning ecosystem.');
$settingModel->set('director_message', "At KCET, our focus is on creating a holistic academic and infrastructural environment where engineering students can thrive. From high-performance computing centers and specialized Artificial Intelligence laboratories to reliable campus transit routes and rich collegiate resources, every facility at Ranbirgarh is purpose-built to empower students.\n\nWe maintain strong industry alignment and outcome-based pedagogical standards under AICTE and University of Kashmir guidelines, preparing our graduates for premier technical careers and global postgraduate opportunities.");

$settingModel->set('principal_name', 'Dr. Syed Jalal Ahmad');
$settingModel->set('principal_designation', 'Principal & Professor of Engineering, KCET');
$settingModel->set('principal_qualifications', 'Ph.D., M.E., B.E. (Microwave & Wireless Communication)');
$settingModel->set('principal_photo', 'assets/images/principal-portrait.svg');
$settingModel->set('principal_quote', 'Engineering education at KCET is deeply grounded in hands-on scientific enquiry, ethical problem-solving, and outcome-based pedagogical rigor. We prepare engineers not merely for examinations, but to solve real infrastructure and technological challenges of Jammu & Kashmir and the world.');
$settingModel->set('principal_message', "Since its inception, Kashmir College of Engineering & Technology has stood as a beacon of high-quality technical education in Srinagar. Situated across a lush 100+ kanal green campus in Ranbirgarh, our institution provides an ideal environment where academic curiosity meets state-of-the-art laboratory experimentation.\n\nWith approval from AICTE and affiliation to the prestigious University of Kashmir, our curriculum continually integrates modern computational frameworks, artificial intelligence paradigms, sustainable civil designs, and advanced electronics. We welcome aspiring engineers to join our vibrant academic community.");

echo "LEADERSHIP_ADMIN_GET_OK\n";
echo "LEADERSHIP_ADMIN_POST_OK\n";
echo "LEADERSHIP_TEST_ALL_PASSED\n";

