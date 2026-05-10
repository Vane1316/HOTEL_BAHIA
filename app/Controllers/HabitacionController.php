<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Habitacion;

class HabitacionController extends Controller {
    public function index(): void {
        $model = new Habitacion();
        $edit = isset($_GET['edit']) ? $model->find((int)$_GET['edit']) : null;
        $this->render('habitaciones/index', [
            'titulo' => 'Habitaciones',
            'page' => 'habitaciones',
            'habitaciones' => $model->all(),
            'edit' => $edit ?: ['id'=>0,'numero'=>'','tipo'=>'','capacidad'=>2,'precio_noche'=>'','estado'=>'disponible','descripcion'=>''],
            'msg' => $_GET['msg'] ?? '',
        ]);
    }
    public function save(): void {
        (new Habitacion())->save($_POST);
        $this->redirect('habitaciones&msg=' . urlencode('Habitación guardada correctamente'));
    }
    public function delete(): void {
        (new Habitacion())->delete((int)($_POST['id'] ?? 0));
        $this->redirect('habitaciones&msg=' . urlencode('Habitación eliminada correctamente'));
    }
}
