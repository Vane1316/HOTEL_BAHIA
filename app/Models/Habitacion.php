<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database as DB;

class Habitacion extends Model {
    public function all(): array {
        $stmt = DB::prepare('SELECT * FROM habitaciones ORDER BY numero ASC');
        DB::execute($stmt);
        return DB::getResult($stmt);
    }
    public function available(): array {
        $stmt = DB::prepare('SELECT * FROM habitaciones WHERE estado=? ORDER BY numero ASC');
        $stmt->bind_param('s', 'disponible');
        DB::execute($stmt);
        return DB::getResult($stmt);
    }
    public function find(int $id): ?array {
        $stmt = DB::prepare('SELECT * FROM habitaciones WHERE id=? LIMIT 1');
        $stmt->bind_param('i', $id);
        DB::execute($stmt);
        return DB::getRow($stmt);
    }
    public function save(array $data): bool {
        $id = (int)($data['id'] ?? 0);
        $numero = $data['numero'];
        $tipo = $data['tipo'];
        $capacidad = (int)$data['capacidad'];
        $precio = (float)$data['precio_noche'];
        $estado = $data['estado'];
        $descripcion = $data['descripcion'] ?? '';
        if ($id > 0) {
            $stmt = DB::prepare('UPDATE habitaciones SET numero=?, tipo=?, capacidad=?, precio_noche=?, estado=?, descripcion=? WHERE id=?');
            $stmt->bind_param('ssiissi', $numero, $tipo, $capacidad, $precio, $estado, $descripcion, $id);
            return DB::execute($stmt);
        }
        $stmt = DB::prepare('INSERT INTO habitaciones(numero,tipo,capacidad,precio_noche,estado,descripcion) VALUES(?,?,?,?,?,?)');
        $stmt->bind_param('ssiiss', $numero, $tipo, $capacidad, $precio, $estado, $descripcion);
        return DB::execute($stmt);
    }
    public function delete(int $id): bool {
        $stmt = DB::prepare('DELETE FROM habitaciones WHERE id=?');
        $stmt->bind_param('i', $id);
        return DB::execute($stmt);
    }
    public function countAll(): int {
        $stmt = DB::prepare('SELECT COUNT(*) total FROM habitaciones');
        DB::execute($stmt);
        return (int)DB::scalar($stmt);
    }
    public function countByStatus(string $status): int {
        $stmt = DB::prepare('SELECT COUNT(*) total FROM habitaciones WHERE estado=?');
        $stmt->bind_param('s', $status);
        DB::execute($stmt);
        return (int)DB::scalar($stmt);
    }
}
