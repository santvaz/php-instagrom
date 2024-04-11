<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $mensaje_bienvenida = "¡Bienvenido, " . $_SESSION['usuario'] . "!";
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
    die();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagrom | Inicio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard_admin.css">
</head>
<header>
    <div id="header-container">
        <div id="iglogo">
            <a href="dashboard.php"><img id="iglogo" src="img/ig-logo.png" alt=""></a>
        </div>
        <div id="icons2">
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>
</header>

<body>
    <div class="form-admin" id="main-container">
        <form id="alta" action="guardar_publicacion.php" method="post" enctype="multipart/form-data">
            <h2>Añadir publicación en Instagrom</h2>
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required>
            <!-- <label for="ubicacion">Ubicación</label>
            <input type="text" id="ubicacion" name="ubicacion" placeholder="Calle Madrid 7, Madrid"> -->
            <label for="mensaje">Pie de foto</label>
            <input type="text" id="mensaje" name="mensaje" placeholder="Escribe tu mensaje">
            <input type="hidden" name="usuario_id" value="<?php echo $usuario_id; ?>">
            <input type="submit" value="Publicar">
        </form>
    </div>

</body>

</html>