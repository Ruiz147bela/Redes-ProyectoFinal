<?php
include 'config.php';
session_start();

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    $login_time = $_SESSION['login_time'];
    $logout_time = time();
    $duracion = $logout_time - $login_time;

    $registro_acceso_id = $_SESSION['registro_acceso_id'];

    // Conectar a la base de datos
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Insertar la duración de la sesión en `duracion_sesiones`
    $sql = "INSERT INTO duracion_sesiones (registro_acceso_id, tiempo_salida, duracion) VALUES (?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $registro_acceso_id, $duracion);
    $stmt->execute();

    // Cerrar sesión y redirigir al usuario
    session_unset();
    session_destroy();
    header("Location: index.html");
    exit;
}

?>
