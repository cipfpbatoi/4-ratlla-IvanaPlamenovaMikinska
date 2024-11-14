<?php
namespace Joc4enRatlla\Services;

use PDO;
use PDOException;

class Database {
    private $host = 'db';
    private $db_name = '4ratlla';
    private $username = 'root';
    private $password = '1234';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }

        return $this->conn;
    }
    
    public function prepare($sql) {
        return $this->connect()->prepare($sql);
    }
}
