<?php
$servername = "192.168.0.161"; // IP del servidor MariaDB
$username = "phpmyadmin";
$password = "Lechuga12345!!!";
$dbname = "missu_db";
try {
    // Crear conexión PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Configurar atributos PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Manejo de errores
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Modo de obtención de datos
    
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
