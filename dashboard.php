<?php
//Read del CRUD
//Página principal que muestra los productos del usuario logueado

// Iniciar sesión y verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Incluir archivos necesarios
require 'config/database.php';
include 'includes/header.php';

// Obtener el ID del usuario de la sesión
$user_id = $_SESSION['user_id'];

// Lógica para obtener el producto a editar (si se pasa un 'id' por GET)
$producto_a_editar = null;
if (isset($_GET['editar'])) {
    $id_producto_editar = $_GET['editar'];
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = :id AND usuario_id = :usuario_id");
    $stmt->execute([':id' => $id_producto_editar, ':usuario_id' => $user_id]);
    $producto_a_editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Lógica para obtener todos los productos del usuario
$stmt = $conexion->prepare("SELECT * FROM productos WHERE usuario_id = :usuario_id ORDER BY id DESC");
$stmt->bindParam(':usuario_id', $user_id);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Formulario para Crear y Editar productos -->
<div class="card mb-4">
    <div class="card-header">
        <!-- Cambiar el título del formulario si estamos editando o creando -->
        <h4><?php echo $producto_a_editar ? 'Editar Producto' : 'Agregar Nuevo Producto'; ?></h4>
    </div>
    <div class="card-body">
        <form action="guardar_producto.php" method="POST">
            <!-- Campo oculto para el ID del producto (importante para la edición) -->
            <input type="hidden" name="id" value="<?php echo $producto_a_editar ? $producto_a_editar['id'] : ''; ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto:</label>
                <input type="text" name="nombre" class="form-control" required value="<?php echo $producto_a_editar ? htmlspecialchars($producto_a_editar['nombre']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea name="descripcion" class="form-control"><?php echo $producto_a_editar ? htmlspecialchars($producto_a_editar['descripcion']) : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" step="0.01" name="precio" class="form-control" required value="<?php echo $producto_a_editar ? $producto_a_editar['precio'] : ''; ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">
                <?php echo $producto_a_editar ? 'Actualizar Producto' : 'Guardar Producto'; ?>
            </button>
            <?php if ($producto_a_editar): ?>
                <a href="dashboard.php" class="btn btn-secondary">Cancelar Edición</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Tabla para mostrar los productos existentes (Read) -->
<div class="card">
    <div class="card-header">
        <h4>Mis Productos</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($productos)): ?>
                        <tr>
                            <td colspan="5" class="text-center">No tienes productos registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?php echo $producto['id']; ?></td>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                                <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                                <td>
                                    <!-- Enlace para Editar: redirige a la misma página con el ID del producto -->
                                    <a href="dashboard.php?editar=<?php echo $producto['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                    
                                    <!-- Enlace para Eliminar: apunta al script de eliminación -->
                                    <a href="eliminar_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Incluir el footer
include 'includes/footer.php';
?>