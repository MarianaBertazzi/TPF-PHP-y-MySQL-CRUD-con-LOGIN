<?php
//Formulario y lógica para registrar nuevos usuarios

// Incluir el archivo de conexión a la base de datos
require 'config/database.php';

$mensaje = ''; // Variable para almacenar mensajes de error o éxito
$avatar_nombre = 'default.png'; // Valor por defecto

// Verificar si el formulario ha sido enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];

    // Lógica para manejar la subida del avatar
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatar = $_FILES['avatar'];
        $target_dir = "public/uploads/avatars/";
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($avatar['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            // Generar un nombre de archivo único para evitar colisiones
            $extension = pathinfo($avatar['name'], PATHINFO_EXTENSION);
            $avatar_nombre = uniqid() . '.' . $extension;
            $target_file = $target_dir . $avatar_nombre;

            // Mover el archivo subido al directorio de destino
            move_uploaded_file($avatar['tmp_name'], $target_file);
        } else {
            $mensaje = 'Tipo de archivo no permitido. Solo se aceptan JPG, PNG y GIF.';
        }
    }

    // Validar que los campos no estén vacíos
    if (!empty($nombre_usuario) && !empty($password)) {
        // Hashear la contraseña para mayor seguridad
        // NUNCA guardar contraseñas en texto plano.
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        // Preparar la consulta SQL para insertar el nuevo usuario
        // Usar sentencias preparadas para prevenir inyección SQL.
        // Insertar el nuevo usuario con el nombre del avatar
        $sql = "INSERT INTO usuarios (nombre_usuario, password, avatar) VALUES (:nombre_usuario, :password, :avatar)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':password', $password_hashed);
        $stmt->bindParam(':avatar', $avatar_nombre);

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

                <form action="registro.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre de Usuario:</label>
                        <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <!-- NUEVO CAMPO PARA EL AVATAR -->
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Imagen de Perfil (Opcional):</label>
                        <input type="file" name="avatar" id="avatar" class="form-control" accept="image/jpeg, image/png, image/gif">
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