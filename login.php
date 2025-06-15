<?php
//Formulario y lógica para el inicio de sesión.

// Iniciar sesión para poder usar las variables de sesión
session_start();

// Si el usuario ya ha iniciado sesión, redirigirlo al dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit(); // Es importante terminar el script después de una redirección
}

// Incluir el archivo de conexión a la base de datos
require 'config/database.php';

$mensaje = ''; // Variable para mensajes

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];

    // Buscar al usuario en la base de datos
    $sql = "SELECT id, nombre_usuario, password FROM usuarios WHERE nombre_usuario = :nombre_usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':nombre_usuario', $nombre_usuario);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y si la contraseña es correcta
    // password_verify() compara la contraseña ingresada con el hash almacenado
    if ($usuario && password_verify($password, $usuario['password'])) {
        // La contraseña es correcta, iniciar sesión
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['username'] = $usuario['nombre_usuario'];

        // Redirigir al dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Credenciales incorrectas
        $mensaje = 'Nombre de usuario o contraseña incorrectos.';
    }
}

// Incluir el header
include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Iniciar Sesión
            </div>
            <div class="card-body">
                <!-- Mostrar mensaje de error si existe -->
                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-danger">
                        <?php echo $mensaje; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre de Usuario:</label>
                        <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Entrar</button>
                </form>
            </div>
             <div class="card-footer text-muted">
                ¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>
            </div>
        </div>
    </div>
</div>

<?php
// Incluir el footer
include 'includes/footer.php';
?>