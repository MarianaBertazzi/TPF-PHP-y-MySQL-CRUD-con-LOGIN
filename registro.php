<?php
//Formulario y lógica para registrar nuevos usuarios

// Incluir el archivo de conexión a la base de datos
require 'config/database.php';

$mensaje = ''; // Variable para almacenar mensajes de error o éxito

// Verificar si el formulario ha sido enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];

    // Validar que los campos no estén vacíos
    if (!empty($nombre_usuario) && !empty($password)) {
        // Hashear la contraseña para mayor seguridad
        // NUNCA guardar contraseñas en texto plano.
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        // Preparar la consulta SQL para insertar el nuevo usuario
        // Usar sentencias preparadas para prevenir inyección SQL.
        $sql = "INSERT INTO usuarios (nombre_usuario, password) VALUES (:nombre_usuario, :password)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':password', $password_hashed);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            $mensaje = 'Usuario creado con éxito. Ahora puedes <a href="login.php">iniciar sesión</a>.';
        } else {
            $mensaje = 'Error al crear el usuario. Es posible que el nombre de usuario ya exista.';
        }
    } else {
        $mensaje = 'Por favor, completa todos los campos.';
    }
}

// Incluir el header de la página
include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Registrarse
            </div>
            <div class="card-body">
                <!-- Mostrar mensaje de error/éxito si existe -->
                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-info">
                        <?php echo $mensaje; ?>
                    </div>
                <?php endif; ?>

                <form action="registro.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre de Usuario:</label>
                        <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Incluir el footer de la página
include 'includes/footer.php';
?>