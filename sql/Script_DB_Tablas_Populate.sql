-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS inventario_facturacion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inventario_facturacion;
-- Creación de tablas
CREATE TABLE Categoría (
    ID_Categoría INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripción VARCHAR(200)
) ENGINE=InnoDB;
	
CREATE TABLE Producto (
    ID_Producto INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripción VARCHAR(200),
    Precio DECIMAL(10,2) NOT NULL CHECK (Precio > 0),
    ID_Categoría INT NOT NULL,
    FOREIGN KEY (ID_Categoría) REFERENCES Categoría(ID_Categoría)
) ENGINE=InnoDB;
	
CREATE TABLE Inventario (
    ID_Inventario INT AUTO_INCREMENT PRIMARY KEY,
    ID_Producto INT NOT NULL,
    Stock_Actual INT DEFAULT 0 NOT NULL CHECK (Stock_Actual >= 0),
    Entradas INT DEFAULT 0 NOT NULL CHECK (Entradas >= 0),
    Salidas INT DEFAULT 0 NOT NULL CHECK (Salidas >= 0),
    Punto_Reorden INT NOT NULL CHECK (Punto_Reorden > 0),
    FOREIGN KEY (ID_Producto) REFERENCES Producto(ID_Producto)
) ENGINE=InnoDB;

CREATE TABLE Cliente (
    ID_Cliente INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Correo VARCHAR(100) NOT NULL UNIQUE,
    Teléfono VARCHAR(20)
) ENGINE=InnoDB;

CREATE TABLE Venta (
    ID_Venta INT AUTO_INCREMENT PRIMARY KEY,
    ID_Cliente INT NOT NULL,
    Fecha_Venta DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (ID_Cliente) REFERENCES Cliente(ID_Cliente)
) ENGINE=InnoDB;

CREATE TABLE Detalle_Venta (
    ID_Detalle INT AUTO_INCREMENT PRIMARY KEY,
    ID_Venta INT NOT NULL,
    ID_Producto INT NOT NULL,
    Cantidad INT NOT NULL CHECK (Cantidad > 0),
    FOREIGN KEY (ID_Venta) REFERENCES Venta(ID_Venta),
    FOREIGN KEY (ID_Producto) REFERENCES Producto(ID_Producto)
) ENGINE=InnoDB;

CREATE TABLE Precio (
    ID_Precio INT AUTO_INCREMENT PRIMARY KEY,
    ID_Producto INT NOT NULL,
    Precio_Costo DECIMAL(10,2) NOT NULL CHECK (Precio_Costo > 0),
    Precio_Venta DECIMAL(10,2) NOT NULL CHECK (Precio_Venta > 0),
    Fecha_Inicio DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    Fecha_Fin DATETIME,
    FOREIGN KEY (ID_Producto) REFERENCES Producto(ID_Producto)
) ENGINE=InnoDB;

-- Poblar datos
INSERT INTO Categoría (Nombre, Descripción) VALUES 
('Electrónica', 'Dispositivos electrónicos'),
('Alimentos', 'Productos comestibles'),
('Ropa', 'Prendas de vestir'),
('Hogar', 'Electrodomésticos'),
('Juguetes', 'Productos infantiles');

INSERT INTO Producto (Nombre, Descripción, Precio, ID_Categoría) VALUES 
('Teléfono Inteligente', 'Smartphone 5G, 128GB, negro', 8999.99, 1),
('Café Molido', 'Café 100% arábica, 500g', 149.50, 2),
('Camisa Casual', 'Camisa de algodón, talla M, azul', 499.00, 3),
('Licuadora', 'Licuadora de 800W, acero', 1299.00, 4),
('Peluche Osito', 'Peluche 30cm, marrón', 299.50, 5);

INSERT INTO Inventario (ID_Producto, Stock_Actual, Entradas, Salidas, Punto_Reorden) VALUES 
(1, 50, 50, 0, 10),
(2, 100, 100, 0, 20),
(3, 30, 30, 0, 5),
(4, 20, 20, 0, 5),
(5, 40, 40, 0, 10);

INSERT INTO Cliente (Nombre, Correo, Teléfono) VALUES 
('Juan Pérez', 'juan.perez@email.com', '555-123-4567'),
('María López', 'maria.lopez@email.com', '555-234-5678'),
('Carlos Ramírez', 'carlos.ramirez@email.com', '555-345-6789'),
('Ana Gómez', 'ana.gomez@email.com', '555-456-7890'),
('Pedro Sánchez', 'pedro.sanchez@email.com', '555-567-8901');

INSERT INTO Venta (ID_Cliente, Fecha_Venta) VALUES 
(1, '2025-03-01 10:00:00'),
(2, '2025-03-02 14:30:00'),
(3, '2025-03-03 09:15:00'),
(4, '2025-03-04 16:45:00'),
(5, '2025-03-05 11:20:00');

INSERT INTO Detalle_Venta (ID_Venta, ID_Producto, Cantidad) VALUES 
(1, 1, 1),
(1, 2, 2),
(2, 3, 1),
(3, 4, 2),
(4, 5, 3),
(5, 1, 1);

INSERT INTO Precio (ID_Producto, Precio_Costo, Precio_Venta, Fecha_Inicio, Fecha_Fin) VALUES 
(1, 6500.00, 8999.99, '2025-01-01 00:00:00', NULL),
(2, 100.00, 149.50, '2025-01-01 00:00:00', NULL),
(3, 350.00, 499.00, '2025-01-01 00:00:00', NULL),
(4, 900.00, 1299.00, '2025-01-01 00:00:00', NULL),
(5, 200.00, 299.50, '2025-01-01 00:00:00', NULL);
