<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Event;
use App\Services\View;

class EventController
{
    public function index(): void
    {
        $eventModel = new Event();
        $timeframe = isset($_GET['time']) ? trim($_GET['time']) : null;
        $category = isset($_GET['cat']) ? trim($_GET['cat']) : null;

        $events = $eventModel->getPublished(50, $timeframe);

        if ($category) {
            $catLower = mb_strtolower($category);
            $events = array_filter($events, fn($e) => mb_strtolower($e['category']) === $catLower);
        }

        View::render('pages.events.index', [
            'pageTitle' => 'Events & Campus Stories | KCET Srinagar',
            'metaDescription' => 'Discover technical boot camps, industrial visits, guest lectures, and campus life events at Kashmir College of Engineering & Technology.',
            'events' => $events,
            'selectedTimeframe' => $timeframe,
            'selectedCategory' => $category
        ]);
    }

    public function show(string $slug): void
    {
        $eventModel = new Event();
        $event = $eventModel->findBySlug($slug);

        if (!$event || $event['status'] !== 'published') {
            $pageController = new PageController();
            $pageController->notFound();
            return;
        }

        $otherEvents = array_filter(
            $eventModel->getPublished(4),
            fn($e) => (int)$e['id'] !== (int)$event['id']
        );

        View::render('pages.events.show', [
            'pageTitle' => $event['title'] . ' | Events | KCET',
            'metaDescription' => truncate($event['summary'] ?? '', 160),
            'event' => $event,
            'recentEvents' => array_slice($otherEvents, 0, 3)
        ]);
    }
}

