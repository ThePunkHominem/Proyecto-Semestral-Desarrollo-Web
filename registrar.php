<?php
require_once "includes/conexion.php"; // Archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves existen en $_POST
    $username = isset($_POST["username"]) ? $_POST["username"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $password = isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : null;

    // Validar que los campos no estén vacíos
    if (!$username || !$email || !$password) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    try {
        // Consulta SQL para insertar un nuevo usuario
        $sql = "INSERT INTO usuarios (nombre_usuario, email_usuario, password_usuario) 
                VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($sql);

        // Vincular los valores a los parámetros
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        echo "Usuario registrado exitosamente";

        // Redirigir a la pagina de inicio 
        header("Location: index.php");
        exit(); // Asegurar que el script se detenga después de la redirección
    } catch (PDOException $e) {
        // Verificar si el error es por duplicado
        if ($e->getCode() == 23000) {
            echo "El correo electrónico o el nombre de usuario ya están registrados.";
        } else {
            echo "Error en la base de datos: " . $e->getMessage();
        }
    }
}
?>
