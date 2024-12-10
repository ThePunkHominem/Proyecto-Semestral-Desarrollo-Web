<?php
session_start();

// Verifica si el usuario no está logueado
if (!isset($_SESSION['username'])) {
    $message = "No has iniciado sesión. Por favor, inicia sesión para continuar.";
} else {
    $message = "La página que buscas no está disponible.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página No Encontrada</title>
    <link rel="icon" href="imagenes/miss-universe-logo.png" type="image/png">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f3e5f5;
            color: #4A148C;
        }

        .container {
            text-align: center;
            max-width: 600px;
        }

        .container img {
            width: 400px; /* Ajusta el ancho aquí */
            height: auto; /* Mantiene la proporción */
            margin: 0 auto 20px;
            display: block;
        }

        .container h1 {
            font-size: 2rem;
            color: #6A1B9A;
            margin-bottom: 10px;
        }

        .container p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 20px;
        }

        .container a {
            text-decoration: none;
            font-weight: bold;
            background-color: #6A1B9A;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .container a:hover {
            background-color: #9b6aa3;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="imagenes/Glot.png" alt="Dog Error">
        <h1>¡Oops!</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="index.php">Ir a Iniciar Sesión</a>
    </div>
</body>
</html>
