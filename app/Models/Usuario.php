<?php
namespace App\Models;
use App\Core\Model;
use App\Core\Database as DB;

class Usuario extends Model {
    public function all(): array {
        $stmt = DB::prepare('SELECT * FROM usuarios ORDER BY id DESC');
        DB::execute($stmt);
        return DB::getResult($stmt);
    }
    public function find(int $id): ?array {
        $stmt = DB::prepare('SELECT * FROM usuarios WHERE id=? LIMIT 1');
        $stmt->bind_param('i', $id);
        DB::execute($stmt);
        return DB::getRow($stmt);
    }
    public function active(): array {
        $stmt = DB::prepare('SELECT id, nombre_completo FROM usuarios WHERE estado=? ORDER BY nombre_completo');
        $stmt->bind_param('s', 'activo');
        DB::execute($stmt);
        return DB::getResult($stmt);
    }
    public function save(array $data): bool {
        $id = (int)($data['id'] ?? 0);
        $nombre = $data['nombre_completo'];
        $usuario = $data['usuario'];
        $email = $data['email'];
        $rol = $data['rol'];
        $estado = $data['estado'];
        if ($id > 0) {
            if (!empty($data['password'])) {
                $hash = password_hash($data['password'], PASSWORD_DEFAULT);
                $stmt = DB::prepare('UPDATE usuarios SET nombre_completo=?, usuario=?, email=?, password=?, rol=?, estado=? WHERE id=?');
                $stmt->bind_param('ssssssi', $nombre, $usuario, $email, $hash, $rol, $estado, $id);
            } else {
                $stmt = DB::prepare('UPDATE usuarios SET nombre_completo=?, usuario=?, email=?, rol=?, estado=? WHERE id=?');
                $stmt->bind_param('sssssi', $nombre, $usuario, $email, $rol, $estado, $id);
            }
            return DB::execute($stmt);
        }
        $password = !empty($data['password']) ? $data['password'] : '123456';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = DB::prepare('INSERT INTO usuarios(nombre_completo,usuario,email,password,rol,estado) VALUES(?,?,?,?,?,?)');
        $stmt->bind_param('ssssss', $nombre, $usuario, $email, $hash, $rol, $estado);
        return DB::execute($stmt);
    }
    public function delete(int $id): bool {
        $stmt = DB::prepare('DELETE FROM usuarios WHERE id=?');
        $stmt->bind_param('i', $id);
        return DB::execute($stmt);
    }
    public function countAll(): int {
        $stmt = DB::prepare('SELECT COUNT(*) total FROM usuarios');
        DB::execute($stmt);
        return (int)DB::scalar($stmt);
    }
}
