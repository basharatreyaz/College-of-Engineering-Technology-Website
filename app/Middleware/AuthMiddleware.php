<?php
declare(strict_types=1);

namespace App\Middleware;

class AuthMiddleware
{
    public static function handle(): void
    {
        $user = auth_user();
        if (!$user) {
            flash('error', 'Please log in to access the administration panel.');
            redirect('/admin/login');
        }

        if (($user['status'] ?? '') !== 'active') {
            \App\Services\Session::destroy();
            flash('error', 'Your account has been deactivated. Please contact the administrator.');
            redirect('/admin/login');
        }
    }

    public static function requireRole(array $allowedRoles): void
    {
        self::handle();

        $user = auth_user();
        if (!in_array($user['role'], $allowedRoles, true)) {
            http_response_code(403);
            flash('error', 'You do not have administrative permission to access this resource.');
            redirect('/admin');
        }
    }
}

