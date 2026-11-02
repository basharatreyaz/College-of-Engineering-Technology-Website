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

$pdo = \App\Services\Database::getInstance()->getPdo();

// 1. Update facilities images with actual downloaded photos
$facilityUpdates = [
    'high-speed-wi-fi-campus' => 'assets/images/lab-computing-ai.jpg',
    'advanced-computer-labs' => 'assets/images/lab-computing-ai.jpg',
    'modern-lecture-halls' => 'assets/images/classroom-lecture-theatre.jpg',
    'specialized-engineering-labs' => 'assets/images/lab-engineering-workshop.jpg',
    'mechanical-civil-workshops' => 'assets/images/facility-testing-lab.jpg',
    'multipurpose-auditorium' => 'assets/images/facility-auditorium-hall.jpg',
    'spacious-library' => 'assets/images/facility-auditorium-hall.jpg',
    'bus-transport-fleet' => 'assets/images/campus-front-facade.jpg',
    'student-canteen' => 'assets/images/campus-green-grounds.jpg',
    'sports-complex' => 'assets/images/campus-green-grounds.jpg',
    'ramps-and-lifts' => 'assets/images/campus-main-block.jpg',
    'spacious-parking' => 'assets/images/campus-panoramic.jpg',
];

$stmtFac = $pdo->prepare("UPDATE facilities SET image = :image WHERE slug = :slug");
foreach ($facilityUpdates as $slug => $img) {
    $stmtFac->execute([':image' => $img, ':slug' => $slug]);
}
echo "Updated facilities table.\n";

// 2. Update events table with real photos
$stmtEvt = $pdo->prepare("UPDATE events SET featured_image = :image, title = :title, summary = :summary WHERE id = :id");

// Event 1: Historic Inauguration by Hon'ble Lt. Governor Manoj Sinha
$stmtEvt->execute([
    ':id' => 1,
    ':title' => 'Inauguration of Kashmir College of Engineering & Technology by Hon\'ble Lt. Governor Sh. Manoj Sinha',
    ':summary' => 'Hon\'ble Lt. Governor Sh. Manoj Sinha officially inaugurated the sprawling green campus of KCET in Srinagar, highlighting the mission to elevate technical education in J&K.',
    ':image' => 'assets/images/event-inauguration-lg.jpg'
]);

// Event 2: Annual Technical Boot Camp
$stmtEvt->execute([
    ':id' => 2,
    ':title' => 'Annual Technical Boot Camp & Innovation Hackathon',
    ':summary' => 'Engineering scholars from all five B.Tech disciplines collaborated across intensive workshops on applied deep learning, full-stack systems, and IoT.',
    ':image' => 'assets/images/event-bootcamp.jpg'
]);

// Event 3: Campus Induction & Orientation
$stmtEvt->execute([
    ':id' => 3,
    ':title' => 'Academic Induction & Campus Orientation',
    ':summary' => 'Welcoming the new cohort of engineering students across the 100+ kanal green campus with mentorship briefings and lab tours.',
    ':image' => 'assets/images/campus-main-block.jpg'
]);

echo "Updated events table.\n";

// 3. Update gallery items
$pdo->exec("DELETE FROM gallery_items;");

$galleryRows = [
    [1, 'Main Academic Block & Architecture', 'Serene architecture set within the 100+ kanal green campus in Ranbirgarh, Srinagar.', 'campus', 'assets/images/campus-main-block.jpg', 1, 1],
    [2, 'Computer Engineering & AI Laboratories', 'Modern workstations dedicated to algorithm design, neural networks, and cloud computing.', 'labs', 'assets/images/lab-computing-ai.jpg', 2, 1],
    [3, 'Engineering Workshops & Fabrication', 'Hands-on training in mechanical fabrication, lathe operations, and material testing.', 'labs', 'assets/images/lab-engineering-workshop.jpg', 3, 1],
    [4, 'Electronics & Communications Laboratory', 'Testing benches equipped with oscilloscopes, DSP kits, and micro-controller modules.', 'labs', 'assets/images/lab-electronics-electrical.jpg', 4, 1],
    [5, 'Lecture Theatre & Smart Classrooms', 'Acoustically treated, multimedia-enabled learning spaces facilitating interactive lectures.', 'campus', 'assets/images/classroom-lecture-theatre.jpg', 5, 1],
    [6, 'Central Auditorium & Seminar Complex', 'Venue for national technical symposia, guest lectures, and cultural inductions.', 'campus', 'assets/images/facility-auditorium-hall.jpg', 6, 1],
    [7, 'Sprawling Campus Green Grounds', 'Over 100 kanals of lush outdoor turf supporting student recreation and sports.', 'sports', 'assets/images/campus-green-grounds.jpg', 7, 1],
    [8, 'Panoramic Campus View', 'Panoramic vista of the institution situated in the tranquil surroundings of Ranbirgarh.', 'campus', 'assets/images/campus-panoramic.jpg', 8, 1],
    [9, 'Annual Boot Camp & Technology Expo', 'Annual collegiate technical convention engaging students in cutting-edge project demonstrations.', 'events', 'assets/images/event-bootcamp.jpg', 9, 1],
    [10, 'Inauguration Ceremony by Hon\'ble Lt. Governor', 'Historic milestone marking the institutional commitment to technical excellence in Kashmir.', 'events', 'assets/images/event-inauguration-lg.jpg', 10, 1]
];

$stmtGal = $pdo->prepare("INSERT INTO gallery_items (id, title, caption, category, image_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
foreach ($galleryRows as $row) {
    $stmtGal->execute($row);
}
echo "Populated gallery_items table with real images.\n";

// 4. Update site_settings for campus hero / tour thumbnail
$pdo->exec("UPDATE site_settings SET setting_value = 'assets/images/campus-main-block.jpg' WHERE setting_key = 'campus_image';");

echo "All database updates completed successfully.\n";

