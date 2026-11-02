<?php
declare(strict_types=1);

/**
 * Dynamic XML Sitemap Generator
 */

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
    require_once ROOT_PATH . '/app/Helpers/helpers.php';
    require_once ROOT_PATH . '/app/Services/Database.php';
}

$db = \App\Services\Database::getInstance();
$baseUrl = rtrim(env('APP_URL', 'https://kcet.edu.in'), '/');

// Base static pages
$pages = [
    ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
    ['loc' => '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => '/chairmans-message', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => '/directors-message', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => '/principals-message', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => '/programmes', 'priority' => '0.9', 'changefreq' => 'weekly'],
    ['loc' => '/departments', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => '/faculty', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => '/facilities', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['loc' => '/campus-life', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['loc' => '/admissions', 'priority' => '0.9', 'changefreq' => 'weekly'],
    ['loc' => '/apply', 'priority' => '0.9', 'changefreq' => 'monthly'],
    ['loc' => '/events', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/notices', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['loc' => '/downloads', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['loc' => '/careers', 'priority' => '0.6', 'changefreq' => 'monthly'],
    ['loc' => '/contact', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['loc' => '/privacy', 'priority' => '0.3', 'changefreq' => 'yearly'],
    ['loc' => '/terms', 'priority' => '0.3', 'changefreq' => 'yearly'],
];

// Fetch active programmes
$programmes = $db->query("SELECT slug, updated_at FROM programmes WHERE is_active = 1");
foreach ($programmes as $p) {
    $pages[] = [
        'loc' => '/programmes/' . $p['slug'],
        'priority' => '0.8',
        'changefreq' => 'weekly',
        'lastmod' => date('Y-m-d', strtotime($p['updated_at'] ?? 'now'))
    ];
}

// Fetch active departments
$departments = $db->query("SELECT slug, updated_at FROM departments WHERE is_active = 1");
foreach ($departments as $d) {
    $pages[] = [
        'loc' => '/departments/' . $d['slug'],
        'priority' => '0.8',
        'changefreq' => 'monthly',
        'lastmod' => date('Y-m-d', strtotime($d['updated_at'] ?? 'now'))
    ];
}

// Fetch active notices
$notices = $db->query("SELECT slug, updated_at FROM notices WHERE status = 'published'");
foreach ($notices as $n) {
    $pages[] = [
        'loc' => '/notices/' . $n['slug'],
        'priority' => '0.7',
        'changefreq' => 'weekly',
        'lastmod' => date('Y-m-d', strtotime($n['updated_at'] ?? 'now'))
    ];
}

// Fetch active events
$events = $db->query("SELECT slug, updated_at FROM events WHERE status = 'published'");
foreach ($events as $e) {
    $pages[] = [
        'loc' => '/events/' . $e['slug'],
        'priority' => '0.7',
        'changefreq' => 'weekly',
        'lastmod' => date('Y-m-d', strtotime($e['updated_at'] ?? 'now'))
    ];
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $page): ?>
    <url>
        <loc><?= htmlspecialchars($baseUrl . $page['loc']) ?></loc>
        <priority><?= $page['priority'] ?></priority>
        <changefreq><?= $page['changefreq'] ?></changefreq>
        <?php if (!empty($page['lastmod'])): ?>
        <lastmod><?= $page['lastmod'] ?></lastmod>
        <?php else: ?>
        <lastmod><?= date('Y-m-d') ?></lastmod>
        <?php endif; ?>
    </url>
<?php endforeach; ?>
</urlset>

