<?php
session_start();

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = __DIR__ . '/../app/' . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require __DIR__ . '/../app/Config/helpers.php';

use App\Core\Router;
use App\Controllers\DashboardController;
use App\Controllers\UsuarioController;
use App\Controllers\HabitacionController;
use App\Controllers\PaqueteController;
use App\Controllers\ReservaController;

$router = new Router();
$router->get('dashboard', [DashboardController::class, 'index']);
$router->get('usuarios', [UsuarioController::class, 'index']);
$router->post('usuarios/guardar', [UsuarioController::class, 'save']);
$router->post('usuarios/eliminar', [UsuarioController::class, 'delete']);
$router->get('habitaciones', [HabitacionController::class, 'index']);
$router->post('habitaciones/guardar', [HabitacionController::class, 'save']);
$router->post('habitaciones/eliminar', [HabitacionController::class, 'delete']);
$router->get('paquetes', [PaqueteController::class, 'index']);
$router->post('paquetes/guardar', [PaqueteController::class, 'save']);
$router->post('paquetes/eliminar', [PaqueteController::class, 'delete']);
$router->get('reservas', [ReservaController::class, 'index']);
$router->post('reservas/guardar', [ReservaController::class, 'save']);
$router->post('reservas/eliminar', [ReservaController::class, 'delete']);

$route = $_GET['route'] ?? 'dashboard';
$router->dispatch($_SERVER['REQUEST_METHOD'], $route);
