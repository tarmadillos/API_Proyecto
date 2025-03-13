<?php
class Cliente {
    private $conn;
    private $table = "Cliente";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Crear un nuevo cliente
    public function create($data) {
        $query = "INSERT INTO $this->table (Nombre, Correo, Teléfono) 
                  VALUES (:nombre, :correo, :telefono)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':correo', $data['correo']);
        $stmt->bindParam(':telefono', $data['telefono']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Leer un cliente por ID
    public function read($id) {
        $query = "SELECT * FROM $this->table WHERE ID_Cliente = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Leer todos los clientes
    public function readAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar un cliente
    public function update($id, $data) {
        $query = "UPDATE $this->table 
                  SET Nombre = :nombre, Correo = :correo, Teléfono = :telefono 
                  WHERE ID_Cliente = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':correo', $data['correo']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Eliminar un cliente
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE ID_Cliente = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>