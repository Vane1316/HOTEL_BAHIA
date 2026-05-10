<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database as DB;

class Paquete extends Model {
    public function all(): array {
        $stmt = DB::prepare('SELECT * FROM paquetes_habitacion ORDER BY id DESC');
        DB::execute($stmt);
        return DB::getResult($stmt);
    }
    public function active(): array {
        $estado = 'activo';
        $stmt = DB::prepare('SELECT * FROM paquetes_habitacion WHERE estado=? ORDER BY nombre');
        $stmt->bind_param('s', $estado);
        DB::execute($stmt);
        return DB::getResult($stmt);
    }
    public function find(int $id): ?array {
        $stmt = DB::prepare('SELECT * FROM paquetes_habitacion WHERE id=? LIMIT 1');
        $stmt->bind_param('i', $id);
        DB::execute($stmt);
        return DB::getRow($stmt);
    }
    public function save(array $data): bool {
        $id = (int)($data['id'] ?? 0);
        $nombre = $data['nombre'];
        $descripcion = $data['descripcion'] ?? '';
        $incluye = $data['incluye'] ?? '';
        $precio = (float)$data['precio'];
        $estado = $data['estado'];
        if ($id > 0) {
            $stmt = DB::prepare('UPDATE paquetes_habitacion SET nombre=?, descripcion=?, incluye=?, precio=?, estado=? WHERE id=?');
            $stmt->bind_param('sssdsi', $nombre, $descripcion, $incluye, $precio, $estado, $id);
            return DB::execute($stmt);
        }
        $stmt = DB::prepare('INSERT INTO paquetes_habitacion(nombre,descripcion,incluye,precio,estado) VALUES(?,?,?,?,?)');
        $stmt->bind_param('sssds', $nombre, $descripcion, $incluye, $precio, $estado);
        return DB::execute($stmt);
    }
    public function delete(int $id): bool {
        $stmt = DB::prepare('DELETE FROM paquetes_habitacion WHERE id=?');
        $stmt->bind_param('i', $id);
        return DB::execute($stmt);
    }
}
