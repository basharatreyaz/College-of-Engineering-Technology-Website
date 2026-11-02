<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Programme;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Notice;
use App\Models\Event;
use App\Models\Enquiry;
use App\Models\Application;
use App\Models\AuditLog;
use App\Services\View;

class DashboardController
{
    public function index(): void
    {
        $progModel = new Programme();
        $deptModel = new Department();
        $facultyModel = new Faculty();
        $noticeModel = new Notice();
        $eventModel = new Event();
        $enquiryModel = new Enquiry();
        $appModel = new Application();
        $auditModel = new AuditLog();

        $stats = [
            'programmes' => $progModel->count('is_active = 1'),
            'departments' => $deptModel->count('is_active = 1'),
            'faculty' => $facultyModel->count('is_active = 1'),
            'notices' => $noticeModel->count("status = 'published'"),
            'events' => $eventModel->count("status = 'published'"),
            'enquiries_new' => $enquiryModel->count("status = 'new'"),
            'applications_new' => $appModel->count("status = 'new'"),
            'applications_total' => $appModel->count(),
        ];

        $recentEnquiries = $enquiryModel->getAllWithProgrammes('e.created_at DESC', 5);
        $recentApplications = $appModel->getAllWithProgrammes('a.created_at DESC', 5);
        $recentLogs = $auditModel->getRecent(5);

        View::render('admin.dashboard', [
            'pageTitle' => 'Admin Dashboard | KCET',
            'stats' => $stats,
            'recentEnquiries' => $recentEnquiries,
            'recentApplications' => $recentApplications,
            'recentLogs' => $recentLogs,
        ], 'layouts.admin');
    }
}

