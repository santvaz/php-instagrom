<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    $admin = $_SESSION['usuario'];
} else {
    // Si el usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header('Location: login.php');
    exit();
}

// Establecer la conexión con la base de datos
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
    <link rel="stylesheet" type="text/css" href="css/dashboard_admin.css">
</head>
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
            <a href="controlpanel.php">Gestión de usuarios</a>
        </div>
        <div id="icons2"><a href="logout.php">Cerrar sesión</a></div>
    </div>
</header>


<body>

    <div id="stories-wrapper">
        <div id="stories-container">
            <a class="story">
                <div class="profile">
                    <img src="https://images.unsplash.com/photo-1708242124912-ca576feddd90?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="" />
                </div>
                <div class="title">mave.lmao</div>
            </a>
            <a class="story">
                <div class="profile">
                    <img src="https://images.unsplash.com/photo-1603415526960-f7e0328c63b1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="" />
                </div>
                <div class="title">john_doe</div>
            </a>
            <a class="story">
                <div class="profile">
                    <img src="https://images.unsplash.com/photo-1619895862022-09114b41f16f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="" />
                </div>
                <div class="title">nuriardz</div>
            </a>
            <a class="story">
                <div class="profile">
                    <img src="https://images.unsplash.com/photo-1699959634881-16f34059a78f?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="" />
                </div>
                <div class="title">khris.23</div>
            </a>
            <a class="story">
                <div class="profile visited">
                    <img src="https://plus.unsplash.com/premium_photo-1706727288505-674d9c8ce96c?q=80&w=1964&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="" />
                </div>
                <div class="title">adamign</div>
            </a>
        </div>
    </div>


    <div id="main-container">
        <div id="main">
            <?php
            try {
                $sql = "SELECT p.*, u.nick FROM publicaciones p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.fecha_publicacion DESC";
                $stmt = $db->query($sql);
                $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Error al obtener las publicaciones: " . $e->getMessage();
                exit();
            }

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
                                    <?php echo $publicacion['nick']; ?>
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



            <div class="post">
                <div class="post-header">
                    <div class="post-avatar">
                        <img src="https://images.unsplash.com/photo-1553614186-a373dedbb390?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="">
                    </div>
                    <div class="post-header-text-wrapper">
                        <div class="post-header-text">
                            <p>clara.galle</p>
                            <p>Londres, Reino Unido</p>
                        </div>
                    </div>
                </div>
                <div class="post-img">
                    <img src="https://images.unsplash.com/photo-1584284807530-cb3c3248adc6?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="">
                </div>
                <div class="post-icons">
                    <img src="img/heart.svg" alt="">
                    <img src="img/message-circle.svg" alt="">
                    <img src="img/send.svg" alt="">
                </div>
                <div class="post-likes">
                    <p>579 likes</p>
                </div>
                <div class="post-comments">
                    <p>Vibrante</p>
                    <p>🌃✨ #NocheEnLaCiudad</p>
                </div>
                <div class="post-time">
                    <p>1 day ago</p>
                </div>
                <div class="comments">
                    <form action="">
                        <input type="text" minlength="1" maxlength="60" placeholder="Añade un comentario">
                        <input type="submit" value="Publicar">
                    </form>
                </div>
            </div>


            <div class="post">
                <div class="post-header">
                    <div class="post-avatar">
                        <img src="https://images.unsplash.com/photo-1677981263391-b8190d27a56a?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="">
                    </div>
                    <div class="post-header-text-wrapper">
                        <div class="post-header-text">
                            <p>loganweaver</p>
                            <p>Barcelona, España</p>
                        </div>
                    </div>
                </div>
                <div class="post-img">
                    <img src="https://images.unsplash.com/photo-1581803118522-7b72a50f7e9f?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="">
                </div>
                <div class="post-icons">
                    <img src="img/heart.svg" alt="">
                    <img src="img/message-circle.svg" alt="">
                    <img src="img/send.svg" alt="">
                </div>
                <div class="post-likes">
                    <p>76 likes</p>
                </div>
                <div class="post-comments">
                    <p>good news</p>
                    <p>good news, i'm saved eternally</p>
                </div>
                <div class="post-time">
                    <p>Hace 14 minutos</p>
                </div>
                <div class="comments">
                    <form action="">
                        <input type="text" minlength="1" maxlength="60" placeholder="Añade un comentario">
                        <input type="submit" value="Publicar">
                    </form>
                </div>
            </div>
        </div>

        <div class="footer">
            <div id="foot-container">
                <div id="pic1">
                    <img src="img/home.svg"></img>
                </div>

                <div id="pic2">
                    <img
                        src="data:image/png;base64,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"></img>
                </div>

                <div id="pic3">
                    <img
                        src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw0PDQ0PEA0NDg8NDQ0NDg8NDQ8NDRANFREWFhURExUYHyogGCYlGxYVLTEhJik3Oi4uFyszOTMyNyotLzcBCgoKBQUFDgUFDisZExkrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrK//AABEIAOEA4QMBIgACEQEDEQH/xAAcAAEAAwEBAQEBAAAAAAAAAAAABQYHAQgEAwL/xABIEAABAwIACAYOCAUFAQAAAAAAAQIDBAUGBxEXIVV00hIxNUGTswgWNDZRU3FzdZKUsrTTEyIjYWKBkcIyQoKisRQkM0NSJf/EABQBAQAAAAAAAAAAAAAAAAAAAAD/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwDcAFAAAAAAAAAAAAAAAGUAAAAAAAAAAAAAAAAAAAAOgADigAAAAAAAA4qpkyroRNOnQmTwkfLfqBqq11dRtVONHVMTVy+RVAkQRnbFbtYUXtcO8O2K3awova4d4CTBGdsVu1hRe1w7w7YrdrCi9rh3gJMEZ2xW3WFF7XDvDtitusKL2uHeAkwRnbFbdYUXtcO8O2K3awova4d4CTBGdsVu1hRe1w7w7YrdrCi9rh3gJMEZ2xW7WFF7XDvDtit2sKL2uHeAkwRrcILeqoiV9EqrzJVQqv8AkkGPRyIrVRUXiVFRU/UD+gAAAAAAAdAAHFAAAAADNMZWNeC2OdS0rWVNaiZH5V+wp1yf9mTS534U/NU4lkcb2Ga2q3fZOyVdWroabiVWIifXmyfhRUyfe5DyzI9znK5yq5zlVznOVVcrl0qqrzgTOEWFlyuLldV1k0qKuVIuFwIG+Dgxt+qnlyEIAAAAAAAAAAAAAAAAAAJOyYQV1C/h0lXPTrlyqkb1Rjl/Gz+F3kVCMAHoPFxjkZVPZSXFI4J35GxVTfqQSu5myJ/IvFp4l+7Rl188Ono3EVhs6tpn0FQ9X1NExHRPcuV8tJlyJl8KsXIir4FT7wNVAAAAAdAAHAAAAAHmPHzdnT32WLKvAooYYGpzcJzUkcv6vyf0mclsxrr/APfum0/saVMAAAAAAAAAAfTbaCapnip4I3SzTPRkbG5MrnL5eLyqB8wJC+2WroKh1NVQugmajXKxytd9VU0KjmqqOT70UjwAAAAAAAABasV92dSXy3SIqo19Qynk8CxzfZrl8nCRfyKqSGDy/wC+otrputaB7SAAAAAdAAHAAAAAHknGty/dNp/Y0qZbMa3L902n9jSpgAAAAAAAAC6Ym++K2ecn+HkKWXTE33xWzzk/w8gE52RHLcXo+DrJTLzUOyI5bi9HwdZKZeAAAAAAAAAJDB/u6i2un6xpHkhg/wB3UW10/WNA9pAAAAAOgADgCgAAAPJONbl+6bSvuNKmWzGty/dNpX3GlTAAAAAAAAAF0xN98Vs85P8ADyFLLpib74rZ5yf4eQCc7IjluL0fB1kpl5qHZEctxej4OslMvAAAAAAAAAEhg/3dRbXT9Y0jyQwf7uotrp+saB7SAAAAAdAAHFAUAAAB5Jxrcv3TaV9xpUy2Y1uX7ptK+40qYAA+m20E9TNHBBE+aaV3BjjYmVzl4/8AGXT9wHzAumarCLVknT02+M1WEWrJOnpt8ClgumarCLVknT02+M1WEWrJOnpt8Cll0xN98Vs85P8ADyDNVhFqyTp6bfLPiyxe3ujvdBU1FA+KGJ8qyPWWByNRYXtTQ1yrxqgHydkRy3F6Pg6yUy83HHTgRdrhdY56SjdPElHDEr0khYn0iPkVUyOci8Sp+pQs1WEWrJOnpt8ClgumarCLVknT02+M1WEWrJOnpt8ClgumarCLVknT02+M1WEWrJOnpt8ClgkL3ZauhnWnqoHwTI1HcB+TS1eJyKmhU0LpTwEeAJDB/u6i2un6xpHkhg/3dRbXT9Y0D2kAAAAA6AAOKAAAAA8k41uX7ptK+40qZbMa3L902lfcaVMASFgvNRQVcNXTuRs0DlcxXNRzdLVa5qpzorVVPzI8Aahn0vfirf0EvzBn0vfirf0EvzDLwBqGfS9+Kt/QS/MGfS9+Kt/QS/MMvAGoZ9L34q39BL8wsOL7G1dbhdqOjmjo0iqHSI9YoZGyZGxPcmRVeqcbU5jDi6YnO+K2ecn+HkA0/GvjLuVpuTKamZSujdSxTKs0T3v4bnvRdKOTR9VCmZ9L34q39BL8wdkRy3F6Pg6yUy8DUM+l78Vb+gl+YM+l78Vb+gl+YZeANQz6XvxVv6CX5gz6XvxVv6CX5hl4AmsLcJ6u61X+qqlYsiRthY2NnAjZG1VVGtTSvG5y6V5yFAAEhg/3dRbXT9Y0jyQwf7uotrp+saB7SAAAAAdAAHAAAAAHknGty/dNpX3GlTLZjW5fum0r7jSpgAAAAAAAAC6Ym++K2ecn+HkKWXTE33xWzzk/w8gE52RHLcXo+DrJTLzUOyI5bi9HwdZKZeAAAAAAAAAJDB/u6i2un6xpHkhg/wB3UW10/WNA9pAAAAAOgADgAAAADyTjW5fum0r7jSplsxrcv3Taf2NKmAAAAAAAAALpib74rZ5yf4eQpZdMTffFbPOT/DyATnZEctxej4OslMvNQ7IjluL0fB1kpl4AAAAAAAAAkMH+7qLa6frGkeSGD/d1FtdP1jQPaQAAAADoAA4AAAAA8k41uX7ptP7GlTL/AI8ra6C/1L8mRtVHDUs0cysRjv7mOKAAAAAAAAAAJCw3eehq4KuBWpNTv4bOEnCauhUVrk8Coqp+ZHgCawuwmqrrVrV1P0aSKxkbWwtVkbI25cjWoqqvGqrpXnIUAAAAAAAAAASGD/d1FtdP1jSPLHi6trqq9W2FEy/7uKV+jL9nGv0j/wC1qgevwAAAAHQABxQFAAAAZrjwwOdcKBtTAxXVVBw3o1qZXy0y/wDIxE51TIip5FROM8znuIxrGdie/wBQ+SttiMZK9VfNSKqMZI7jV0K8TVVf5V0L4U4lDAgfVcbfUU0roZ4ZYJW/xRysdG9PvyL/AJPlAAAAAAAAAAAAAAAAAAH601PJK9sccb5JHrkYyNqve5fAjU0qB+RvnY/YHPijkus7Fa6diw0jXJkVIMuV8v8AUqIifci8ykVi4xMzPeyqurPo4m5HMo8v2si8302T+FPw8a8+Tn3ljEaiNaiNa1EaiNREa1qaERE5gP6AAAAAdAAHFAUAAAAAAHyXK10tUzgVNNBUM40ZPEyVqL4URyaCuyYtMH3KrltdOmX/AMrIxP0a5EQtoAp6YsMHtWQ+vNvDNhg9qyH15t4uAAp+bDB7VkPrzbwzYYPash9ebeLgAKfmwwe1ZD6828M2GD2rIfXm3i4ACoZsMHtWQ+vNvHM2GD2rIfXm3i4ACoZsMHtWQ+vNvDNfg9qyH15t4t4Ap6YsMHtWQ+vNvBMWGD2rIfXm3i4ACosxY4PouVLXBo8LpVT9FcT1qsdFSIqUtJTUyO/iWCFkSu8qomVfzJAAAAAAAAAAdAAHFAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAH//2Q=="></img>
                </div>

                <div id="pic4">
                    <img src="img/heart.svg"></img>
                </div>

                <div id="pic5">
                    <button class="perfil">
                        <img src="img/user.svg" />
                    </button>
                </div>
            </div>
        </div>
</body>