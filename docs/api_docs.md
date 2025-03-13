# Documentación de la API RESTful - Sistema de Gestión de Inventario y Facturación

## Descripción General
Esta API RESTful permite gestionar un sistema de inventario y facturación, usando MySQL como base de datos. Incluye funcionalidades para manejar productos, ventas, clientes, inventarios y precios, con autenticación basada en JWT.

## Autenticación
La API utiliza JWT (JSON Web Tokens) para autenticación. Para acceder a los endpoints protegidos, debes incluir un token en el encabezado `Authorization` como `Bearer <token>`.

### Endpoint de Autenticación
- **Método:** POST
- **URI:** `/auth/login`
- **Descripción:** Autentica a un usuario y devuelve un token JWT.
- **Request Body:**
  ```json
  {
      "email": "string (obligatorio)",
      "password": "string (obligatorio)"
  }