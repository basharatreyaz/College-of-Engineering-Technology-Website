<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Setting;
use App\Models\AuditLog;
use App\Services\View;
use App\Services\UploadService;

class LeadershipAdminController
{
    public function index(): void
    {
        $settingModel = new Setting();
        
        $keys = [
            'chairman_name', 'chairman_designation', 'chairman_photo', 'chairman_quote', 'chairman_message',
            'director_name', 'director_designation', 'director_photo', 'director_quote', 'director_message',
            'principal_name', 'principal_designation', 'principal_qualifications', 'principal_photo', 'principal_quote', 'principal_message'
        ];

        $leadership = [];
        foreach ($keys as $k) {
            $leadership[$k] = setting($k, '');
        }

        View::render('admin.leadership.index', [
            'pageTitle' => 'Leadership Messages | Admin',
            'leadership' => $leadership
        ], 'layouts.admin');
    }

    public function update(): void
    {
        $settingModel = new Setting();

        // 1. Chairman Photo & Fields
        if (!empty($_POST['remove_chairman_photo'])) {
            $settingModel->set('chairman_photo', '');
        }
        if (!empty($_FILES['chairman_photo']['name'])) {
            $path = UploadService::handleImageUpload($_FILES['chairman_photo'], 'leadership');
            if ($path) {
                $settingModel->set('chairman_photo', $path);
            }
        }
        $settingModel->set('chairman_name', trim($_POST['chairman_name'] ?? ''));
        $settingModel->set('chairman_designation', trim($_POST['chairman_designation'] ?? ''));
        $settingModel->set('chairman_quote', trim($_POST['chairman_quote'] ?? ''));
        $settingModel->set('chairman_message', trim($_POST['chairman_message'] ?? ''));

        // 2. Director Photo & Fields
        if (!empty($_POST['remove_director_photo'])) {
            $settingModel->set('director_photo', '');
        }
        if (!empty($_FILES['director_photo']['name'])) {
            $path = UploadService::handleImageUpload($_FILES['director_photo'], 'leadership');
            if ($path) {
                $settingModel->set('director_photo', $path);
            }
        }
        $settingModel->set('director_name', trim($_POST['director_name'] ?? ''));
        $settingModel->set('director_designation', trim($_POST['director_designation'] ?? ''));
        $settingModel->set('director_quote', trim($_POST['director_quote'] ?? ''));
        $settingModel->set('director_message', trim($_POST['director_message'] ?? ''));

        // 3. Principal Photo & Fields
        if (!empty($_POST['remove_principal_photo'])) {
            $settingModel->set('principal_photo', '');
        }
        if (!empty($_FILES['principal_photo']['name'])) {
            $path = UploadService::handleImageUpload($_FILES['principal_photo'], 'leadership');
            if ($path) {
                $settingModel->set('principal_photo', $path);
            }
        }
        $settingModel->set('principal_name', trim($_POST['principal_name'] ?? ''));
        $settingModel->set('principal_designation', trim($_POST['principal_designation'] ?? ''));
        $settingModel->set('principal_qualifications', trim($_POST['principal_qualifications'] ?? ''));
        $settingModel->set('principal_quote', trim($_POST['principal_quote'] ?? ''));
        $settingModel->set('principal_message', trim($_POST['principal_message'] ?? ''));

        AuditLog::log('update', 'leadership', 'all', 'Updated Chairman, Director & Principal messages.');
        flash('success', 'Leadership messages updated successfully.');
        redirect('/admin/leadership');
    }
}

