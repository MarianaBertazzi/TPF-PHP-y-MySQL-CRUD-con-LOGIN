<?php
//Create y Update del CRUD

// Iniciar sesión y verificar autenticación
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Incluir la conexión a la base de datos
require 'config/database.php';

// Verificar que la solicitud sea por método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id']; // Puede estar vacío si es una creación
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $user_id = $_SESSION['user_id'];

    // Validar datos básicos
    if (empty($nombre) || empty($precio)) {
        // Manejar el error, por ejemplo, redirigiendo con un mensaje
        header('Location: dashboard.php?error=faltan_datos');
        exit();
    }
    
    // Si hay un ID, es una actualización (Update)
    if (!empty($id)) {
        $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
    } 
    // Si no hay ID, es una creación (Create)
    else {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, usuario_id) VALUES (:nombre, :descripcion, :precio, :usuario_id)";
        $stmt = $conexion->prepare($sql);
    }

    // Vincular los parámetros comunes
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':usuario_id', $user_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir al dashboard con un mensaje de éxito
        header('Location: dashboard.php?status=success');
    } else {
        // Redirigir con un mensaje de error
        header('Location: dashboard.php?status=error');
    }
    exit();

} else {
    // Si alguien intenta acceder a este archivo directamente, redirigirlo
    header('Location: dashboard.php');
    exit();
}

?>