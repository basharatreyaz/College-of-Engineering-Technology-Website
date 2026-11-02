<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\AuditLog;
use App\Services\View;

class UserAdminController
{
    public function index(): void
    {
        $model = new User();
        $users = $model->all('role ASC, name ASC');

        View::render('admin.users.index', [
            'pageTitle' => 'Manage Admin Users | Admin',
            'users' => $users
        ], 'layouts.admin');
    }

    public function create(): void
    {
        View::render('admin.users.form', [
            'pageTitle' => 'Create Admin User | Admin',
            'user' => null
        ], 'layouts.admin');
    }

    public function store(): void
    {
        $email = strtolower(trim($_POST['email'] ?? ''));
        $name = trim($_POST['name'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = trim($_POST['role'] ?? 'editor');

        if (empty($email) || empty($password) || empty($name)) {
            flash('error', 'Please fill in all required fields.');
            redirect('/admin/users/create');
        }

        $model = new User();
        if ($model->findByEmail($email)) {
            flash('error', 'A user with this email address already exists.');
            redirect('/admin/users/create');
        }

        $id = $model->create([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'role' => $role,
            'status' => 'active'
        ]);

        AuditLog::log('create', 'user', (string)$id, "Created admin user: {$email} ({$role})");
        flash('success', 'Admin user created successfully.');
        redirect('/admin/users');
    }

    public function edit(string $id): void
    {
        $model = new User();
        $user = $model->find((int)$id);
        if (!$user) {
            flash('error', 'User not found.');
            redirect('/admin/users');
        }

        View::render('admin.users.form', [
            'pageTitle' => 'Edit User | Admin',
            'user' => $user
        ], 'layouts.admin');
    }

    public function update(string $id): void
    {
        $model = new User();
        $user = $model->find((int)$id);
        if (!$user) {
            flash('error', 'User not found.');
            redirect('/admin/users');
        }

        $email = strtolower(trim($_POST['email'] ?? ''));
        $name = trim($_POST['name'] ?? '');
        $role = trim($_POST['role'] ?? 'editor');
        $status = trim($_POST['status'] ?? 'active');

        $data = [
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'status' => $status
        ];

        if (!empty($_POST['password'])) {
            $data['password_hash'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        $model->update((int)$id, $data);
        AuditLog::log('update', 'user', (string)$id, "Updated user: {$email}");
        flash('success', 'User updated successfully.');
        redirect('/admin/users');
    }

    public function delete(string $id): void
    {
        $currentUser = auth_user();
        if ((int)$currentUser['id'] === (int)$id) {
            flash('error', 'You cannot delete your own account.');
            redirect('/admin/users');
        }

        $model = new User();
        $user = $model->find((int)$id);
        if ($user) {
            $model->delete((int)$id);
            AuditLog::log('delete', 'user', (string)$id, "Deleted user: {$user['email']}");
            flash('success', 'User removed.');
        }
        redirect('/admin/users');
    }
}

