<?php
// La mayoría de nuestras páginas necesitarán saber si el usuario inició sesión.
// session_start() activa el sistema de sesiones de PHP.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App CRUD con Login</title>
    <!-- Enlace al Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <!-- Estilos de Bootstrap 5 desde internet (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados css -->
    <link href="public/css/styles.css" rel="stylesheet">
</head>

<body>
<!-- Barra de navegación superior -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Mi App CRUD</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Si la variable de sesión 'user_id' EXISTE, significa que el usuario inició sesión. -->
            <li class="nav-item">
              <!-- htmlspecialchars() es una función de seguridad para evitar que código malicioso se muestre en la página. -->
              <a class="nav-link">Hola, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </li>
        <?php else: ?>
            <!-- Si 'user_id' NO EXISTE, mostramos los enlaces para iniciar sesión o registrarse. -->
            <li class="nav-item">
              <a class="nav-link" href="login.php">Iniciar Sesión</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="registro.php">Registrarse</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Abrimos un contenedor principal para todo el contenido de la página. -->
<div class="container mt-4">