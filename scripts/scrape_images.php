<?php
// Scrape and discover image URLs from kcet.edu.in

$baseUrl = 'https://kcet.edu.in';
$context = stream_context_create([
    'http' => [
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'timeout' => 15,
        'follow_location' => 1,
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
]);

$pages = [
    '/',
    '/about',
    '/about-us',
    '/campus-life',
    '/facilities',
    '/gallery',
    '/departments',
    '/courses',
    '/contact',
    '/contact-us'
];

$foundImages = [];
$visitedPages = [];

foreach ($pages as $p) {
    $url = rtrim($baseUrl, '/') . $p;
    echo "Checking page: $url ...\n";
    $html = @file_get_contents($url, false, $context);
    if (!$html) {
        echo "  -> Failed or 404\n";
        continue;
    }
    $visitedPages[] = $p;
    
    // Match <img> src or data-src or data-lazy-src
    preg_match_all('/<img[^>]+(?:src|data-src|data-lazy-src)=["\']([^"\']+)["\']/i', $html, $matches);
    if (!empty($matches[1])) {
        foreach ($matches[1] as $imgSrc) {
            $imgSrc = trim($imgSrc);
            if (empty($imgSrc) || str_starts_with($imgSrc, 'data:')) continue;
            
            // Resolve relative URLs
            if (str_starts_with($imgSrc, '//')) {
                $imgUrl = 'https:' . $imgSrc;
            } elseif (str_starts_with($imgSrc, '/')) {
                $imgUrl = $baseUrl . $imgSrc;
            } elseif (!str_starts_with($imgSrc, 'http')) {
                $imgUrl = $baseUrl . '/' . ltrim($imgSrc, '/');
            } else {
                $imgUrl = $imgSrc;
            }
            
            $foundImages[$imgUrl] = [
                'source_page' => $p,
                'url' => $imgUrl,
            ];
        }
    }
    
    // Also match background images in style="..."
    preg_match_all('/style=["\'][^"\']*url\(["\']?([^"\'\)]+)["\']?\)/i', $html, $bgMatches);
    if (!empty($bgMatches[1])) {
        foreach ($bgMatches[1] as $bgSrc) {
            $bgSrc = trim($bgSrc);
            if (empty($bgSrc) || str_starts_with($bgSrc, 'data:')) continue;
            if (str_starts_with($bgSrc, '//')) {
                $bgUrl = 'https:' . $bgSrc;
            } elseif (str_starts_with($bgSrc, '/')) {
                $bgUrl = $baseUrl . $bgSrc;
            } elseif (!str_starts_with($bgSrc, 'http')) {
                $bgUrl = $baseUrl . '/' . ltrim($bgSrc, '/');
            } else {
                $bgUrl = $bgSrc;
            }
            $foundImages[$bgUrl] = [
                'source_page' => $p,
                'url' => $bgUrl,
            ];
        }
    }
}

echo "\n--- Summary ---\n";
echo "Visited pages: " . count($visitedPages) . "\n";
echo "Found unique images: " . count($foundImages) . "\n";
echo json_encode(array_values($foundImages), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

