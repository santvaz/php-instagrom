<?php

$cadena_conexion = 'mysql:dbname=instagrom;host=127.0.0.1';
$usuario = 'root';
$clave = '';

try {
    $db = new PDO($cadena_conexion, $usuario, $clave);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nick_instagromer = $_POST['instagromer_baja'];

    $sql = $db->prepare("DELETE FROM usuarios WHERE nick = :nick");
    $sql->bindParam('nick', $nick_instagromer);
    $sql->execute();

    echo "Instagromer dado de baja exitosamente.";
    header("Location: controlpanel.php");
    exit();
} catch (PDOException $e) {
    echo "Error al dar de baja Instagromer: " . $e->getMessage();
}
