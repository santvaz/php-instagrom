<?php
# Conexión a la base de datos
$cadena_conexion = 'mysql:dbname=instagrom;host=127.0.0.1';
$usuario = 'root';
$clave = '';

try {
    $db = new PDO($cadena_conexion, $usuario, $clave);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    # Recuperar nombre de administrador a dar de baja
    $nick = $_POST['usuario_baja'];

    # Eliminar administrador de la tabla administradores
    $query_delete_admin = $db->prepare("DELETE FROM administradores WHERE usuario_id IN (SELECT id FROM usuarios WHERE nick = ?)");
    $query_delete_admin->execute([$nick]);

    # Eliminar usuario de la tabla usuarios
    $query_delete_user = $db->prepare("DELETE FROM usuarios WHERE nick = ?");
    $query_delete_user->execute([$nick]);

    echo "Administrador dado de baja exitosamente.";
} catch (PDOException $e) {
    echo "Error al dar de baja administrador: " . $e->getMessage();
}
