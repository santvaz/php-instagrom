<?php

$cadena_conexion = 'mysql:dbname=instagrom;host=127.0.0.1';
$usuario = 'root';
$clave = '';

try {
    $db = new PDO($cadena_conexion, $usuario, $clave);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nombre = 'Administrador';
    $email = $_POST['admin_correo'];
    $nick = $_POST['admin_alta'];
    $password = $_POST['password_alta'];
    $tipo = 'Administrador';

    $query_insert = $db->prepare("INSERT INTO usuarios (nombre, email, nick, tipo, password) VALUES (?, ?, ?, ?, ?)");
    $query_insert->execute([$nombre, $email, $nick, $tipo, $password]);

    $usuario_id = $db->lastInsertId();
    $query_admin = $db->prepare("INSERT INTO administradores (usuario_id) VALUES (?)");
    $query_admin->execute([$usuario_id]);

    header("Location: dashboard_admin.php");
    exit();

} catch (PDOException $e) {
    echo "Error al dar de alta administrador: " . $e->getMessage();
}
?>