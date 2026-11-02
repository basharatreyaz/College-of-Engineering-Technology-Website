<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Setting;
use App\Models\AuditLog;
use App\Services\View;

class SettingAdminController
{
    public function index(): void
    {
        $model = new Setting();
        $settingsGrouped = $model->getAllGrouped();

        View::render('admin.settings.index', [
            'pageTitle' => 'Site Settings | Admin',
            'settingsGrouped' => $settingsGrouped
        ], 'layouts.admin');
    }

    public function update(): void
    {
        $model = new Setting();
        $postData = $_POST['settings'] ?? [];

        foreach ($postData as $key => $value) {
            $model->set($key, trim($value));
        }

        AuditLog::log('update', 'settings', 'all', 'Updated college site settings.');
        flash('success', 'Site settings updated successfully.');
        redirect('/admin/settings');
    }
}

