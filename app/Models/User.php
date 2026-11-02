<?php
declare(strict_types=1);

namespace App\Models;

class User extends BaseModel
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        return $this->findBy('email', strtolower(trim($email)));
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function recordLogin(int $userId): void
    {
        $this->update($userId, [
            'last_login_at' => date('Y-m-d H:i:s')
        ]);
    }
}

