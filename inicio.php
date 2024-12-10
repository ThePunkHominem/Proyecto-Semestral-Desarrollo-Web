<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: error.php'); // Redirigir a la página de error si no está autenticado
    exit;
}

// Obtener el nombre del usuario si está autenticado
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <title>Miss Universo Panamá - Empoderamiento Femenino</title>
    <link rel="icon" href="imagenes/miss-universe-logo.png" type="image/png">
    <link rel="stylesheet" href="css/styleinicio.css" />
</head>
<body>

<header>
    <h1>Miss Universo Panamá<br>Empoderamiento Femenino</h1>
    <nav>
    <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="acercade.php">Acerca de Nosotros</a></li>
            <li><a href="productos.php">Productos</a></li>
            <!-- Mostrar enlace "Admin" solo si el usuario tiene el rol de administrador -->
            <?php if (isset($_SESSION['rol_usuario']) && $_SESSION['rol_usuario'] === 'admin'): ?>
                <li><a href="admin_productos.php">Admin</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <a href="cerrar_sesion.php" class="cerrar-sesion">Cerrar Sesión</a>
</header>

<main class="content">
    <div class="main-text">
        <h2>Información</h2>
        <p>La Organización Miss Universo (MUO) es una organización global e inclusiva que celebra todas las culturas, orígenes y religiones. Creamos y brindamos un espacio seguro para que las mujeres compartan sus historias e impulsen un impacto personal, profesional y filantrópico. Las mujeres que participan en esta plataforma internacional sirven como líderes inspiradoras y modelos a seguir para sus comunidades y sus seguidores en todo el mundo.</p>
        <p>A través de su plataforma, Miss Universo promueve la confianza, el liderazgo y la filantropía. Las ganadoras se convierten en modelos a seguir, abogando por causas sociales importantes que inspiran a millones de personas. La experiencia les inculca habilidades y oportunidades, abriéndoles puertas a nuevas carreras y generando un impacto global. El intercambio cultural y el crecimiento personal que fomenta Miss Universo forjan líderes fuertes y compasivos dedicados a marcar una diferencia en el mundo.</p>
        <p>Además de su enfoque en el empoderamiento personal y el liderazgo, Miss Universo impulsa iniciativas sociales y programas educativos diseñados para impactar positivamente a comunidades desfavorecidas. A través de colaboraciones con organizaciones benéficas y empresas globales, fomenta el acceso a recursos esenciales como la educación, la salud y la igualdad de oportunidades. Este compromiso subraya su misión de crear un mundo más inclusivo y equitativo, donde cada mujer pueda alcanzar su máximo potencial y convertirse en un agente de cambio.</p>
    </div>
    <div class="image-section">
        <img src="imagenes/italy_mora_1.jpg" alt="Miss Universo Panamá">
        <p>Italia Johan Peñaloza Mora es una modelo panameña y ganadora de un concurso de belleza que ganó Señorita Panamá 2024.</p>
    </div>
</main>

<footer>
      <p>© Todos los derechos Reservados 2024</p>
      <p>Miss Universo Panamá</p>
      <p>Contáctenos: +507 6632-9696</p>
      <div class="social-icons">
        <a href="https://www.instagram.com/missuniversepanamaorg/">Instagram</a>
        <a href="https://www.facebook.com/p/Miss-Universo-Panam%C3%A1-100083191335626/">Facebook</a>
        <a href="https://x.com/missuniverse?lang=es">Twitter</a>
      </div>
</footer>
</body>
</html>
