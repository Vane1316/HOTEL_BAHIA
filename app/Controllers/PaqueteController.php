<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Paquete;

class PaqueteController extends Controller {
    public function index(): void {
        $model = new Paquete();
        $edit = isset($_GET['edit']) ? $model->find((int)$_GET['edit']) : null;
        $this->render('paquetes/index', [
            'titulo' => 'Paquetes de habitación',
            'page' => 'paquetes',
            'paquetes' => $model->all(),
            'edit' => $edit ?: ['id'=>0,'nombre'=>'','descripcion'=>'','incluye'=>'','precio'=>'','estado'=>'activo'],
            'msg' => $_GET['msg'] ?? '',
        ]);
    }
    public function save(): void {
        (new Paquete())->save($_POST);
        $this->redirect('paquetes&msg=' . urlencode('Paquete guardado correctamente'));
    }
    public function delete(): void {
        (new Paquete())->delete((int)($_POST['id'] ?? 0));
        $this->redirect('paquetes&msg=' . urlencode('Paquete eliminado correctamente'));
    }
}
