<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database as DB;

class Reserva extends Model {
    public function allDetailed(): array {
        $sql = "SELECT r.*, u.nombre_completo, h.numero, h.tipo, p.nombre AS paquete
                FROM reservas r
                INNER JOIN usuarios u ON u.id = r.usuario_id
                INNER JOIN habitaciones h ON h.id = r.habitacion_id
                LEFT JOIN paquetes_habitacion p ON p.id = r.paquete_id
                ORDER BY r.id DESC";
        $stmt = DB::prepare($sql);
        DB::execute($stmt);
        return DB::getResult($stmt);
    }
    public function latest(int $limit = 5): array {
        $limit = (int)$limit;
        $sql = "SELECT r.*, u.nombre_completo, h.numero, p.nombre AS paquete
                FROM reservas r
                INNER JOIN usuarios u ON u.id = r.usuario_id
                INNER JOIN habitaciones h ON h.id = r.habitacion_id
                LEFT JOIN paquetes_habitacion p ON p.id = r.paquete_id
                ORDER BY r.id DESC LIMIT ?";
        $stmt = DB::prepare($sql);
        $stmt->bind_param('i', $limit);
        DB::execute($stmt);
        return DB::getResult($stmt);
    }
    public function find(int $id): ?array {
        $stmt = DB::prepare('SELECT * FROM reservas WHERE id=? LIMIT 1');
        $stmt->bind_param('i', $id);
        DB::execute($stmt);
        return DB::getRow($stmt);
    }
    public function save(array $data): bool {
        $id = (int)($data['id'] ?? 0);
        $usuario_id = (int)$data['usuario_id'];
        $habitacion_id = (int)$data['habitacion_id'];
        $paquete_id = !empty($data['paquete_id']) ? (int)$data['paquete_id'] : null;
        $cliente_nombre = $data['cliente_nombre'];
        $cliente_documento = $data['cliente_documento'];
        $cliente_telefono = $data['cliente_telefono'];
        $fecha_entrada = $data['fecha_entrada'];
        $fecha_salida = $data['fecha_salida'];
        $cantidad_personas = (int)$data['cantidad_personas'];
        $tipo_pago = $data['tipo_pago'];
        $precio_noche = (float)$data['precio_noche'];
        $precio_paquete = (float)$data['precio_paquete'];
        $total_reserva = (float)$data['total_reserva'];
        $estado = $data['estado_reserva'];
        $observaciones = $data['observaciones'] ?? '';

        if ($id > 0) {
            if ($paquete_id) {
                $stmt = DB::prepare('UPDATE reservas SET usuario_id=?, habitacion_id=?, paquete_id=?, cliente_nombre=?, cliente_documento=?, cliente_telefono=?, fecha_entrada=?, fecha_salida=?, cantidad_personas=?, tipo_pago=?, precio_noche=?, precio_paquete=?, total_reserva=?, estado_reserva=?, observaciones=? WHERE id=?');
                $stmt->bind_param('iiiisssssidssdsi', $usuario_id, $habitacion_id, $paquete_id, $cliente_nombre, $cliente_documento, $cliente_telefono, $fecha_entrada, $fecha_salida, $cantidad_personas, $tipo_pago, $precio_noche, $precio_paquete, $total_reserva, $estado, $observaciones, $id);
            } else {
                $stmt = DB::prepare('UPDATE reservas SET usuario_id=?, habitacion_id=?, paquete_id=NULL, cliente_nombre=?, cliente_documento=?, cliente_telefono=?, fecha_entrada=?, fecha_salida=?, cantidad_personas=?, tipo_pago=?, precio_noche=?, precio_paquete=?, total_reserva=?, estado_reserva=?, observaciones=? WHERE id=?');
                $stmt->bind_param('iisssssidssdsi', $usuario_id, $habitacion_id, $cliente_nombre, $cliente_documento, $cliente_telefono, $fecha_entrada, $fecha_salida, $cantidad_personas, $tipo_pago, $precio_noche, $precio_paquete, $total_reserva, $estado, $observaciones, $id);
            }
            return DB::execute($stmt);
        }

        if ($paquete_id) {
            $stmt = DB::prepare('INSERT INTO reservas(usuario_id, habitacion_id, paquete_id, cliente_nombre, cliente_documento, cliente_telefono, fecha_reserva, fecha_entrada, fecha_salida, cantidad_personas, tipo_pago, precio_noche, precio_paquete, total_reserva, estado_reserva, observaciones) VALUES(?, ?, ?, ?, ?, ?, CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('iiiisssssidsss', $usuario_id, $habitacion_id, $paquete_id, $cliente_nombre, $cliente_documento, $cliente_telefono, $fecha_entrada, $fecha_salida, $cantidad_personas, $tipo_pago, $precio_noche, $precio_paquete, $total_reserva, $estado, $observaciones);
        } else {
            $stmt = DB::prepare('INSERT INTO reservas(usuario_id, habitacion_id, cliente_nombre, cliente_documento, cliente_telefono, fecha_reserva, fecha_entrada, fecha_salida, cantidad_personas, tipo_pago, precio_noche, precio_paquete, total_reserva, estado_reserva, observaciones) VALUES(?, ?, ?, ?, ?, CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('iisssssidsss', $usuario_id, $habitacion_id, $cliente_nombre, $cliente_documento, $cliente_telefono, $fecha_entrada, $fecha_salida, $cantidad_personas, $tipo_pago, $precio_noche, $precio_paquete, $total_reserva, $estado, $observaciones);
        }
        $ok = DB::execute($stmt);
        if ($ok && in_array($estado, ['pendiente', 'confirmada'], true)) {
            $updateStmt = DB::prepare("UPDATE habitaciones SET estado=? WHERE id=? AND estado=?");
            $ocupada = 'ocupada';
            $disponible = 'disponible';
            $updateStmt->bind_param('sis', $ocupada, $habitacion_id, $disponible);
            DB::execute($updateStmt);
        }
        return $ok;
    }
    public function delete(int $id): bool {
        $stmt = DB::prepare('DELETE FROM reservas WHERE id=?');
        $stmt->bind_param('i', $id);
        return DB::execute($stmt);
    }
    public function countMonth(): int {
        $stmt = DB::prepare("SELECT COUNT(*) total FROM reservas WHERE MONTH(fecha_reserva)=MONTH(CURDATE()) AND YEAR(fecha_reserva)=YEAR(CURDATE())");
        DB::execute($stmt);
        return (int)DB::scalar($stmt);
    }
    public function sumTotal(): float {
        $stmt = DB::prepare("SELECT COALESCE(SUM(total_reserva),0) total FROM reservas WHERE estado_reserva IN ('pendiente','confirmada','finalizada')");
        DB::execute($stmt);
        return (float)DB::scalar($stmt);
    }
}
