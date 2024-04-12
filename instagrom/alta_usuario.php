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

    $query_insert = $db->prepare("INSERT INTO usuarios (nombre, email, nick, tipo, password) VALUES (:nombre, :email, :nick, :tipo, :password)");
    $query_insert->bindParam(':nombre', $nombre);
    $query_insert->bindParam(':email', $email);
    $query_insert->bindParam(':nick', $nick);
    $query_insert->bindParam(':tipo', $tipo);
    $query_insert->bindParam(':password', $password);
    $query_insert->execute();

    echo "  Instagromer agregado exitosamente.";
    header("Location: controlpanel.php");
    exit();
} catch (PDOException $e) {
    echo "Error al dar de alta Instagromer: " . $e->getMessage();
}
