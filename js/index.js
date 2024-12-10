// Seleccionar los elementos necesarios
const botonesAgregar = document.querySelectorAll('.add-to-cart');
const carritoIcono = document.querySelector('.container-icon');
const carritoProductos = document.querySelector('.container-cart-products');
const contadorProductos = document.getElementById('contador-productos');
const totalPagar = document.querySelector('.total-pagar');

let total = 0;
let cantidadProductos = 0;

// Mostrar/ocultar el carrito al hacer clic en el icono
carritoIcono.addEventListener('click', () => {
    carritoProductos.classList.toggle('hidden-cart');
});

// Agregar funcionalidad a los botones
botonesAgregar.forEach(boton => {
    boton.addEventListener('click', (e) => {
        const producto = e.target.closest('.item');
        const titulo = producto.querySelector('h2').textContent;
        const precio = parseFloat(producto.querySelector('.price').dataset.price);

        // Crear nuevo producto en el carrito
        const productoCarrito = document.createElement('div');
        productoCarrito.classList.add('cart-product');

        productoCarrito.innerHTML = `
            <div class="info-cart-product">
                <span class="cantidad-producto-carrito">1</span>
                <p class="titulo-producto-carrito">${titulo}</p>
                <span class="precio-producto-carrito">$${precio.toFixed(2)}</span>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-close">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        `;

        carritoProductos.insertBefore(productoCarrito, totalPagar.parentElement);

        // Actualizar el total y la cantidad
        total += precio;
        cantidadProductos += 1;
        totalPagar.textContent = `$${total.toFixed(2)}`;
        contadorProductos.textContent = cantidadProductos;

        // Eliminar producto del carrito
        productoCarrito.querySelector('.icon-close').addEventListener('click', () => {
            productoCarrito.remove();
            total -= precio;
            cantidadProductos -= 1;
            totalPagar.textContent = `$${total.toFixed(2)}`;
            contadorProductos.textContent = cantidadProductos;
        });
    });
});
