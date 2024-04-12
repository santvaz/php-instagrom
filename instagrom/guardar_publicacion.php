<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$nick_usuario = $_SESSION['usuario'];

$cadena_conexion = 'mysql:dbname=instagrom;host=127.0.0.1';
$usuario = 'root';
$clave = '';

try {
    $db = new PDO($cadena_conexion, $usuario, $clave);
} catch (PDOException $e) {
    echo "Error con la bd: " . $e->getMessage();
    exit();
}

try {
    $consulta_usuario = $db->prepare("SELECT id FROM usuarios WHERE nick = :nick");

    $consulta_usuario->bindParam(':nick', $nick_usuario);

    $consulta_usuario->execute();
    $resultado = $consulta_usuario->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        echo "No se encontró el usuario en la base de datos.";
        exit();
    }

    $usuario_id = $resultado['id'];
    $mensaje = $_POST['mensaje'];
    $fecha_publicacion = date('Y-m-d H:i:s');

    # Directorio donde se guardará la imagen
    $directorio_destino = './uploads/';

    $nombre_archivo = $_FILES['imagen']['name'];
    $ruta_archivo = $directorio_destino . $nombre_archivo;

    # Mover la imagen del directorio temporal al directorio de destino
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_archivo)) {
        $sql = $db->prepare("INSERT INTO publicaciones (mensaje, usuario_id, imagen, fecha_publicacion) VALUES (:mensaje, :usuario_id, :imagen, :fecha_publicacion)");

        $sql->bindParam(':mensaje', $mensaje);
        $sql->bindParam(':usuario_id', $usuario_id);
        $sql->bindParam(':imagen', $ruta_archivo);
        $sql->bindParam(':fecha_publicacion', $fecha_publicacion);

        $sql->execute();

        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error al subir la imagen.";
    }
} catch (PDOException $e) {
    echo "Error al crear la publicación: " . $e->getMessage();
}
