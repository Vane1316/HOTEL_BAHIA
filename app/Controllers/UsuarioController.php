<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Usuario;

class UsuarioController extends Controller {
    public function index(): void {
        $model = new Usuario();
        $edit = isset($_GET['edit']) ? $model->find((int)$_GET['edit']) : null;
        $this->render('usuarios/index', [
            'titulo' => 'Gestión de usuarios',
            'page' => 'usuarios',
            'usuarios' => $model->all(),
            'edit' => $edit ?: ['id'=>0,'nombre_completo'=>'','usuario'=>'','email'=>'','rol'=>'recepcion','estado'=>'activo'],
            'msg' => $_GET['msg'] ?? '',
        ]);
    }
    public function save(): void {
        (new Usuario())->save($_POST);
        $this->redirect('usuarios&msg=' . urlencode('Usuario guardado correctamente'));
    }
    public function delete(): void {
        (new Usuario())->delete((int)($_POST['id'] ?? 0));
        $this->redirect('usuarios&msg=' . urlencode('Usuario eliminado correctamente'));
    }
}
