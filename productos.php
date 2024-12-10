<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: error.php'); // Redirigir a la página de error si no está autenticado
    exit;
}

// Incluir el archivo de conexión
require_once 'includes/conexion.php';

// Consulta para obtener los productos
$sql = "SELECT id_producto, nombre_producto, precio_producto, descripcion_producto, imagen_producto, stock_producto FROM productos";
$stmt = $pdo->query($sql);
$productos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible=IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miss Universo Panamá - Tienda</title>
    <link rel="icon" href="imagenes/miss-universe-logo.png" type="image/png">
    <link rel="stylesheet" href="css/styleproductos.css">
</head>
<body>
<header>
    <h1>Miss Universo Panamá<br>Tienda</h1>
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

    <div class="container-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-cart">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
        </svg>
        <div class="count-products">
            <span id="contador-productos">0</span>
        </div>
    </div>
</header>

<div class="container-cart-products hidden-cart">
    <div class="cart-product">
        <div class="info-cart-product">
            <!-- Productos se agregarán dinámicamente aquí -->
        </div>
    </div>
    <div class="cart-total">
        <h3>Total:</h3>
        <span class="total-pagar">$0.00</span>
    </div>
</div>

<div class="container-items">
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="item">
                <figure>
                    <img src="imagenes/<?php echo htmlspecialchars($producto['imagen_producto']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" />
                </figure>
                <div class="info-product">
                    <h2><?php echo htmlspecialchars($producto['nombre_producto']); ?></h2>
                    <p><?php echo htmlspecialchars($producto['descripcion_producto']); ?></p>
                    <p class="price" data-price="<?php echo htmlspecialchars($producto['precio_producto']); ?>">$<?php echo htmlspecialchars($producto['precio_producto']); ?></p>
                    <p class="stock" data-stock="<?php echo htmlspecialchars($producto['stock_producto']); ?>">Stock disponible: <?php echo htmlspecialchars($producto['stock_producto']); ?></p>
                    <button class="add-to-cart" 
                            data-id="<?php echo $producto['id_producto']; ?>" 
                            data-nombre="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" 
                            data-precio="<?php echo htmlspecialchars($producto['precio_producto']); ?>">
                        Añadir al carrito
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
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

<script>
// Lógica del carrito
const botonesAgregar = document.querySelectorAll('.add-to-cart');
const carritoIcono = document.querySelector('.container-icon');
const carritoProductos = document.querySelector('.container-cart-products');
const contadorProductos = document.getElementById('contador-productos');
const totalPagar = document.querySelector('.total-pagar');

let total = 0;
let cantidadProductos = 0;
const carrito = {};

carritoIcono.addEventListener('click', () => {
    carritoProductos.classList.toggle('hidden-cart');
});

botonesAgregar.forEach(boton => {
    boton.addEventListener('click', (e) => {
        const producto = e.target.closest('.item');
        const id = boton.dataset.id;
        const titulo = producto.querySelector('h2').textContent;
        const precio = parseFloat(producto.querySelector('.price').dataset.price);
        const stockDisponible = parseInt(producto.querySelector('.stock').dataset.stock);

        if (!carrito[id]) {
            carrito[id] = { titulo, precio, cantidad: 0, stock: stockDisponible };
        }

        if (carrito[id].cantidad < carrito[id].stock) {
            carrito[id].cantidad++;
            const productoCarrito = document.querySelector(`.cart-product[data-id="${id}"]`);

            if (!productoCarrito) {
                const nuevoProductoCarrito = document.createElement('div');
                nuevoProductoCarrito.classList.add('cart-product');
                nuevoProductoCarrito.dataset.id = id;

                nuevoProductoCarrito.innerHTML = `
                    <div class="info-cart-product">
                        <span class="cantidad-producto-carrito">${carrito[id].cantidad}</span>
                        <p class="titulo-producto-carrito">${titulo}</p>
                        <span class="precio-producto-carrito">$${(carrito[id].precio * carrito[id].cantidad).toFixed(2)}</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-close">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                `;

                carritoProductos.insertBefore(nuevoProductoCarrito, totalPagar.parentElement);

                nuevoProductoCarrito.querySelector('.icon-close').addEventListener('click', () => {
                    carrito[id].cantidad--;
                    total -= carrito[id].precio;
                    cantidadProductos--;
                    if (carrito[id].cantidad === 0) {
                        delete carrito[id];
                        nuevoProductoCarrito.remove();
                    } else {
                        nuevoProductoCarrito.querySelector('.cantidad-producto-carrito').textContent = carrito[id].cantidad;
                        nuevoProductoCarrito.querySelector('.precio-producto-carrito').textContent = `$${(carrito[id].precio * carrito[id].cantidad).toFixed(2)}`;
                    }
                    totalPagar.textContent = `$${total.toFixed(2)}`;
                    contadorProductos.textContent = cantidadProductos;
                });
            } else {
                productoCarrito.querySelector('.cantidad-producto-carrito').textContent = carrito[id].cantidad;
                productoCarrito.querySelector('.precio-producto-carrito').textContent = `$${(carrito[id].precio * carrito[id].cantidad).toFixed(2)}`;
            }

            total += carrito[id].precio;
            cantidadProductos++;
            totalPagar.textContent = `$${total.toFixed(2)}`;
            contadorProductos.textContent = cantidadProductos;
        } else {
            alert('No puedes agregar más unidades de este producto. Stock máximo alcanzado.');
        }
    });
});
</script>

</body>
</html>
