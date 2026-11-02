<?php
declare(strict_types=1);

namespace App\Services;

use RuntimeException;

class UploadService
{
    private const ALLOWED_IMAGE_MIMES = [
        'image/jpeg' => 'jpg',
        'image/jpg'  => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif'
    ];

    private const ALLOWED_DOC_MIMES = [
        'application/pdf' => 'pdf',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
    ];

    public static function handleImageUpload(array $file, string $subfolder = 'images', int $maxBytes = 5242880): ?string
    {
        return self::processUpload($file, self::ALLOWED_IMAGE_MIMES, $maxBytes, "public/assets/images/{$subfolder}");
    }

    public static function handleDocumentUpload(array $file, string $subfolder = 'files', int $maxBytes = 10485760): ?string
    {
        return self::processUpload($file, self::ALLOWED_DOC_MIMES, $maxBytes, "public/assets/files/{$subfolder}");
    }

    public static function handlePrivateDocumentUpload(array $file, int $maxBytes = 10485760): ?string
    {
        return self::processUpload($file, self::ALLOWED_DOC_MIMES, $maxBytes, "storage/private", false);
    }

    private static function processUpload(array $file, array $allowedMimes, int $maxBytes, string $targetRelativeDir, bool $isPublic = true): ?string
    {
        if (!isset($file['error']) || is_array($file['error'])) {
            return null;
        }

        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException("Upload failed with error code: {$file['error']}");
        }

        if ($file['size'] > $maxBytes) {
            $mb = round($maxBytes / 1048576, 1);
            throw new RuntimeException("File exceeds maximum allowed size of {$mb}MB.");
        }

        // Verify MIME type using finfo
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        if (!array_key_exists($mime, $allowedMimes)) {
            throw new RuntimeException("Invalid file type: '{$mime}'. Allowed types: " . implode(', ', array_unique(array_values($allowedMimes))));
        }

        $extension = $allowedMimes[$mime];

        // Double check filename extension does not match executable patterns
        $origExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($origExt, ['php', 'phtml', 'php3', 'php4', 'php5', 'phps', 'phar', 'exe', 'bat', 'sh', 'cmd', 'js', 'cgi', 'pl'], true)) {
            throw new RuntimeException("Executable file extensions are strictly prohibited.");
        }

        $randomName = bin2hex(random_bytes(16)) . '.' . $extension;
        $rootDir = dirname(__DIR__, 2);
        $targetDir = $rootDir . '/' . trim($targetRelativeDir, '/');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $destination = $targetDir . '/' . $randomName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new RuntimeException("Failed to move uploaded file to destination.");
        }

        if ($isPublic) {
            // Return public path relative to web root
            $rel = str_replace($rootDir . '/public/', '', $destination);
            return str_replace('\\', '/', $rel);
        }

        return str_replace('\\', '/', $destination);
    }
}

