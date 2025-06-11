# TPF-PHP-y-MySQL-CRUD-con-LOGIN
Trabajo Práctico Final del curso PHP con MySQL: CRUD con LogIn

# CRUD Básico con Sistema de Login en PHP y MySQL

Este es un proyecto educativo que demuestra cómo construir una aplicación web completa con funcionalidades de Crear, Leer, Actualizar y Eliminar (CRUD) protegida por un sistema de autenticación de usuarios (Registro y Login).

El proyecto sigue buenas prácticas de desarrollo como el uso de **PDO** para interacciones seguras con la base de datos, **contraseñas hasheadas** y una estructura de proyecto organizada.

**[Ver Demo Online](https://ENLACE_AL_DEPLOY.com)**  

## ✨ Características

-   **Sistema de Autenticación:**
    -   Registro de nuevos usuarios.
    -   Inicio de sesión seguro.
    -   Las contraseñas se almacenan de forma segura usando `password_hash()`.
    -   Cierre de sesión.
-   **Gestión de Productos (CRUD):**
    -   Los usuarios autenticados pueden crear, ver, editar y eliminar sus propios productos.
    -   Un usuario no puede ver o modificar los productos de otro usuario.
-   **Interfaz de Usuario:**
    -   Diseño limpio y responsivo utilizando **Bootstrap 5**.
    -   Navegación dinámica que cambia según el estado de autenticación del usuario.

## 🛠️ Tecnologías Utilizadas

-   **Backend:** PHP 8+
-   **Base de Datos:** MySQL
-   **Frontend:** HTML5, CSS3, Bootstrap 5
-   **Servidor:** Apache (a través de XAMPP para desarrollo local).

## 🚀 Instalación y Puesta en Marcha

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
2.  Crea una nueva base de datos llamada `app_crud_login`.
3.  Selecciona la base de datos recién creada y ve a la pestaña `SQL`.
4.  Copia y pega el siguiente código para crear las tablas `usuarios` y `productos`:

```sql
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

1.  En la carpeta `config/`, renombra el archivo `database.example.php` a `database.php` (o crea uno nuevo si no existe).
2.  Abre `config/database.php` y ajusta los valores de conexión a tu configuración local. Por lo general, en XAMPP, la configuración por defecto es:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'app_crud_login');
define('DB_USER', 'root');
define('DB_PASS', '');
// ... resto del archivo
?>
```

### 4. Ejecutar el Proyecto

-   Mueve la carpeta del proyecto (`TPF-PHP-y-MySQL-CRUD-con-LOGIN`) dentro del directorio `htdocs` de tu instalación de XAMPP.
-   Abre tu navegador y ve a `http://localhost/TPF-PHP-y-MySQL-CRUD-con-LOGIN/registro.php` para empezar.

## 🔗 Enlaces Finales

-   **Repositorio en GitHub:** [https://github.com/MarianaBertazzi/TPF-PHP-y-MySQL-CRUD-con-LOGIN](https://github.com/MarianaBertazzi/TPF-PHP-y-MySQL-CRUD-con-LOGIN)
-   **Demo en vivo:** [https://ENLACE_AL_DEPLOY.com](https://ENLACE_AL_DEPLOY.com)
