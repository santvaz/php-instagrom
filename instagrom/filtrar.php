<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
} else {
    # Mensaje de bienvenida
    $mensaje_bienvenida = "¡Bienvenido, " . $_SESSION['usuario'] . "!";
}

$usuario = $_SESSION['usuario'];

$cadena_conexion = 'mysql:dbname=instagrom;host=127.0.0.1';
$usuario_db = 'root';
$clave_db = '';

try {
    $db = new PDO($cadena_conexion, $usuario_db, $clave_db);
} catch (PDOException $e) {
    echo "Error con la base de datos: " . $e->getMessage();
}
# Sentencia con subquery para seleccionar todas las publicaciones de un sólo usuario
$sql = $db->prepare("SELECT * FROM publicaciones WHERE usuario_id IN (SELECT id FROM usuarios WHERE nick = :nick)");
$sql->bindParam(':nick', $usuario);
$sql->execute();
$publicaciones = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <title>Dashboard de
        <?php echo $usuario; ?>
    </title>
</head>

<body>
    <header>
        <div id="header-container">
            <div class="bienvenida">
                <p>
                    <?php echo $mensaje_bienvenida; ?>
                </p>
            </div>
            <div id="iglogo">
                <a href="dashboard.php"><img id="iglogo" src="img/ig-logo.png" alt=""></a>
            </div>
            <div id="icons2">
                <!-- <a href="filtrar.php" style="color:darkblue; margin-right: 40px;">Ver sólo mis posts</a> -->
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </div>
    </header>


    <body>

        <div id="stories-wrapper">
            <div id="stories-container">
                <a class="story">
                    <div class="profile">
                        <img src="https://images.unsplash.com/photo-1708242124912-ca576feddd90?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" />
                    </div>
                    <div class="title">mave.lmao</div>
                </a>
                <a class="story">
                    <div class="profile">
                        <img src="https://images.unsplash.com/photo-1603415526960-f7e0328c63b1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" />
                    </div>
                    <div class="title">john_doe</div>
                </a>
                <a class="story">
                    <div class="profile">
                        <img src="https://images.unsplash.com/photo-1619895862022-09114b41f16f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" />
                    </div>
                    <div class="title">nuriardz</div>
                </a>
                <a class="story">
                    <div class="profile">
                        <img src="https://images.unsplash.com/photo-1699959634881-16f34059a78f?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" />
                    </div>
                    <div class="title">khris.23</div>
                </a>
                <a class="story">
                    <div class="profile visited">
                        <img src="https://plus.unsplash.com/premium_photo-1706727288505-674d9c8ce96c?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" />
                    </div>
                    <div class="title">adamign</div>
                </a>
            </div>
        </div>


        <div id="main-container">
            <div id="main">
                <?php
                try {
                    $db = new PDO($cadena_conexion, $usuario_db, $clave_db);
                } catch (PDOException $e) {
                    echo "Error con la base de datos: " . $e->getMessage();
                }

                $sql = $db->prepare("SELECT * FROM publicaciones WHERE usuario_id IN (SELECT id FROM usuarios WHERE nick = :nick)");
                $sql->bindParam(':nick', $usuario);
                $sql->execute();
                $publicaciones = $sql->fetchAll(PDO::FETCH_ASSOC);

                foreach ($publicaciones as $publicacion) {
                ?>
                    <div class="post">
                        <div class="post-header">
                            <div class="post-avatar">
                                <?php
                                if (empty($publicacion['imagen_perfil'])) {
                                    $imagen_perfil = 'assets/default-user.jpg';
                                }
                                ?>
                                <img src="<?php echo $imagen_perfil; ?>" alt="Foto de perfil">
                            </div>
                            <div class="post-header-text-wrapper">
                                <div class="post-header-text">
                                    <p>
                                        <?php echo $_SESSION['usuario'] ?>
                                    </p>
                                    <?php
                                    if (!empty($publicacion['ubicacion'])) {
                                    ?>
                                        <p>
                                            <?php echo $publicacion['ubicacion']; ?>
                                        </p>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="post-img">
                            <img src="<?php echo $publicacion['imagen']; ?>" alt="Imagen de la publicación">
                        </div>
                        <div class="post-icons">
                            <img src="img/heart.svg" alt="">
                            <img src="img/message-circle.svg" alt="">
                            <img src="img/send.svg" alt="">
                        </div>
                        <div class="post-likes">
                            <p>1k likes</p>
                        </div>
                        <div class="post-comments">
                            <p>
                                <?php echo $publicacion['mensaje']; ?>
                            </p>
                        </div>
                        <div class="post-time">
                            <p>
                                <?php echo $publicacion['fecha_publicacion']; ?>
                            </p>
                        </div>
                        <div class="comments">
                            <form action="">
                                <input type="text" minlength="1" maxlength="60" placeholder="Añade un comentario">
                                <input type="submit" value="Publicar">
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>

    </body>

</html>