<?php
declare(strict_types=1);

use App\Services\Router;
use App\Controllers\HomeController;
use App\Controllers\PageController;
use App\Controllers\LeadershipController;
use App\Controllers\ProgrammeController;
use App\Controllers\DepartmentController;
use App\Controllers\FacultyController;
use App\Controllers\FacilityController;
use App\Controllers\NoticeController;
use App\Controllers\EventController;
use App\Controllers\DownloadController;
use App\Controllers\FormController;
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ProgrammeAdminController;
use App\Controllers\Admin\DepartmentAdminController;
use App\Controllers\Admin\FacultyAdminController;
use App\Controllers\Admin\NoticeAdminController;
use App\Controllers\Admin\EventAdminController;
use App\Controllers\Admin\FacilityAdminController;
use App\Controllers\Admin\FaqAdminController;
use App\Controllers\Admin\GalleryAdminController;
use App\Controllers\Admin\DownloadAdminController;
use App\Controllers\Admin\EnquiryAdminController;
use App\Controllers\Admin\ApplicationAdminController;
use App\Controllers\Admin\SettingAdminController;
use App\Controllers\Admin\LeadershipAdminController;
use App\Controllers\Admin\UserAdminController;
use App\Controllers\Admin\AuditLogAdminController;

$router = new Router();

// ==========================================
// Public Front-Facing Routes
// ==========================================
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [PageController::class, 'about']);
$router->get('/campus-life', [PageController::class, 'campusLife']);
$router->get('/admissions', [PageController::class, 'admissions']);
$router->get('/careers', [PageController::class, 'careers']);
$router->get('/contact', [PageController::class, 'contact']);
$router->get('/privacy', [PageController::class, 'privacy']);
$router->get('/terms', [PageController::class, 'terms']);

// Dedicated Leadership Messages (Chairman, Director, Principal)
$router->get('/chairmans-message', [LeadershipController::class, 'chairman']);
$router->get('/directors-message', [LeadershipController::class, 'director']);
$router->get('/principals-message', [LeadershipController::class, 'principal']);
$router->get('/leadership/{role}', [LeadershipController::class, 'show']);
$router->get('/about/chairmans-message', [LeadershipController::class, 'chairman']);
$router->get('/about/directors-message', [LeadershipController::class, 'director']);
$router->get('/about/principals-message', [LeadershipController::class, 'principal']);

// Programmes
$router->get('/programmes', [ProgrammeController::class, 'index']);
$router->get('/programmes/{slug}', [ProgrammeController::class, 'show']);

// Departments
$router->get('/departments', [DepartmentController::class, 'index']);
$router->get('/departments/{slug}', [DepartmentController::class, 'show']);

// Faculty & Staff
$router->get('/faculty', [FacultyController::class, 'index']);

// Facilities
$router->get('/facilities', [FacilityController::class, 'index']);
$router->get('/facilities/{slug}', [FacilityController::class, 'show']);

// Notices & Announcements
$router->get('/notices', [NoticeController::class, 'index']);
$router->get('/notices/{slug}', [NoticeController::class, 'show']);

// Events
$router->get('/events', [EventController::class, 'index']);
$router->get('/events/{slug}', [EventController::class, 'show']);

// Downloads / Syllabus
$router->get('/downloads', [DownloadController::class, 'index']);
$router->get('/syllabus', [DownloadController::class, 'syllabus']);
$router->get('/syllabus/{branch}', [DownloadController::class, 'syllabusBranch']);

// Forms & Submissions
$router->get('/apply', [FormController::class, 'apply']);
$router->post('/apply', [FormController::class, 'submitApplication'], ['csrf', 'rate_limit:application']);
$router->get('/apply/success', [FormController::class, 'applicationSuccess']);
$router->post('/enquire', [FormController::class, 'submitEnquiry'], ['csrf', 'rate_limit:enquiry']);
$router->post('/contact', [FormController::class, 'submitContact'], ['csrf', 'rate_limit:enquiry']);

// Favicon Route Fallback
$router->get('/favicon.ico', function() {
    $file = ROOT_PATH . '/public/favicon.ico';
    if (file_exists($file)) {
        header('Content-Type: image/x-icon');
        readfile($file);
        exit;
    }
    http_response_code(404);
});

// XML Sitemap
$router->get('/sitemap.xml', function() {
    header('Content-Type: application/xml; charset=utf-8');
    require_once dirname(__DIR__, 2) . '/public/sitemap.php';
    exit;
});

// ==========================================
// Admin Authentication Routes
// ==========================================
$router->get('/admin/login', [AuthController::class, 'showLogin']);
$router->post('/admin/login', [AuthController::class, 'login'], ['csrf', 'rate_limit:login']);
$router->get('/admin/logout', [AuthController::class, 'logout']);

// ==========================================
// Protected Admin Panel Routes
// ==========================================
$router->group(['auth'], function(Router $r) {
    // Dashboard
    $r->get('/admin', [DashboardController::class, 'index']);

    // Programmes CRUD
    $r->get('/admin/programmes', [ProgrammeAdminController::class, 'index']);
    $r->get('/admin/programmes/create', [ProgrammeAdminController::class, 'create']);
    $r->post('/admin/programmes', [ProgrammeAdminController::class, 'store'], ['csrf']);
    $r->get('/admin/programmes/edit/{id}', [ProgrammeAdminController::class, 'edit']);
    $r->post('/admin/programmes/edit/{id}', [ProgrammeAdminController::class, 'update'], ['csrf']);
    $r->post('/admin/programmes/delete/{id}', [ProgrammeAdminController::class, 'delete'], ['csrf']);

    // Departments CRUD
    $r->get('/admin/departments', [DepartmentAdminController::class, 'index']);
    $r->get('/admin/departments/create', [DepartmentAdminController::class, 'create']);
    $r->post('/admin/departments', [DepartmentAdminController::class, 'store'], ['csrf']);
    $r->get('/admin/departments/edit/{id}', [DepartmentAdminController::class, 'edit']);
    $r->post('/admin/departments/edit/{id}', [DepartmentAdminController::class, 'update'], ['csrf']);
    $r->post('/admin/departments/delete/{id}', [DepartmentAdminController::class, 'delete'], ['csrf']);

    // Faculty CRUD
    $r->get('/admin/faculty', [FacultyAdminController::class, 'index']);
    $r->get('/admin/faculty/create', [FacultyAdminController::class, 'create']);
    $r->post('/admin/faculty', [FacultyAdminController::class, 'store'], ['csrf']);
    $r->get('/admin/faculty/edit/{id}', [FacultyAdminController::class, 'edit']);
    $r->post('/admin/faculty/edit/{id}', [FacultyAdminController::class, 'update'], ['csrf']);
    $r->post('/admin/faculty/delete/{id}', [FacultyAdminController::class, 'delete'], ['csrf']);

    // Notices CRUD
    $r->get('/admin/notices', [NoticeAdminController::class, 'index']);
    $r->get('/admin/notices/create', [NoticeAdminController::class, 'create']);
    $r->post('/admin/notices', [NoticeAdminController::class, 'store'], ['csrf']);
    $r->get('/admin/notices/edit/{id}', [NoticeAdminController::class, 'edit']);
    $r->post('/admin/notices/edit/{id}', [NoticeAdminController::class, 'update'], ['csrf']);
    $r->post('/admin/notices/delete/{id}', [NoticeAdminController::class, 'delete'], ['csrf']);

    // Events CRUD
    $r->get('/admin/events', [EventAdminController::class, 'index']);
    $r->get('/admin/events/create', [EventAdminController::class, 'create']);
    $r->post('/admin/events', [EventAdminController::class, 'store'], ['csrf']);
    $r->get('/admin/events/edit/{id}', [EventAdminController::class, 'edit']);
    $r->post('/admin/events/edit/{id}', [EventAdminController::class, 'update'], ['csrf']);
    $r->post('/admin/events/delete/{id}', [EventAdminController::class, 'delete'], ['csrf']);

    // Facilities CRUD
    $r->get('/admin/facilities', [FacilityAdminController::class, 'index']);
    $r->get('/admin/facilities/create', [FacilityAdminController::class, 'create']);
    $r->post('/admin/facilities', [FacilityAdminController::class, 'store'], ['csrf']);
    $r->get('/admin/facilities/edit/{id}', [FacilityAdminController::class, 'edit']);
    $r->post('/admin/facilities/edit/{id}', [FacilityAdminController::class, 'update'], ['csrf']);
    $r->post('/admin/facilities/delete/{id}', [FacilityAdminController::class, 'delete'], ['csrf']);

    // FAQs CRUD
    $r->get('/admin/faqs', [FaqAdminController::class, 'index']);
    $r->get('/admin/faqs/create', [FaqAdminController::class, 'create']);
    $r->post('/admin/faqs', [FaqAdminController::class, 'store'], ['csrf']);
    $r->get('/admin/faqs/edit/{id}', [FaqAdminController::class, 'edit']);
    $r->post('/admin/faqs/edit/{id}', [FaqAdminController::class, 'update'], ['csrf']);
    $r->post('/admin/faqs/delete/{id}', [FaqAdminController::class, 'delete'], ['csrf']);

    // Gallery CRUD
    $r->get('/admin/gallery', [GalleryAdminController::class, 'index']);
    $r->get('/admin/gallery/create', [GalleryAdminController::class, 'create']);
    $r->post('/admin/gallery', [GalleryAdminController::class, 'store'], ['csrf']);
    $r->get('/admin/gallery/edit/{id}', [GalleryAdminController::class, 'edit']);
    $r->post('/admin/gallery/edit/{id}', [GalleryAdminController::class, 'update'], ['csrf']);
    $r->post('/admin/gallery/delete/{id}', [GalleryAdminController::class, 'delete'], ['csrf']);

    // Downloads CRUD
    $r->get('/admin/downloads', [DownloadAdminController::class, 'index']);
    $r->get('/admin/downloads/create', [DownloadAdminController::class, 'create']);
    $r->post('/admin/downloads', [DownloadAdminController::class, 'store'], ['csrf']);
    $r->get('/admin/downloads/edit/{id}', [DownloadAdminController::class, 'edit']);
    $r->post('/admin/downloads/edit/{id}', [DownloadAdminController::class, 'update'], ['csrf']);
    $r->post('/admin/downloads/delete/{id}', [DownloadAdminController::class, 'delete'], ['csrf']);

    // Enquiries
    $r->get('/admin/enquiries', [EnquiryAdminController::class, 'index']);
    $r->get('/admin/enquiries/{id}', [EnquiryAdminController::class, 'show']);
    $r->post('/admin/enquiries/{id}', [EnquiryAdminController::class, 'updateStatus'], ['csrf']);
    $r->post('/admin/enquiries/delete/{id}', [EnquiryAdminController::class, 'delete'], ['csrf']);

    // Applications
    $r->get('/admin/applications', [ApplicationAdminController::class, 'index']);
    $r->get('/admin/applications/{id}', [ApplicationAdminController::class, 'show']);
    $r->post('/admin/applications/{id}', [ApplicationAdminController::class, 'updateStatus'], ['csrf']);

    // Site Settings
    $r->get('/admin/settings', [SettingAdminController::class, 'index']);
    $r->post('/admin/settings', [SettingAdminController::class, 'update'], ['csrf']);

    // Leadership Messages (Chairman, Director, Principal)
    $r->get('/admin/leadership', [LeadershipAdminController::class, 'index']);
    $r->post('/admin/leadership', [LeadershipAdminController::class, 'update'], ['csrf']);

    // Audit logs
    $r->get('/admin/audit-logs', [AuditLogAdminController::class, 'index']);

    // User Management (Superadmin role required)
    $r->get('/admin/users', [UserAdminController::class, 'index'], ['role:superadmin']);
    $r->get('/admin/users/create', [UserAdminController::class, 'create'], ['role:superadmin']);
    $r->post('/admin/users', [UserAdminController::class, 'store'], ['role:superadmin', 'csrf']);
    $r->get('/admin/users/edit/{id}', [UserAdminController::class, 'edit'], ['role:superadmin']);
    $r->post('/admin/users/edit/{id}', [UserAdminController::class, 'update'], ['role:superadmin', 'csrf']);
    $r->post('/admin/users/delete/{id}', [UserAdminController::class, 'delete'], ['role:superadmin', 'csrf']);
});

return $router;

