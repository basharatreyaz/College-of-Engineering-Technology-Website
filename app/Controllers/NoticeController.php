<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Notice;
use App\Services\View;

class NoticeController
{
    public function index(): void
    {
        $noticeModel = new Notice();
        $category = isset($_GET['cat']) ? trim($_GET['cat']) : 'all';
        $search = isset($_GET['q']) ? trim($_GET['q']) : null;

        $notices = $noticeModel->getPublished(50, $category);

        if ($search) {
            $q = mb_strtolower($search);
            $notices = array_filter($notices, function($n) use ($q) {
                return str_contains(mb_strtolower($n['title']), $q) ||
                       str_contains(mb_strtolower($n['summary'] ?? ''), $q);
            });
        }

        View::render('pages.notices.index', [
            'pageTitle' => 'Notices & Announcements | KCET Srinagar',
            'metaDescription' => 'Stay updated with official admission notifications, academic circulars, examination schedules, and recruitment at KCET Srinagar.',
            'notices' => $notices,
            'selectedCategory' => $category,
            'searchQuery' => $search
        ]);
    }

    public function show(string $slug): void
    {
        $noticeModel = new Notice();
        $notice = $noticeModel->findBySlug($slug);

        if (!$notice || $notice['status'] !== 'published') {
            $pageController = new PageController();
            $pageController->notFound();
            return;
        }

        $latestNotices = array_filter(
            $noticeModel->getLatest(4),
            fn($n) => (int)$n['id'] !== (int)$notice['id']
        );

        View::render('pages.notices.show', [
            'pageTitle' => $notice['title'] . ' | Notices | KCET',
            'metaDescription' => truncate($notice['summary'] ?? '', 160),
            'notice' => $notice,
            'recentNotices' => $latestNotices
        ]);
    }
}

