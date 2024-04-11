<?php
# Inicializar la variable de sesión o adherirse a ella
session_start();

# Destruir todas las variables de sesión
$_SESSION = array();

# Borrar la cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), time() - 3600);
}

# Libera todas las variables relacionadas con la sesión
session_unset();

# Destruir la sesión
session_destroy();

# Redirigir a la página de inicio
header('location:login.php');
exit();
?>