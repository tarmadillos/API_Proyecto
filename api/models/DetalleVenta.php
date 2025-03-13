<?php
class DetalleVenta {
    private $conn;
    private $table = "Detalle_Venta";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Crear un nuevo detalle de venta
    public function create($data) {
        $query = "INSERT INTO $this->table (ID_Venta, ID_Producto, Cantidad) 
                  VALUES (:id_venta, :id_producto, :cantidad)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_venta', $data['id_venta']);
        $stmt->bindParam(':id_producto', $data['id_producto']);
        $stmt->bindParam(':cantidad', $data['cantidad']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Leer un detalle de venta por ID
    public function read($id) {
        $query = "SELECT dv.*, p.Nombre AS Producto_Nombre, v.Fecha_Venta 
                  FROM $this->table dv 
                  JOIN Producto p ON dv.ID_Producto = p.ID_Producto 
                  JOIN Venta v ON dv.ID_Venta = v.ID_Venta 
                  WHERE dv.ID_Detalle = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Leer todos los detalles de venta
    public function readAll() {
        $query = "SELECT dv.*, p.Nombre AS Producto_Nombre, v.Fecha_Venta 
                  FROM $this->table dv 
                  JOIN Producto p ON dv.ID_Producto = p.ID_Producto 
                  JOIN Venta v ON dv.ID_Venta = v.ID_Venta";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar un detalle de venta
    public function update($id, $data) {
        $query = "UPDATE $this->table 
                  SET ID_Venta = :id_venta, ID_Producto = :id_producto, Cantidad = :cantidad 
                  WHERE ID_Detalle = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_venta', $data['id_venta']);
        $stmt->bindParam(':id_producto', $data['id_producto']);
        $stmt->bindParam(':cantidad', $data['cantidad']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Eliminar un detalle de venta
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE ID_Detalle = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>