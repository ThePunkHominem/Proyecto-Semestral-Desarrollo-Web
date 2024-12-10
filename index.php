<?php
// Iniciar la sesión
session_start();
require_once 'includes/conexion.php'; // Asegúrate de que este archivo tiene la conexión PDO a la base de datos

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if ($username && $password) {
        // Consultar en la base de datos por el usuario
        $sql = "SELECT id_usuario, nombre_usuario, rol_usuario, password_usuario FROM usuarios WHERE nombre_usuario = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password_usuario'])) {
            // Si las credenciales son correctas, guardamos datos en la sesión
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $_SESSION['rol_usuario'] = $usuario['rol_usuario'];

            // Redirigir según el rol del usuario
            if ($usuario['rol_usuario'] === 'admin') {
                header('Location: inicio.php');
            } else {
                header('Location: inicio.php');
            }
            exit();
        } else {
            // Si las credenciales son incorrectas, mostramos un mensaje de error
            $error = "Usuario o contraseña incorrectos";
        }
    } else {
        $error = "Por favor, completa todos los campos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="icon" href="imagenes/miss-universe-logo.png" type="image/png">
    <link rel="stylesheet" href="css/styleproyecto.css">
</head>
<body>
    <div class="login-container">
        <h1>Inicio de Sesión</h1>
        <img src="imagenes/miss-universe-logo.png" alt="Logo Miss Universe" style="width: 100%; max-width: 300px; display: block; margin: 0 auto;">
        <!-- Mostrar mensaje de error si las credenciales son incorrectas -->
        <?php if (isset($error)): ?>
            <div class="error" style="color: red; text-align: center; margin-bottom: 10px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form action="login.php" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Iniciar Sesión</button>
        </form>
        
        <p>¿No tienes cuenta? <a href="registro1.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
