php

Contraer

Ajuste

Copiar
<?php
class Categoria {
    private $conn;
    private $table = "Categoría";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Crear una nueva categoría
    public function create($data) {
        $query = "INSERT INTO $this->table (Nombre, Descripción) VALUES (:nombre, :descripcion)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Leer una categoría por ID
    public function read($id) {
        $query = "SELECT * FROM $this->table WHERE ID_Categoría = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Leer todas las categorías
    public function readAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar una categoría
    public function update($id, $data) {
        $query = "UPDATE $this->table SET Nombre = :nombre, Descripción = :descripcion WHERE ID_Categoría = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Eliminar una categoría
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE ID_Categoría = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>