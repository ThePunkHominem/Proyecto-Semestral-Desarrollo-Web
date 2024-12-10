<?php
session_start();
require_once 'includes/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php'); // Redirigir al inicio de sesión
    exit;
}

// Verificar si el usuario es administrador
if ($_SESSION['rol_usuario'] !== 'admin') {
    header('Location: productos.php'); // Redirigir a la tienda si no es administrador
    exit;
}

// Verificar si se recibió el ID del producto
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_productos.php");
    exit;
}

$id_producto = $_GET['id'];

// Obtener los datos actuales del producto
$stmt = $pdo->prepare("SELECT * FROM productos WHERE id_producto = :id");
$stmt->execute(['id' => $id_producto]);
$producto = $stmt->fetch();

if (!$producto) {
    // Si no se encuentra el producto, redirigir al panel principal
    header("Location: admin_productos.php");
    exit;
}

// Manejar la actualización del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_producto'];
    $precio = $_POST['precio_producto'];
    $descripcion = $_POST['descripcion_producto'];
    $stock = $_POST['stock_producto'];
    $imagen = '../imagenes/' . $_POST['imagen_producto']; // Concatenar la ruta automáticamente

    $stmt = $pdo->prepare("UPDATE productos 
                           SET nombre_producto = :nombre, 
                               precio_producto = :precio, 
                               descripcion_producto = :descripcion, 
                               stock_producto = :stock, 
                               imagen_producto = :imagen 
                           WHERE id_producto = :id");
    $stmt->execute([
        'nombre' => $nombre,
        'precio' => $precio,
        'descripcion' => $descripcion,
        'stock' => $stock,
        'imagen' => $imagen,
        'id' => $id_producto
    ]);

    // Redirigir al panel principal después de la actualización
    header("Location: admin_productos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="icon" href="imagenes/miss-universe-logo.png" type="image/png">
    <link rel="stylesheet" href="css/styleadmin.css">
</head>
<body>
    <header>
        <h1>Editar Producto</h1>
        <nav>
            <ul>
                <li><a href="admin_productos.php">Volver al Panel</a></li>
            </ul>
        </nav>
    </header>

    <div class="container-items">
        <h2>Editar Producto: <?php echo htmlspecialchars($producto['nombre_producto']); ?></h2>
        <form method="POST" action="" style="padding: 20px; background-color: #ecf0f1; border-radius: 10px; margin-top: 20px;">
            <label>Nombre del Producto:</label><br>
            <input type="text" name="nombre_producto" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 10px;"><br>

            <label>Precio del Producto:</label><br>
            <input type="number" name="precio_producto" step="0.01" value="<?php echo htmlspecialchars($producto['precio_producto']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 10px;"><br>

            <label>Descripción del Producto:</label><br>
            <textarea name="descripcion_producto" required style="width: 100%; padding: 10px; margin-bottom: 10px;"><?php echo htmlspecialchars($producto['descripcion_producto']); ?></textarea><br>

            <label>Stock del Producto:</label><br>
            <input type="number" name="stock_producto" value="<?php echo htmlspecialchars($producto['stock_producto']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 10px;"><br>

            <label>Nombre de la Imagen:</label> <!-- Mostrar solo el nombre de la imagen -->
            <input type="text" name="imagen_producto" value="<?php echo basename($producto['imagen_producto']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 10px;"><br>

            <button type="submit" style="background-color: #6A1B9A; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Actualizar Producto</button>
        </form>
    </div>

    <footer>
        <p>©Todos los derechos Reservados 2024</p>
        <p>Miss Universo Panamá</p>
        <p>Contáctenos: +507 6632-9696 </p>
        <div class="social-icons">
            <a href="https://www.instagram.com/missuniversepanamaorg/">Instagram</a>
            <a href="https://www.facebook.com/p/Miss-Universo-Panam%C3%A1-100083191335626/">Facebook</a>
            <a href="https://x.com/missuniverse?lang=es">Twitter</a>
        </div>
    </footer>
</body>
</html>
