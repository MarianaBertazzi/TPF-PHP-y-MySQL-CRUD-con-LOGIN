# TPF-PHP-y-MySQL-CRUD-con-LOGIN
Trabajo Práctico Final del curso PHP con MySQL: CRUD con LogIn

# CRUD Básico con Sistema de Login en PHP y MySQL

Este es un proyecto educativo que demuestra cómo construir una aplicación web completa con funcionalidades de Crear, Leer, Actualizar y Eliminar (CRUD) protegida por un sistema de autenticación de usuarios (Registro y Login).

El proyecto sigue buenas prácticas de desarrollo como el uso de **PDO** para interacciones seguras con la base de datos, **contraseñas hasheadas con BCRYPT**, una estructura de proyecto organizada y el uso de sentencias preparadas para prevenir inyección SQL.

**[Ver Demo Online](https://app-crud-login-php.infinityfreeapp.com/)**  

## ✨ Características

-   **Sistema de Autenticación:**
    -   Registro de nuevos usuarios.
    -   Inicio de sesión con validación y hasheo de contraseñas.
    -   Las contraseñas se almacenan de forma segura usando `password_hash()`.
    -   Cierre de sesión y destrucción de la sesión.
-   **Gestión de Productos (CRUD):**
    -   Los usuarios autenticados pueden crear, ver, editar y eliminar **sus propios productos**.
    -   Un usuario no puede ver o modificar los productos de otro usuario, garantizando la privacidad de los datos.
-   **Interfaz de Usuario Limpia:**
    -   Diseño limpio y responsivo utilizando **Bootstrap 5** para una experiencia de usuario agradable en cualquier dispositivo.
    -   Navegación dinámica que cambia según el estado de autenticación del usuario.
-   **Seguridad:**
    -   Prevención de inyección SQL mediante el uso de **consultas preparadas con PDO**.
    -   Uso de `htmlspecialchars()` para prevenir ataques XSS al mostrar datos.
    -   Protección de rutas para que solo usuarios autenticados puedan acceder al dashboard.

## 🛠️ Tecnologías Utilizadas

-   **Backend:** PHP 8+
-   **Base de Datos:** MySQL
-   **Frontend:** HTML5, CSS3, Bootstrap 5
-   **Servidor de Desarrollo:** XAMPP (Apache)
-    **Despliegue:** InfinityFree

## 🚀 Instalación y Puesta en Marcha Local

Sigue estos pasos para configurar el proyecto en tu entorno de desarrollo local.

### Prerrequisitos

-   Tener instalado un entorno de desarrollo como [XAMPP](https://www.apachefriends.org/index.html), WAMP o MAMP.
-   Git (opcional, para clonar el repositorio).

### 1. Clonar el Repositorio

```bash
git clone https://github.com/MarianaBertazzi/TPF-PHP-y-MySQL-CRUD-con-LOGIN.git
cd TPF-PHP-y-MySQL-CRUD-con-LOGIN
```

### 2. Configurar la Base de Datos

1.  Abre `phpMyAdmin` en tu entorno local.
2.  Crea una nueva base de datos llamada `app_crud_login` con cotejamiento `utf8mb4_general_ci`.
3.  Selecciona la base de datos recién creada y ve a la pestaña `SQL`.
4.  Importa el archivo `.sql` que se encuentra en la raíz del repositorio o ejecuta el siguiente script desde la pestaña `SQL`:

```sql
-- Contenido del archivo database.sql que deberías crear y subir
CREATE TABLE `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `productos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT,
  `precio` DECIMAL(10, 2) NOT NULL,
  `usuario_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 3. Configurar la Conexión

1.  Dentro de la carpeta `config/`, crea un archivo llamado `database.php`.
2.  Copia y pega el siguiente contenido en él, ajustándolo a tu configuración local de XAMPP si es diferente.

```php
<?php
// config/database.php

define('DB_HOST', 'localhost');
define('DB_NAME', 'app_crud_login');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $conexion = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?>
```
**Nota:** Este archivo `database.php` está intencionadamente ignorado por Git (`.gitignore`) para no exponer credenciales sensibles en el repositorio.

### 4. Ejecutar el Proyecto

-   Mueve la carpeta del proyecto (`TPF-PHP-y-MySQL-CRUD-con-LOGIN`) dentro del directorio `htdocs` de tu instalación de XAMPP.
-   Abre tu navegador y ve a `http://localhost/TPF-PHP-y-MySQL-CRUD-con-LOGIN/` para empezar.

## 📝 Notas sobre el Despliegue en Hosting Gratuito

La demo online está alojada en **InfinityFree**. Debido a las limitaciones de los servicios de hosting gratuitos, pueden ocurrir los siguientes comportamientos:

*   **Advertencia de "Sitio no seguro":** La plataforma de hosting inyecta un script de verificación de seguridad (`?i=1`) que puede generar una advertencia de "Contenido Mixto" en los navegadores, a pesar de que el sitio está configurado para forzar HTTPS. Todos los recursos propios de la aplicación se cargan de forma segura.
*   **Velocidad:** El rendimiento puede ser más lento en comparación con un hosting de pago.

Estos puntos son limitaciones del entorno de hosting y no errores en el código de la aplicación.

## 🔗 Enlaces Finales

-   **Repositorio en GitHub:** [https://github.com/MarianaBertazzi/TPF-PHP-y-MySQL-CRUD-con-LOGIN](https://github.com/MarianaBertazzi/TPF-PHP-y-MySQL-CRUD-con-LOGIN)
-   **Demo en vivo:** [https://app-crud-login-php.infinityfreeapp.com/](https://app-crud-login-php.infinityfreeapp.com/)

  
