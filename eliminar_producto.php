<?php
// Delete del CRUD

// Iniciar sesión y verificar autenticación
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Incluir la conexión a la base de datos
require 'config/database.php';

// Verificar que se haya pasado un ID por GET
if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Preparar la consulta para eliminar el producto
    // IMPORTANTE: Asegurarse de que el producto pertenezca al usuario que intenta eliminarlo.
    // Esto previene que un usuario borre productos de otro cambiando el ID en la URL.
    $sql = "DELETE FROM productos WHERE id = :id AND usuario_id = :usuario_id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id', $id_producto);
    $stmt->bindParam(':usuario_id', $user_id);

    // Ejecutar y redirigir
    if ($stmt->execute()) {
        header('Location: dashboard.php?status=deleted');
    } else {
        header('Location: dashboard.php?status=error_delete');
    }
    exit();

} else {
    // Si no se proporciona un ID, redirigir al dashboard
    header('Location: dashboard.php');
    exit();
}

?>