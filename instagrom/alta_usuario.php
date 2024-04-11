<?php

$cadena_conexion = 'mysql:dbname=instagrom;host=127.0.0.1';
$usuario = 'root';
$clave = '';

try {
    $db = new PDO($cadena_conexion, $usuario, $clave);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nombre = $_POST['instagromer_nombre'];
    $email = $_POST['instagromer_correo'];
    $nick = $_POST['instagromer_alta'];
    $password = $_POST['password_instagromer'];
    $tipo = 'Instagromer';

    $query_insert = $db->prepare("INSERT INTO usuarios (nombre, email, nick, tipo, password) VALUES (?, ?, ?, ?, ?)");
    $query_insert->execute([$nombre, $email, $nick, $tipo, $password]);

    echo "  Instagromer agregado exitosamente.";
    header("Location: controlpanel.php");
    exit();

} catch (PDOException $e) {
    echo "Error al dar de alta Instagromer: " . $e->getMessage();
}
?>