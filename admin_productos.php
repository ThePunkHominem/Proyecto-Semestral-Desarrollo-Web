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
    header('Location: inicio.php'); // Redirigir a la tienda si no es administrador
    exit;
}

// Manejar la eliminación de productos
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id_producto = :id");
    $stmt->execute(['id' => $delete_id]);
    header("Location: admin_productos.php");
    exit;
}

// Manejar el formulario para agregar productos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_producto'];
    $precio = $_POST['precio_producto'];
    $descripcion = $_POST['descripcion_producto'];
    $stock = $_POST['stock_producto'];
    $imagen = 'imagenes/' . $_POST['imagen_producto']; // Ruta relativa automática

    $stmt = $pdo->prepare("INSERT INTO productos (nombre_producto, precio_producto, descripcion_producto, stock_producto, imagen_producto) 
                           VALUES (:nombre, :precio, :descripcion, :stock, :imagen)");
    $stmt->execute([
        'nombre' => $nombre,
        'precio' => $precio,
        'descripcion' => $descripcion,
        'stock' => $stock,
        'imagen' => $imagen
    ]);

    header("Location: admin_productos.php");
    exit;
}

// Obtener todos los productos
$sql = "SELECT * FROM productos";
$stmt = $pdo->query($sql);
$productos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Productos</title>
    <link rel="icon" href="imagenes/miss-universe-logo.png" type="image/png">
    <link rel="stylesheet" href="css/styleadmin.css">
</head>
<body>
    <header>
        <h1>Panel de Administración<br>Productos</h1>
        <nav>
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href='acercade.php'>Acerca de Nosotros</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="admin_productos.php">Admin</a></li>
                <li><a href="cerrar_sesion.php" class="cerrar-sesion">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <div class="container-items">
        <h2>Lista de Productos</h2>
        <table border="1" style="width: 100%; text-align: left;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                        <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                        <td>$<?php echo htmlspecialchars($producto['precio_producto']); ?></td>
                        <td><?php echo htmlspecialchars($producto['descripcion_producto']); ?></td>
                        <td><?php echo htmlspecialchars($producto['stock_producto']); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($producto['imagen_producto']); ?>" alt="Imagen del producto" width="50">
                        </td>
                        <td>
                            <a href="editar_producto.php?id=<?php echo $producto['id_producto']; ?>">Editar</a>
                            <a href="admin_productos.php?delete_id=<?php echo $producto['id_producto']; ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Agregar Nuevo Producto</h2>
        <form method="POST" action="" style="padding: 20px; background-color: #ecf0f1; border-radius: 10px; margin-top: 20px;">
            <label>Nombre del Producto:</label><br>
            <input type="text" name="nombre_producto" required style="width: 100%; padding: 10px; margin-bottom: 10px;"><br>

            <label>Precio del Producto:</label><br>
            <input type="number" name="precio_producto" step="0.01" required style="width: 100%; padding: 10px; margin-bottom: 10px;"><br>

            <label>Descripción del Producto:</label><br>
            <textarea name="descripcion_producto" required style="width: 100%; padding: 10px; margin-bottom: 10px;"></textarea><br>

            <label>Stock del Producto:</label><br>
            <input type="number" name="stock_producto" required style="width: 100%; padding: 10px; margin-bottom: 10px;"><br>

            <label>Nombre de la Imagen (archivo en 'imagenes/'):</label>
            <input type="text" name="imagen_producto" placeholder="ejemplo.jpg" required style="width: 100%; padding: 10px; margin-bottom: 10px;"><br>

            <button type="submit" style="background-color: #6A1B9A; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Agregar Producto</button>
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
