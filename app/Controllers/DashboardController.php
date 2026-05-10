<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Habitacion;
use App\Models\Reserva;
use App\Models\Usuario;

class DashboardController extends Controller {
    public function index(): void {
        $habitacionModel = new Habitacion();
        $reservaModel = new Reserva();
        $usuarioModel = new Usuario();
        $this->render('dashboard/index', [
            'titulo' => 'Panel principal',
            'page' => 'dashboard',
            'totalHabitaciones' => $habitacionModel->countAll(),
            'disponibles' => $habitacionModel->countByStatus('disponible'),
            'reservasMes' => $reservaModel->countMonth(),
            'ingresos' => $reservaModel->sumTotal(),
            'totalUsuarios' => $usuarioModel->countAll(),
            'ultimas' => $reservaModel->latest(),
        ]);
    }
}
