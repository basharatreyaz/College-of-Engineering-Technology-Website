<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Services\Csrf;

class CsrfMiddleware
{
    public static function handle(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if (in_array(strtoupper($method), ['POST', 'PUT', 'DELETE'], true)) {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

            if (!Csrf::validate($token)) {
                http_response_code(419);
                flash('error', 'Your session has expired or the security token was invalid. Please try submitting again.');
                
                // Return back to referring page or root
                $referer = $_SERVER['HTTP_REFERER'] ?? url('/');
                header("Location: {$referer}");
                exit;
            }
        }
    }
}

