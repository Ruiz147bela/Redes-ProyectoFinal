<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
$servername = "localhost";
$dbusername = "root"; // Usuario predeterminado de MAMP
$dbpassword = "root"; // Contraseña predeterminada de MAMP
$dbname = "registro_actividad";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    echo "<script>alert('Error de conexión: " . $conn->connect_error . "'); window.location.href='register.html';</script>";
    exit;
}

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Comprobar si el usuario ya existe
$sql = "SELECT * FROM usuarios WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('El nombre de usuario ya está en uso. Por favor, elige otro.'); window.location.href='register.html';</script>";
} else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Cifrar la contraseña
    $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Error al registrar el usuario. Por favor, inténtalo de nuevo.'); window.location.href='register.html';</script>";
    }
}

$conn->close();
?>
