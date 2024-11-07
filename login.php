<?php
include 'config.php';
session_start();

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

// Verificar las credenciales del usuario
$sql = "SELECT * FROM usuarios WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['authenticated'] = true;
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['login_time'] = time();

        // Configurar el tiempo de expiración de la sesión a 10 segundos para pruebas
        $_SESSION['session_expiration'] = time() + 10;

        header("Location: success.php"); // Redirige a success.php
        exit;
    } else {
        echo "<script>alert('Contraseña incorrecta.'); window.location.href='index.html';</script>";
    }
} else {
    echo "<script>alert('Usuario no encontrado.'); window.location.href='index.html';</script>";
}

$conn->close();
?>
