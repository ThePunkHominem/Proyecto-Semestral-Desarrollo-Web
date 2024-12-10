<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: error.php'); // Redirigir a la página de error si no está autenticado
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Miss Universo Panamá - Tienda</title>
    <link rel="icon" href="imagenes/miss-universe-logo.png" type="image/png">
    <link rel="stylesheet" href="css/styleproductos.css" />
</head>
<body>
    <header>
        <h1>Miss Universo Panamá<br>Tienda</h1>
        <nav aria-label="Menú principal">
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

    <main>
        <div class="contenedor-principal">
            <section class="mision">
                <h3>Misión</h3>
                <p>Nuestra misión es ofrecer a mujeres de todos los ámbitos de la vida en todo el mundo la mejor experiencia de empoderamiento a través de su participación en concursos de belleza. Al brindar acceso al escenario más grande del mundo, creamos oportunidades para el crecimiento personal, el desarrollo de la confianza y la búsqueda de sueños. Esta plataforma va más allá de la belleza.</p>
            </section>

            <section class="vision">
                <h3>Visión</h3>
                <p>Convertirnos en la marca líder de estilo de vida para mujeres en todo el mundo, ofreciendo productos y servicios innovadores, elegantes y de alta calidad que empoderen, inspiren y transformen la vida cotidiana. Aspiramos a establecer estándares globales en moda, belleza, bienestar y vida hogareña, promoviendo sostenibilidad, inclusión y comunidad, mientras celebramos la individualidad.</p>
            </section>

            <section class="valores">
                <h3>Valores</h3>
                <p>Creemos en transformar vidas ofreciendo herramientas que inspiren confianza, crecimiento y bienestar. Fomentamos la prosperidad mediante el desarrollo personal y profesional, apoyando sueños que trasciendan generaciones. Nos dedicamos a servir a la humanidad con igualdad, respeto y sin distinciones, promoviendo inclusión, justicia y empatía en cada acción que emprendemos.</p>
            </section>
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
