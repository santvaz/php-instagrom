<?php
session_start();

$cadena_conexion = 'mysql:dbname=instagrom;host=127.0.0.1';
$usuario = 'root';
$clave = '';

try {
    $db = new PDO($cadena_conexion, $usuario, $clave);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $password = $_POST['clave'];

        # Verificar si ya existe el email
        $preparada = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $preparada->execute([$email]);
        if ($preparada->rowCount() > 0) {
            $error_registro = "El correo electrónico ya está en uso.";
        }

        # Verificar si existe el usuario
        $preparada = $db->prepare("SELECT * FROM usuarios WHERE nick = ?");
        $preparada->execute([$usuario]);
        if ($preparada->rowCount() > 0) {
            $error_registro = "El nombre de usuario ya está en uso.";
        }

        # Si no hay errores, insertar en la base de datos. Por defecto todos serán instagromers, creo que lo adecuado es insertar a los administradores de forma manual y no automatizada
        if (!isset($error_registro)) {
            $preparada = $db->prepare("INSERT INTO usuarios (nombre, email, nick, password, tipo) VALUES (?, ?, ?, ?, 'Instagromer')");
            $preparada->execute([$nombre, $email, $usuario, $password]);

            $_SESSION['usuario'] = $usuario;
            # Redirigir a dashboard.php después de registrarse
            header('location: dashboard.php');
            exit();
        }
    }
} catch (PDOException $e) {
    echo "Error en la base de datos, error de tipo: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagrom | Inicio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>

<body>
    <div class="contenedor-contenido">
        <div class="contenedor-alineacion">
            <div class="imagen-telefono">
                <img src="https://i.ibb.co/0yFRT6k/IG-Profile-Overview.jpg" alt="Vista previa perfil"
                    class="img-en-telefono">
            </div>
            <div class="lado-derecho">
                <div class="contenedor-inicio-sesion">
                    <a href="index.php"><img id="logo" src="img/ig-logo.png" alt=""></a>
                    <form form id="loginForm" action="registro.php" method="post">
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre">
                        <input type="text" id="email" name="email" placeholder="Correo electrónico">
                        <input type="text" id="usuario" name="usuario" placeholder="Usuario">
                        <input type="password" id="clave" name="clave" placeholder="Contraseña">
                        <div class="iniciar-sesion">
                            <input type="submit" value="Entrar">
                        </div>
                    </form>
                    <hr>
                    <p><span>O</span></p>
                    <div class="error-login">
                        <?php if (isset($error_registro)) {
                            echo $error_registro;
                        } ?>
                    </div>
                    <div class="login-fb">
                        <img id="fb" src="img/facebook.png" alt=""><a href="#">Iniciar sesión con Facebook</a>
                    </div>
                    <a id="forgot" href="#">¿Has olvidado tu contraseña?</a>
                </div>
                <div class="contenedor-registro">
                    <p>¿Ya tienes cuenta?<a href="login.php"> Inicia sesión</a></p>
                </div>
                <div class="contenedor-botones">
                    <p>Descarga la aplicación.</p>
                    <div class="botones-flex">
                        <img src="https://assets.codepen.io/6060109/IG-app-store-button.png" alt="">
                        <img id="googleLogo" src="https://assets.codepen.io/6060109/IG-Google-Play-Button.png"
                            alt="Google Logo">
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <a>Sobre Nosotros</a>
            <a>Blog</a>
            <a>Empleo</a>
            <a>Ayuda</a>
            <a>API</a>
            <a>Privacidad</a>
            <a>Términos</a>
            <a>Mejores Cuentas</a>
            <a>Etiquetas</a>
            <a>Ubicaciones</a>
            <a>Instagram Lite</a>
            <a>Belleza</a>
            <a>Baile</a>
            <a>Ejercicio y Salud</a>
            <a>Comida y Bebida</a>
            <a>Hogar y Jardín</a>
            <a>Música</a>
            <a>Artes Visuales</a>
        </footer>
    </div>
    <script src="js/script.js"></script>
</body>

</html>