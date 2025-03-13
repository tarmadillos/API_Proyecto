<?php
class Venta {
    private $conn;
    private $table = "Venta";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function create($data) {
        try {
            $this->conn->beginTransaction();

            // Insertar en Venta
            $query = "INSERT INTO $this->table (ID_Cliente, Fecha_Venta) VALUES (:id_cliente, SYSDATE)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cliente', $data['id_cliente']);
            if (!$stmt->execute()) {
                throw new Exception("Error al registrar la venta");
            }
            $id_venta = $this->conn->lastInsertId();

            // Validar stock y registrar detalles
            foreach ($data['detalles'] as $detalle) {
                // Verificar stock
                $query = "SELECT Stock_Actual FROM Inventario WHERE ID_Producto = :id_producto";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id_producto', $detalle['id_producto']);
                $stmt->execute();
                $stock = $stmt->fetchColumn();

                if ($stock < $detalle['cantidad']) {
                    throw new Exception("Stock insuficiente para el producto ID: " . $detalle['id_producto']);
                }

                // Insertar en Detalle_Venta
                $query = "INSERT INTO Detalle_Venta (ID_Venta, ID_Producto, Cantidad) VALUES (:id_venta, :id_producto, :cantidad)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id_venta', $id_venta);
                $stmt->bindParam(':id_producto', $detalle['id_producto']);
                $stmt->bindParam(':cantidad', $detalle['cantidad']);
                $stmt->execute();

                // Actualizar inventario
                $query = "UPDATE Inventario SET Stock_Actual = Stock_Actual - :cantidad, Salidas = Salidas + :cantidad WHERE ID_Producto = :id_producto";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':cantidad', $detalle['cantidad']);
                $stmt->bindParam(':id_producto', $detalle['id_producto']);
                $stmt->execute();
            }

            $this->conn->commit();
            return $id_venta;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function read($id) {
        $query = "SELECT v.*, c.Nombre AS Cliente_Nombre, d.ID_Producto, d.Cantidad, p.Nombre AS Producto_Nombre
                  FROM $this->table v
                  JOIN Cliente c ON v.ID_Cliente = c.ID_Cliente
                  LEFT JOIN Detalle_Venta d ON v.ID_Venta = d.ID_Venta
                  LEFT JOIN Producto p ON d.ID_Producto = p.ID_Producto
                  WHERE v.ID_Venta = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAll() {
        $query = "SELECT v.*, c.Nombre AS Cliente_Nombre
                  FROM $this->table v
                  JOIN Cliente c ON v.ID_Cliente = c.ID_Cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>