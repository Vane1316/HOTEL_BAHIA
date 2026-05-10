<?php
namespace App\Core;

abstract class Model {
    protected $db;
    public function __construct() { $this->db = Database::connection(); }
    protected function escape(string $value): string { return $this->db->real_escape_string($value); }
}
