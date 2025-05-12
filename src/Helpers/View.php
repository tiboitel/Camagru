<?php
namespace Tiboitel\Camagru\Helpers;

class View
{
    public static function render(string $viewPath, array $params = []): void
    {
        $fullPath = __DIR__ . '/../Views/' . $viewPath . '.php';

        if (!file_exists($fullPath)) {
            http_response_code(500);
            echo "View not found: $fullPath";
            return;
        }

        // Extract parameters to variables
        extract($params, EXTR_SKIP);

        // Start output buffering
        ob_start();
        require $fullPath;
        $content = ob_get_clean();

        // Load layout and inject content
        require __DIR__ . '/../Views/layout.php';
    }
}

