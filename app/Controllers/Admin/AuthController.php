<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\AuditLog;
use App\Services\Session;
use App\Services\View;
use App\Services\RateLimiter;

class AuthController
{
    public function showLogin(): void
    {
        if (auth_user()) {
            redirect('/admin');
        }

        View::render('admin.login', [
            'pageTitle' => 'Admin Login | KCET Portal'
        ], 'layouts.auth');
    }

    public function login(): void
    {
        if (!RateLimiter::check('login', 5, 900)) {
            flash('error', 'Too many failed login attempts. Please wait 15 minutes before trying again.');
            redirect('/admin/login');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $requestedRole = trim($_POST['role'] ?? '');

        if (empty($email) || empty($password)) {
            flash('error', 'Please enter both email and password.');
            redirect('/admin/login');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !$userModel->verifyPassword($password, $user['password_hash'])) {
            RateLimiter::hit('login', 900);
            AuditLog::log('failed_login', 'auth', $email, 'Failed login attempt with email: ' . $email);
            flash('error', 'Invalid login credentials. Please verify your email and password.');
            redirect('/admin/login');
        }

        if ($user['status'] !== 'active') {
            RateLimiter::hit('login', 900);
            flash('error', 'This account has been disabled. Please contact the Super Admin.');
            redirect('/admin/login');
        }

        // Verify role authorization if a specific role was toggled
        if (!empty($requestedRole)) {
            $roleAllowed = false;
            if ($user['role'] === 'superadmin') {
                $roleAllowed = true; // Superadmin has access across all portals
            } elseif ($requestedRole === $user['role']) {
                $roleAllowed = true;
            }

            if (!$roleAllowed) {
                RateLimiter::hit('login', 900);
                $roleLabels = [
                    'superadmin' => 'Institutional Super Admin',
                    'admissions' => 'Admissions Desk',
                    'editor' => 'Content Editor'
                ];
                $requestedLabel = $roleLabels[$requestedRole] ?? $requestedRole;
                flash('error', "Access restricted: Your account does not have permissions for the {$requestedLabel} role.");
                redirect('/admin/login');
            }
        }

        // Successful authentication
        RateLimiter::clear('login');
        Session::regenerate();

        Session::set('admin_user', [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'status' => $user['status'],
        ]);

        $userModel->recordLogin((int)$user['id']);
        AuditLog::log('login', 'auth', (string)$user['id'], 'User logged in successfully.');

        flash('success', "Welcome back, {$user['name']}!");
        redirect('/admin');
    }

    public function logout(): void
    {
        $user = auth_user();
        if ($user) {
            AuditLog::log('logout', 'auth', (string)$user['id'], 'User logged out.');
        }

        Session::destroy();
        redirect('/admin/login');
    }
}

