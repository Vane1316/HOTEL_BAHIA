<?php
namespace App\Core;

abstract class Controller {
    protected function render(string $view, array $data = []): void {
        extract($data);
        $config = require __DIR__ . '/../Config/config.php';
        $appName = $config['app_name'];
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        require __DIR__ . '/../Views/layouts/header.php';
        require $viewPath;
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    protected function redirect(string $route): void {
        $config = require __DIR__ . '/../Config/config.php';
        header('Location: ' . $config['base_url'] . '?route=' . $route);
        exit;
    }
}
