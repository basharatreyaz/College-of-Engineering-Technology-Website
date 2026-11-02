<?php
declare(strict_types=1);

namespace App\Services;

use RuntimeException;

class View
{
    private static string $viewsPath = '';

    private static function initPath(): void
    {
        if (empty(self::$viewsPath)) {
            self::$viewsPath = dirname(__DIR__) . '/Views';
        }
    }

    public static function render(string $view, array $data = [], string $layout = 'layouts/main'): void
    {
        self::initPath();
        $viewFile = self::$viewsPath . '/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewFile)) {
            throw new RuntimeException("View file not found: {$viewFile}");
        }

        // Extract variables to view scope
        extract($data, EXTR_SKIP);

        // Capture view content
        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        // If no layout requested, output directly
        if (empty($layout)) {
            echo $content;
            return;
        }

        $layoutFile = self::$viewsPath . '/' . str_replace('.', '/', $layout) . '.php';
        if (!file_exists($layoutFile)) {
            throw new RuntimeException("Layout file not found: {$layoutFile}");
        }

        // Layout receives $content plus all original $data
        include $layoutFile;
    }

    public static function component(string $name, array $data = []): void
    {
        self::initPath();
        $componentFile = self::$viewsPath . '/components/' . str_replace('.', '/', $name) . '.php';

        if (!file_exists($componentFile)) {
            throw new RuntimeException("Component file not found: {$componentFile}");
        }

        extract($data, EXTR_SKIP);
        include $componentFile;
    }
}

