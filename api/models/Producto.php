<?php
class Producto {
    private $conn;
    private $table = "Producto";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function create($data) {
        $query = "INSERT INTO $this->table (Nombre, Descripción, Precio, ID_Categoría) VALUES (:nombre, :descripcion, :precio, :id_categoria)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':id_categoria', $data['id_categoria']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function read($id) {
        $query = "SELECT * FROM $this->table WHERE ID_Producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function readAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $query = "UPDATE $this->table SET Nombre = :nombre, Descripción = :descripcion, Precio = :precio, ID_Categoría = :id_categoria WHERE ID_Producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':id_categoria', $data['id_categoria']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE ID_Producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>