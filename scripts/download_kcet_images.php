<?php
// Script to download actual KCET photos and map them into the site

$targetDir = dirname(__DIR__) . '/public/assets/images';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// Download list mapped to semantic file names
$imageMap = [
    // Logos
    'kcet-logo-official.png' => 'https://kcet.edu.in/wp-content/uploads/2025/05/kcet-logo.png',
    'kcet-logo-header.png' => 'https://kcet.edu.in/wp-content/uploads/2025/04/kcet-logo-header.png',

    // Historic Milestone / Inauguration by Lt. Governor
    'event-inauguration-lg.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/05/Lt-Governor-Sh-Manoj-Sinha-inaugurated-Kashmir-College-of-Engineering-Technology-at-Srinagar-1.jpg',

    // Campus Main Block & Architecture
    'campus-main-block.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/05/IMG_3067-scaled-e1746599272743.jpg',
    'campus-panoramic.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/05/DSC09232-scaled.jpg',
    'campus-green-grounds.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/05/IMG_3275-scaled.jpg',
    'campus-front-facade.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/05/IMG_4787.jpg',

    // Labs & Academic Classrooms
    'lab-computing-ai.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/05/IMG_4798.jpg',
    'lab-engineering-workshop.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/05/IMG_4804.jpg',
    'lab-electronics-electrical.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/05/IMG_4809.jpg',
    'lab-science-practical.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/04/IMG_2959-2048x1536-1-e1746593110787.jpg',
    'classroom-lecture-theatre.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/04/IMG_2861-2048x1536-1-e1746593079669.jpeg',
    'facility-testing-lab.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/05/DSC09113-scaled.jpg',

    // Library, Seminar Hall & Auditorium
    'facility-auditorium-hall.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/04/DSC02963-copy-scaled-1-e1746599249632.jpg',
    'student-life-campus.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/04/IMG_3108-e1746593173337.jpg',

    // Events & Boot Camp
    'event-bootcamp.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/11/boot_camp_2025.jpg',

    // Prospectus / Brochure Cover
    'brochure-brief-info.jpg' => 'https://kcet.edu.in/wp-content/uploads/2025/04/Brief-information-about-the-college-2_page-0025-e1746593193353.jpg',
];

$context = stream_context_create([
    'http' => [
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'timeout' => 30,
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
]);

$downloaded = [];
$failed = [];

foreach ($imageMap as $localName => $remoteUrl) {
    $destination = $targetDir . '/' . $localName;
    echo "Downloading: $localName from $remoteUrl ...\n";
    $content = @file_get_contents($remoteUrl, false, $context);
    if ($content !== false && strlen($content) > 500) {
        file_put_contents($destination, $content);
        $sizeKb = round(strlen($content) / 1024, 1);
        echo "  [OK] Saved to $localName ($sizeKb KB)\n";
        $downloaded[$localName] = $sizeKb . ' KB';
    } else {
        echo "  [FAIL] Could not retrieve $remoteUrl\n";
        $failed[$localName] = $remoteUrl;
    }
}

echo "\n--- Download Results ---\n";
echo "Successfully downloaded: " . count($downloaded) . "\n";
echo "Failed: " . count($failed) . "\n";

