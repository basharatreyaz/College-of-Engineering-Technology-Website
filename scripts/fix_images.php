<?php
/**
 * Fix Image References and Generate Faculty Portraits
 */
define('ROOT_PATH', dirname(__DIR__));
$publicImgDir = ROOT_PATH . '/public/assets/images';

// 1. Update SQLite Database
$pdo = new PDO('sqlite:' . ROOT_PATH . '/storage/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Update Facilities
$facilityMap = [
    1 => 'assets/images/facility-auditorium-hall.jpg',
    2 => 'assets/images/student-life-campus.jpg',
    3 => 'assets/images/campus-front-facade.jpg',
    4 => 'assets/images/lab-computing-ai.jpg',
    5 => 'assets/images/facility-auditorium-hall.jpg',
    6 => 'assets/images/classroom-lecture-theatre.jpg',
    7 => 'assets/images/campus-main-block.jpg',
    8 => 'assets/images/lab-computing-ai.jpg',
    9 => 'assets/images/facility-testing-lab.jpg',
    10 => 'assets/images/lab-electronics-electrical.jpg',
    11 => 'assets/images/campus-main-block.jpg',
    12 => 'assets/images/campus-panoramic.jpg',
];

$stmtFac = $pdo->prepare("UPDATE facilities SET image = :img WHERE id = :id");
foreach ($facilityMap as $id => $img) {
    $stmtFac->execute([':img' => $img, ':id' => $id]);
}
echo "Facilities updated in SQLite: " . count($facilityMap) . " rows.\n";

// Update Events
$eventMap = [
    1 => 'assets/images/event-inauguration-lg.jpg',
    2 => 'assets/images/event-bootcamp.jpg',
    3 => 'assets/images/campus-main-block.jpg',
    4 => 'assets/images/campus-panoramic.jpg',
    5 => 'assets/images/campus-green-grounds.jpg',
];

$stmtEvt = $pdo->prepare("UPDATE events SET featured_image = :img WHERE id = :id");
foreach ($eventMap as $id => $img) {
    $stmtEvt->execute([':img' => $img, ':id' => $id]);
}
echo "Events updated in SQLite: " . count($eventMap) . " rows.\n";

// 2. Legacy alias copies for facility/event filenames to ensure zero 404s if accessed directly
$aliases = [
    'facility-canteen.jpg' => 'student-life-campus.jpg',
    'facility-transport.jpg' => 'campus-front-facade.jpg',
    'facility-wifi.jpg' => 'lab-computing-ai.jpg',
    'facility-auditorium.jpg' => 'facility-auditorium-hall.jpg',
    'facility-placement.jpg' => 'classroom-lecture-theatre.jpg',
    'facility-medical.jpg' => 'campus-main-block.jpg',
    'facility-computer-centre.jpg' => 'lab-computing-ai.jpg',
    'facility-fire-safety.jpg' => 'facility-testing-lab.jpg',
    'facility-cctv.jpg' => 'lab-electronics-electrical.jpg',
    'facility-accessibility.jpg' => 'campus-main-block.jpg',
    'facility-parking.jpg' => 'campus-panoramic.jpg',
    'facility-library.jpg' => 'facility-auditorium-hall.jpg',
    'event-ladakh.jpg' => 'campus-panoramic.jpg',
    'event-plantation.jpg' => 'campus-green-grounds.jpg',
];

foreach ($aliases as $target => $source) {
    $srcPath = $publicImgDir . '/' . $source;
    $dstPath = $publicImgDir . '/' . $target;
    if (file_exists($srcPath) && !file_exists($dstPath)) {
        copy($srcPath, $dstPath);
        echo "Created alias image: $target (from $source)\n";
    }
}

// 3. Generate Dignified Academic Faculty Portrait Images (JPEG)
// Using GD to create high-resolution 400x480 academic portrait cards
function generateAcademicPortrait(string $outputPath, string $name, string $initials, string $deptRole): void {
    $w = 400;
    $h = 480;
    $img = imagecreatetruecolor($w, $h);

    // Colors
    $navyDark = imagecolorallocate($img, 10, 37, 64);      // #0A2540
    $navyBlue = imagecolorallocate($img, 30, 58, 138);     // #1E3A8A
    $gold = imagecolorallocate($img, 201, 138, 44);         // #C98A2C
    $goldLight = imagecolorallocate($img, 253, 230, 138);   // #FDE68A
    $white = imagecolorallocate($img, 255, 255, 255);
    $textMuted = imagecolorallocate($img, 203, 213, 225);   // #CBD5E1
    $slateDark = imagecolorallocate($img, 15, 23, 42);      // #0F172A

    // Fill background with navy
    imagefill($img, 0, 0, $navyDark);

    // Subtle gradient lines
    for ($y = 0; $y < $h; $y++) {
        $ratio = $y / $h;
        $r = (int)(10 + ($ratio * 15));
        $g = (int)(37 + ($ratio * 10));
        $b = (int)(64 - ($ratio * 10));
        $lineColor = imagecolorallocate($img, $r, $g, $b);
        imageline($img, 0, $y, $w, $y, $lineColor);
    }

    // Outer gold collegiate border
    imagerectangle($img, 12, 12, $w - 13, $h - 13, $gold);
    imagerectangle($img, 15, 15, $w - 16, $h - 16, $gold);

    // Academic Silhouette Circle / Badge
    $cx = 200;
    $cy = 180;
    $radius = 85;

    // Outer circle
    imagefilledellipse($img, $cx, $cy, $radius * 2 + 10, $radius * 2 + 10, $gold);
    imagefilledellipse($img, $cx, $cy, $radius * 2, $radius * 2, $navyBlue);

    // Draw Academic Silhouette graphic
    // Head
    imagefilledellipse($img, $cx, $cy - 20, 56, 68, $goldLight);
    // Shoulders
    imagefilledarc($img, $cx, $cy + 65, 140, 100, 180, 360, $white, IMG_ARC_PIE);
    // Suit/Robe overlay
    imagefilledarc($img, $cx, $cy + 65, 100, 75, 180, 360, $slateDark, IMG_ARC_PIE);

    // Faculty Name Banner at bottom
    imagefilledrectangle($img, 25, 340, $w - 26, 450, $slateDark);
    imagerectangle($img, 25, 340, $w - 26, 450, $gold);

    // Render Text (using built-in GD fonts)
    // Name
    $nameFont = 5;
    $nameX = (int)max(30, ($w - strlen($name) * 9) / 2);
    imagestring($img, $nameFont, $nameX, 360, $name, $white);

    // Department / Role
    $roleFont = 3;
    $roleX = (int)max(30, ($w - strlen($deptRole) * 7) / 2);
    imagestring($img, $roleFont, $roleX, 390, $deptRole, $goldLight);

    // Institution
    $instFont = 2;
    $inst = "KCET - Srinagar";
    $instX = (int)(($w - strlen($inst) * 6) / 2);
    imagestring($img, $instFont, $instX, 420, $inst, $textMuted);

    imagejpeg($img, $outputPath, 92);
    imagedestroy($img);
}

// Generate for all 8 faculty members
$facultyMembers = [
    'faculty-1.jpg' => ['Er. Farooq Ahmad', 'FA', 'Assoc. Prof & HOD (CE)'],
    'faculty-2.jpg' => ['Dr. Shabir Hussain', 'SH', 'Professor & HOD (AIE)'],
    'faculty-3.jpg' => ['Er. Tariq Masood', 'TM', 'Assoc. Prof & HOD (Civil)'],
    'faculty-4.jpg' => ['Er. Mushtaq Rather', 'MR', 'Assoc. Prof & HOD (IT)'],
    'faculty-5.jpg' => ['Dr. Adil Nisar', 'AN', 'Professor & HOD (ECE)'],
    'faculty-6.jpg' => ['Dr. Naseer Ahmad', 'NA', 'Professor & HOD (ASH)'],
    'faculty-7.jpg' => ['Er. Zahoor Peerzada', 'ZP', 'Assistant Professor (CE)'],
    'faculty-8.jpg' => ['Er. Saima Jan', 'SJ', 'Assistant Professor (Civil)'],
];

foreach ($facultyMembers as $file => [$name, $init, $role]) {
    $out = $publicImgDir . '/' . $file;
    generateAcademicPortrait($out, $name, $init, $role);
    echo "Generated faculty portrait: $file\n";
}

// Generate for department HOD photos
$hodPhotos = [
    'faculty-hod-cse.jpg' => ['Er. Farooq Ahmad', 'FA', 'HOD Computer Engineering'],
    'faculty-hod-ai.jpg' => ['Dr. Shabir Hussain', 'SH', 'HOD AI Engineering'],
    'faculty-hod-civil.jpg' => ['Er. Tariq Masood', 'TM', 'HOD Civil Engineering'],
    'faculty-hod-it.jpg' => ['Er. Mushtaq Rather', 'MR', 'HOD Information Tech'],
    'faculty-hod-ece.jpg' => ['Dr. Adil Nisar', 'AN', 'HOD Electronics & Comm'],
    'faculty-hod-ash.jpg' => ['Dr. Naseer Ahmad', 'NA', 'HOD Applied Sciences'],
];

foreach ($hodPhotos as $file => [$name, $init, $role]) {
    $out = $publicImgDir . '/' . $file;
    generateAcademicPortrait($out, $name, $init, $role);
    echo "Generated HOD photo: $file\n";
}

// Default faculty avatar SVG
$svgAvatar = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" width="120" height="120">
  <circle cx="60" cy="60" r="58" fill="#0A2540" stroke="#C98A2C" stroke-width="3"/>
  <ellipse cx="60" cy="46" rx="20" ry="24" fill="#D4A373"/>
  <path d="M26 108 C26 78 40 70 60 70 C80 70 94 78 94 108 Z" fill="#1E3A8A"/>
  <polygon points="60,70 52,85 68,85" fill="#FFFFFF"/>
</svg>';
file_put_contents($publicImgDir . '/faculty-avatar.svg', $svgAvatar);
echo "Created faculty-avatar.svg\n";

echo "ALL IMAGE REPAIRS COMPLETED SUCCESSFULLY.\n";

