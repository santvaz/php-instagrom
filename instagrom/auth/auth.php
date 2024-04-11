<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $admin = $_SESSION['usuario'];
} else {
    header('Location: login.php');
    exit();
}

$cadena_conexion = 'mysql:dbname=instagrom;host=127.0.0.1';
$usuario_db = 'root';
$clave_db = '';

try {
    $db = new PDO($cadena_conexion, $usuario_db, $clave_db);
} catch (PDOException $e) {
    echo "Error con la base de datos: " . $e->getMessage();
}
?>