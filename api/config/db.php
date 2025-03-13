<?php
class Database {
    private $host = "localhost";
    private $db_name = "inventario_facturacion";
    private $username = "root";
    private $password = ""; // Ajusta según tu configuración (puede ser vacío en XAMPP por defecto)
    private $conn;

    public function connect() {
        $dsn = "mysql:host=$this->host;dbname=$this->db_name;charset=utf8mb4";
        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>