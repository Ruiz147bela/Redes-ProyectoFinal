<?php
session_start();

// Verificar si la sesión está activa y no ha expirado
if (isset($_SESSION['authenticated']) && time() <= $_SESSION['session_expiration']) {
    echo json_encode(["active" => true]);
} else {
    // Si la sesión ha expirado, destruye la sesión y devuelve "active" como false
    session_unset();
    session_destroy();
    echo json_encode(["active" => false]);
}
?>
