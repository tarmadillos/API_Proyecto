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

  {
    "token": "string"
}

{
    "error": "Credenciales inválidas"
}

---

### 4. Despliegue - Actualización

#### Instrucciones para Configurar y Ejecutar en Servidor Local (MySQL)

1. **Prerrequisitos:**
   - Instala XAMPP con MySQL y PHP 8.1 o superior.
   - Instala Composer para gestionar dependencias.
   - Instala Git para control de versiones.

2. **Configurar MySQL:**
   - Inicia MySQL desde XAMPP.
   - Crea la base de datos y ejecuta el script `sql/database.sql` usando phpMyAdmin o la línea de comandos:

   - Ingresa la contraseña si la tienes configurada (puede ser vacía por defecto en XAMPP).

3. **Clonar el Repositorio:**


4. **Instalar Dependencias:**


5. **Configurar Conexión a la Base de Datos:**
- Edita `api/config/db.php` y ajusta `$db_name`, `$username`, y `$password` según tu configuración MySQL (por ejemplo, `$db_name = "inventario_facturacion"; $username = "root"; $password = "";`).

6. **Configurar el Servidor Web:**
- Copia la carpeta `proyecto_api` a `htdocs` de XAMPP (por ejemplo, `C:\xampp\htdocs\proyecto_api`).
- Inicia Apache en XAMPP.
- Asegúrate de que `.htaccess` esté habilitado (verifica `httpd.conf` con `AllowOverride All`).

7. **Hacer la API Accesible en la Red Local:**
- Permite el puerto 80 en el firewall (como se indicó anteriormente).
- Obtén tu IP local y usa la URL: `http://192.168.1.100/proyecto_api/api`.

8. **Probar la API:**
- Usa Postman para probar los endpoints con las mismas solicitudes que antes, ajustando la URL a `http://192.168.1.100/proyecto_api/api`.

9. **Grabar un Video:**
- Graba con OBS Studio, mostrando la configuración de XAMPP con MySQL, ejecución de las solicitudes en Postman, y respuestas.

---

### 5. Repositorio Git
Los pasos para Git permanecen iguales, solo asegúrate de actualizar el `README.md` con las nuevas instrucciones de MySQL.

**Enlace del Repositorio (Ejemplo):** `https://github.com/tu_usuario/proyecto_api`

---

### Notas Finales
- **Compatibilidad:** Todos los cambios aseguran que el proyecto funcione con MySQL. Los tipos de datos y la sintaxis SQL han sido ajustados adecuadamente.
- **Completitud:** La estructura de archivos está completamente desarrollada con los ajustes de MySQL.
- **Ajustes Adicionales:** Si necesitas más endpoints, validaciones específicas para MySQL, o ayuda con la configuración de XAMPP, indícalos, y puedo profundizar. ¿Te gustaría que desarrolle algo más o que te guíe en la instalación? ¡Estoy aquí para ayudarte!