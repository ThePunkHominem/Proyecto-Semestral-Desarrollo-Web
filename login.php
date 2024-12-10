<?php
// Iniciar la sesión
session_start();
require_once 'includes/conexion.php'; // Asegúrate de que este archivo tiene la conexión PDO a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = $_POST['username'];  // Cambiado de 'email' a 'username'
    $password = $_POST['password'];

    // Consulta para obtener el usuario
    $sql = "SELECT id_usuario, nombre_usuario, rol_usuario, password_usuario FROM usuarios WHERE nombre_usuario = :username"; // Cambiado 'email_usuario' a 'nombre_usuario'
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);  // Cambiado 'email' a 'username'
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password_usuario'])) {
        // Si las credenciales son correctas, guardamos datos en la sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
        $_SESSION['rol_usuario'] = $usuario['rol_usuario'];

        // Redirigir al panel de administración si es admin
        if ($usuario['rol_usuario'] === 'admin') {
            header('Location: admin_productos.php');
        } else {
            header('Location: inicio.php');
        }
        exit;
    } else {
        // Si las credenciales son incorrectas
        echo "Usuario o contraseña incorrectos.";
    }
}
?>