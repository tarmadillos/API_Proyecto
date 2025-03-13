<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function authenticate($email, $password) {
    // Simulación de autenticación (en un proyecto real, validar contra una tabla de usuarios)
    if ($email === 'admin@example.com' && $password === 'password123') {
        $key = "your_secret_key";
        $payload = [
            'iss' => 'http://localhost',
            'iat' => time(),
            'exp' => time() + 3600, // Token válido por 1 hora
            'sub' => $email
        ];
        return JWT::encode($payload, $key, 'HS256');
    }
    return false;
}

function validateToken($token) {
    try {
        $key = "your_secret_key";
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>