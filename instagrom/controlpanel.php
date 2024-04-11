<?php require_once 'auth/auth.php' ?>
<?php
$cadena_conexion = 'mysql:dbname=instagrom;host=127.0.0.1';
$usuario = 'root';
$clave = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $usuario_id = $_POST['usuario_id'];

    try {
        $db = new PDO($cadena_conexion, $usuario, $clave);

        if ($accion == 'alta') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $tipo = $_POST['tipo'];

            $preparada = $db->prepare("INSERT INTO usuarios (nombre, email, password, tipo) VALUES (?, ?, ?, ?)");
            $preparada->execute([$nombre, $email, $password, $tipo]);
        } elseif ($accion == 'baja') {

            $preparada = $db->prepare("DELETE FROM usuarios WHERE id = ?");
            $preparada->execute([$usuario_id]);
        }

        header('Location: alta_baja_usuario.php');
        exit();
    } catch (PDOException $e) {
        echo "Error con la bd: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagrom | Panel de control</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard_admin.css">
</head>

<body>
    <header>
        <div id="header-container">
            <div id="iglogo">
                <a href="dashboard_admin.php"><img id="iglogo" src="img/ig-logo.png" alt=""></a>
            </div>
            <div id="icons1">
                <em>Panel de control de:
                    <?php echo $admin; ?>
                </em>
                <strong>Administrar:</strong>
                <a href="dashboard_admin.php">Salir del panel de control</a>
            </div>
            <div id="icons2"><a href="logout.php">Cerrar sesión</a></div>
        </div>
    </header>

    <div class="form-admin" id="main-container">
        <h1>Panel de Control - Gestión de usuarios Administradores e Instagromers</h1>
        <form id="alta" action="alta_admin.php" method="post">
            <h2>Dar de alta a un administrador</h2>
            <label for="admin_correo">Nuevo correo administrador:</label>
            <input type="text" id="admin_correo" name="admin_correo">
            <label for="admin_alta">Nuevo usuario administrador:</label>
            <input type="text" id="admin_alta" name="admin_alta">
            <label for="password_alta">Contraseña:</label>
            <input type="password" id="password_alta" name="password_alta">
            <input type="submit" value="Dar de alta">
        </form>

        <form id="baja" action="baja_admin.php" method="post">
            <h2>Dar de baja a un administrador</h2>
            <label for="usuario_baja">Nick de administrador a dar de baja:</label>
            <input type="text" id="usuario_baja" name="usuario_baja">
            <input type="submit" value="Dar de baja">
        </form>

        <form id="alta" action="alta_usuario.php" method="post">
            <h2>Dar de alta a un Instagromer</h2>
            <label for="instagromer_nombre">Nuevo nombre Instagromer:</label>
            <input type="text" id="instagromer_nombre" name="instagromer_nombre">
            <label for="instagromer_correo">Nuevo correo Instagromer:</label>
            <input type="text" id="instagromer_correo" name="instagromer_correo">
            <label for="instagromer_alta">Nuevo usuario Instagromer:</label>
            <input type="text" id="instagromer_alta" name="instagromer_alta">
            <label for="password_instagromer">Contraseña:</label>
            <input type="password" id="password_instagromer" name="password_instagromer">
            <input type="submit" value="Dar de alta">
        </form>

        <form id="baja" action="baja_usuario.php" method="post">
            <h2>Dar de baja a un Instagromer</h2>
            <label for="instagromer_baja">Nick de Instagromer a dar de baja:</label>
            <input type="text" id="instagromer_baja" name="instagromer_baja">
            <input type="submit" value="Dar de baja">
        </form>
    </div>

</body>

</html>