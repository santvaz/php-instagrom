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

    $query_insert = $db->prepare("INSERT INTO usuarios (nombre, email, nick, tipo, password) VALUES (:nombre, :email, :nick, :tipo, :password)");
    $query_admin->bindParam(':nombre', $nombre);
    $query_admin->bindParam(':email', $email);
    $query_admin->bindParam(':nick', $nick);
    $query_admin->bindParam(':tipo', $tipo);
    $query_admin->bindParam(':password', $password);
    $query_insert->execute();

    $usuario_id = $db->lastInsertId();
    $query_admin = $db->prepare("INSERT INTO administradores (usuario_id) VALUES (:id)");
    $query_admin->bindParam(':id', $usuario_id);
    $query_admin->execute();

    header("Location: dashboard_admin.php");
    exit();
} catch (PDOException $e) {
    echo "Error al dar de alta administrador: " . $e->getMessage();
}
