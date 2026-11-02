<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Services\RateLimiter;

class RateLimitMiddleware
{
    public static function handle(string $action): void
    {
        $maxAttempts = match ($action) {
            'login' => 5,
            'application' => 10,
            'enquiry' => 15,
            default => 30
        };

        $decaySeconds = match ($action) {
            'login' => 900, // 15 minutes
            default => 3600 // 1 hour
        };

        if (!RateLimiter::check($action, $maxAttempts, $decaySeconds)) {
            http_response_code(429);
            flash('error', 'Too many requests. Please wait a few moments before trying again.');
            $referer = $_SERVER['HTTP_REFERER'] ?? url('/');
            header("Location: {$referer}");
            exit;
        }
    }
}

