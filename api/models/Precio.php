<?php
class Precio {
    private $conn;
    private $table = "Precio";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Crear un nuevo precio
    public function create($data) {
        $query = "INSERT INTO $this->table (ID_Producto, Precio_Costo, Precio_Venta, Fecha_Inicio, Fecha_Fin) 
                  VALUES (:id_producto, :precio_costo, :precio_venta, SYSDATE, :fecha_fin)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_producto', $data['id_producto']);
        $stmt->bindParam(':precio_costo', $data['precio_costo']);
        $stmt->bindParam(':precio_venta', $data['precio_venta']);
        $stmt->bindParam(':fecha_fin', $data['fecha_fin']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Leer un precio por ID
    public function read($id) {
        $query = "SELECT p.*, pr.Nombre AS Producto_Nombre 
                  FROM $this->table p 
                  JOIN Producto pr ON p.ID_Producto = pr.ID_Producto 
                  WHERE p.ID_Precio = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Leer todos los precios
    public function readAll() {
        $query = "SELECT p.*, pr.Nombre AS Producto_Nombre 
                  FROM $this->table p 
                  JOIN Producto pr ON p.ID_Producto = pr.ID_Producto";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar un precio
    public function update($id, $data) {
        $query = "UPDATE $this->table 
                  SET ID_Producto = :id_producto, Precio_Costo = :precio_costo, 
                      Precio_Venta = :precio_venta, Fecha_Fin = :fecha_fin 
                  WHERE ID_Precio = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_producto', $data['id_producto']);
        $stmt->bindParam(':precio_costo', $data['precio_costo']);
        $stmt->bindParam(':precio_venta', $data['precio_venta']);
        $stmt->bindParam(':fecha_fin', $data['fecha_fin']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Eliminar un precio
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE ID_Precio = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>