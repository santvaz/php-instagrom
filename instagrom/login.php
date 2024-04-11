<?php
session_start();

$cadena_conexion = 'mysql:dbname=instagrom;host=127.0.0.1';
$usuario = 'root';
$clave = '';

try {
    $db = new PDO($cadena_conexion, $usuario, $clave);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario = $_POST['usuario'];
        $password = $_POST['clave'];

        $preparada = $db->prepare("SELECT * FROM usuarios WHERE nick = ? AND password = ?");
        $preparada->execute([$usuario, $password]);

        if ($fila = $preparada->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['usuario'] = $fila['nick'];

            # Según tipo de rol
            if ($fila['tipo'] == 'Administrador') {
                header('location: dashboard_admin.php');
            } else {
                header('location: dashboard.php');
            }
            exit();
        } else {
            # Mostrar error de login en html
            $errorlogin = "Credenciales incorrectas. Vuelve a intentarlo de nuevo.";
        }
    }
} catch (PDOException $e) {
    echo "Error en base de datos de tipo: " . $e->getMessage();
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
                    <a href="login.php"><img id="logo" src="img/ig-logo.png" alt=""></a>
                    <form form id="loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                        method="post">
                        <input type="text" id="usuario" name="usuario" placeholder="Usuario">
                        <input type="password" id="clave" name="clave" placeholder="Contraseña">
                        <div class="iniciar-sesion">
                            <input type="submit" value="Entrar">
                        </div>
                    </form>
                    <hr>
                    <p><span>O</span></p>
                    <div class="error-login">
                        <?php
                        # Muestra error de login en pantalla
                        if (isset($errorlogin)) {
                            echo $errorlogin;
                        } ?>
                    </div>
                    <div class="login-fb">
                        <img id="fb" src="img/facebook.png" alt=""><a href="#">Iniciar sesión con Facebook</a>
                    </div>
                    <a id="forgot" href="#">¿Has olvidado tu contraseña?</a>
                </div>
                <div class="contenedor-registro">
                    <p>¿No tienes cuenta?<a href="registro.php"> Regístrate</a></p>
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