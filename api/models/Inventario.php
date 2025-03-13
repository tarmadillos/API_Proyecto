<?php
class Inventario {
    private $conn;
    private $table = "Inventario";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Crear un nuevo registro de inventario
    public function create($data) {
        $query = "INSERT INTO $this->table (ID_Producto, Stock_Actual, Entradas, Salidas, Punto_Reorden) 
                  VALUES (:id_producto, :stock_actual, :entradas, :salidas, :punto_reorden)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_producto', $data['id_producto']);
        $stmt->bindParam(':stock_actual', $data['stock_actual']);
        $stmt->bindParam(':entradas', $data['entradas']);
        $stmt->bindParam(':salidas', $data['salidas']);
        $stmt->bindParam(':punto_reorden', $data['punto_reorden']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Leer un registro de inventario por ID
    public function read($id) {
        $query = "SELECT * FROM $this->table WHERE ID_Inventario = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Leer todos los registros de inventario
    public function readAll() {
        $query = "SELECT i.*, p.Nombre AS Producto_Nombre 
                  FROM $this->table i 
                  JOIN Producto p ON i.ID_Producto = p.ID_Producto";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar un registro de inventario
    public function update($id, $data) {
        $query = "UPDATE $this->table 
                  SET ID_Producto = :id_producto, Stock_Actual = :stock_actual, 
                      Entradas = :entradas, Salidas = :salidas, Punto_Reorden = :punto_reorden 
                  WHERE ID_Inventario = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_producto', $data['id_producto']);
        $stmt->bindParam(':stock_actual', $data['stock_actual']);
        $stmt->bindParam(':entradas', $data['entradas']);
        $stmt->bindParam(':salidas', $data['salidas']);
        $stmt->bindParam(':punto_reorden', $data['punto_reorden']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Eliminar un registro de inventario
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE ID_Inventario = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>