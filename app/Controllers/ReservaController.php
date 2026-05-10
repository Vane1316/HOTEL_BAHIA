<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Models\Habitacion;
use App\Models\Paquete;

class ReservaController extends Controller {
    public function index(): void {
        $model = new Reserva();
        $edit = isset($_GET['edit']) ? $model->find((int)$_GET['edit']) : null;
        $this->render('reservas/index', [
            'titulo' => 'Reservas hoteleras',
            'page' => 'reservas',
            'reservas' => $model->allDetailed(),
            'usuarios' => (new Usuario())->active(),
            'habitaciones' => (new Habitacion())->all(),
            'paquetes' => (new Paquete())->active(),
            'edit' => $edit ?: ['id'=>0,'usuario_id'=>'','habitacion_id'=>'','paquete_id'=>'','cliente_nombre'=>'','cliente_documento'=>'','cliente_telefono'=>'','fecha_entrada'=>'','fecha_salida'=>'','cantidad_personas'=>1,'tipo_pago'=>'efectivo','precio_noche'=>'','precio_paquete'=>'','total_reserva'=>'','estado_reserva'=>'pendiente','observaciones'=>''],
            'msg' => $_GET['msg'] ?? '',
        ]);
    }
    public function save(): void {
        (new Reserva())->save($_POST);
        $this->redirect('reservas&msg=' . urlencode('Reserva guardada correctamente'));
    }
    public function delete(): void {
        (new Reserva())->delete((int)($_POST['id'] ?? 0));
        $this->redirect('reservas&msg=' . urlencode('Reserva eliminada correctamente'));
    }
}
