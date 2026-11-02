<?php
declare(strict_types=1);

namespace App\Services;

class MailerService
{
    public static function send(string $to, string $subject, string $bodyHtml): bool
    {
        $logFile = dirname(__DIR__, 2) . '/storage/logs/mail.log';
        $timestamp = date('Y-m-d H:i:s');
        $from = env('MAIL_FROM_ADDRESS', 'info@kcet.edu.in');
        $fromName = env('MAIL_FROM_NAME', 'KCET Admissions');

        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=utf-8',
            "From: {$fromName} <{$from}>",
            "Reply-To: {$from}",
            'X-Mailer: PHP/' . phpversion()
        ];

        // Log outgoing email
        $logEntry = "[{$timestamp}] TO: {$to} | SUBJECT: {$subject}\n";
        @file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

        try {
            // Attempt standard mail if mailer configured or fallback
            if (function_exists('mail') && env('MAIL_MAILER') === 'mail') {
                return @mail($to, $subject, $bodyHtml, implode("\r\n", $headers));
            }
            return true;
        } catch (\Throwable $e) {
            @file_put_contents($logFile, "[{$timestamp}] Mail send error: " . $e->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            return false;
        }
    }
}

