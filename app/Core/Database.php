<?php
namespace App\Core;
use mysqli;
use mysqli_stmt;

class Database {
    private static ?mysqli $connection = null;

    public static function connection(): mysqli {
        if (self::$connection === null) {
            $config = require __DIR__ . '/../Config/config.php';
            $db = $config['db'];
            self::$connection = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
            if (self::$connection->connect_error) {
                die('Error de conexión: ' . self::$connection->connect_error);
            }
            self::$connection->set_charset($db['charset']);
        }
        return self::$connection;
    }

    public static function prepare(string $sql): mysqli_stmt {
        return self::connection()->prepare($sql);
    }

    public static function execute(mysqli_stmt $stmt): bool {
        return $stmt->execute();
    }

    public static function getResult(mysqli_stmt $stmt): ?array {
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public static function getRow(mysqli_stmt $stmt): ?array {
        $result = $stmt->get_result();
        return $result && $result->num_rows ? $result->fetch_assoc() : null;
    }

    public static function scalar(mysqli_stmt $stmt) {
        $result = $stmt->get_result();
        if ($result && $result->num_rows) {
            $row = $result->fetch_assoc();
            return reset($row);
        }
        return 0;
    }
}
