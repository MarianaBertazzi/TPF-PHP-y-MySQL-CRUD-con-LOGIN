<?php

// Punto de entrada principal de la aplicación.
// Este archivo redirige a la página de inicio de sesión por defecto.
header('Location: login.php');
exit(); // Es importante llamar a exit() después de una redirección.
        // Detiene la ejecución del script para asegurar que la redirección se complete.

?>