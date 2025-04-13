<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir dependencias de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Incluir configuración y helpers
require_once 'config/db.php';
require_once 'helpers/api_response.php';
require_once 'helpers/auth.php';

// Incluir modelos
require_once 'models/Categoria.php';
require_once 'models/Producto.php';
require_once 'models/Inventario.php';
require_once 'models/Cliente.php';
require_once 'models/Venta.php';
require_once 'models/DetalleVenta.php';
require_once 'models/Precio.php';

// Obtener el método HTTP y la URI
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));

// Autenticación (excepto para /auth/login)
if ($request[0] !== 'auth') {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        sendResponse(401, ['error' => 'Token de autenticación requerido']);
        exit();
    }
    $token = str_replace('Bearer ', '', $headers['Authorization']);
    if (!validateToken($token)) {
        sendResponse(401, ['error' => 'Token inválido']);
        exit();
    }
}

// Enrutamiento
switch ($request[0]) {
    case 'auth':
        if ($method === 'POST' && $request[1] === 'login') {
            $data = json_decode(file_get_contents("php://input"), true);
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';
            $token = authenticate($email, $password);
            if ($token) {
                sendResponse(200, ['token' => $token]);
            } else {
                sendResponse(401, ['error' => 'Credenciales inválidas']);
            }
        }
        break;

    case 'categorias':
        $categoria = new Categoria();
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $categoria->create($data);
            if ($result) {
                sendResponse(201, ['mensaje' => 'Categoría creada', 'id' => $result]);
            } else {
                sendResponse(400, ['error' => 'Error al crear categoría']);
            }
        } elseif ($method === 'GET') {
            if (isset($request[1])) {
                $result = $categoria->read($request[1]);
                if ($result) {
                    sendResponse(200, $result);
                } else {
                    sendResponse(404, ['error' => 'Categoría no encontrada']);
                }
            } else {
                $result = $categoria->readAll();
                sendResponse(200, $result);
            }
        } elseif ($method === 'PUT' && isset($request[1])) {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $categoria->update($request[1], $data);
            if ($result) {
                sendResponse(200, ['mensaje' => 'Categoría actualizada']);
            } else {
                sendResponse(400, ['error' => 'Error al actualizar categoría']);
            }
        } elseif ($method === 'DELETE' && isset($request[1])) {
            $result = $categoria->delete($request[1]);
            if ($result) {
                sendResponse(204, []);
            } else {
                sendResponse(404, ['error' => 'Categoría no encontrada']);
            }
        }
        break;

    case 'productos':
        $producto = new Producto();
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $producto->create($data);
            if ($result) {
                sendResponse(201, ['mensaje' => 'Producto creado', 'id' => $result]);
            } else {
                sendResponse(400, ['error' => 'Error al crear producto']);
            }
        } elseif ($method === 'GET') {
            if (isset($request[1])) {
                $result = $producto->read($request[1]);
                if ($result) {
                    sendResponse(200, $result);
                } else {
                    sendResponse(404, ['error' => 'Producto no encontrado']);
                }
            } else {
                $result = $producto->readAll();
                sendResponse(200, $result);
            }
        } elseif ($method === 'PUT' && isset($request[1])) {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $producto->update($request[1], $data);
            if ($result) {
                sendResponse(200, ['mensaje' => 'Producto actualizado']);
            } else {
                sendResponse(400, ['error' => 'Error al actualizar producto']);
            }
        } elseif ($method === 'DELETE' && isset($request[1])) {
            $result = $producto->delete($request[1]);
            if ($result) {
                sendResponse(204, []);
            } else {
                sendResponse(404, ['error' => 'Producto no encontrado']);
            }
        }
        break;

    case 'ventas':
        $venta = new Venta();
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $venta->create($data);
            if ($result) {
                sendResponse(201, ['mensaje' => 'Venta registrada', 'id' => $result]);
            } else {
                sendResponse(400, ['error' => 'Error al registrar venta']);
            }
        } elseif ($method === 'GET') {
            if (isset($request[1])) {
                $result = $venta->read($request[1]);
                if ($result) {
                    sendResponse(200, $result);
                } else {
                    sendResponse(404, ['error' => 'Venta no encontrada']);
                }
            } else {
                $result = $venta->readAll();
                sendResponse(200, $result);
            }
        }
        break;

    case 'clientes':
        $cliente = new Cliente();
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $cliente->create($data);
            if ($result) {
                sendResponse(201, ['mensaje' => 'Cliente creado', 'id' => $result]);
            } else {
                sendResponse(400, ['error' => 'Error al crear cliente']);
            }
        } elseif ($method === 'GET') {
            if (isset($request[1])) {
                $result = $cliente->read($request[1]);
                if ($result) {
                    sendResponse(200, $result);
                } else {
                    sendResponse(404, ['error' => 'Cliente no encontrado']);
                }
            } else {
                $result = $cliente->readAll();
                sendResponse(200, $result);
            }
        }
        break;

    case 'inventarios':
        $inventario = new Inventario();
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $inventario->create($data);
            if ($result) {
                sendResponse(201, ['mensaje' => 'Inventario creado', 'id' => $result]);
            } else {
                sendResponse(400, ['error' => 'Error al crear inventario']);
            }
        } elseif ($method === 'GET') {
            if (isset($request[1])) {
                $result = $inventario->read($request[1]);
                if ($result) {
                    sendResponse(200, $result);
                } else {
                    sendResponse(404, ['error' => 'Inventario no encontrado']);
                }
            } else {
                $result = $inventario->readAll();
                sendResponse(200, $result);
            }
        }
        break;

    case 'precios':
        $precio = new Precio();
        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $precio->create($data);
            if ($result) {
                sendResponse(201, ['mensaje' => 'Precio creado', 'id' => $result]);
            } else {
                sendResponse(400, ['error' => 'Error al crear precio']);
            }
        } elseif ($method === 'GET') {
            if (isset($request[1])) {
                $result = $precio->read($request[1]);
                if ($result) {
                    sendResponse(200, $result);
                } else {
                    sendResponse(404, ['error' => 'Precio no encontrado']);
                }
            } else {
                $result = $precio->readAll();
                sendResponse(200, $result);
            }
        }
        break;

    default:
        sendResponse(404, ['error' => 'Ruta no encontrada']);
        break;
}
?>