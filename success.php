<?php
session_start();

// Verificar si la sesión ha expirado al cargar la página
if (!isset($_SESSION['authenticated']) || time() > $_SESSION['session_expiration']) {
    session_unset();
    session_destroy();
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Verificar el estado de la sesión cada 5 segundos
        setInterval(function() {
            fetch("check_session.php")
                .then(response => response.json())
                .then(data => {
                    if (!data.active) {
                        // Si la sesión ha expirado, redirige a index.html
                        window.location.href = "index.html";
                    }
                });
        }, 5000); // Verifica cada 5 segundos
    </script>
</head>
<body>
    <div class="container">
        <h2>¡Bienvenido!</h2>
        <p>Has iniciado sesión correctamente. Ahora tienes acceso a la red.</p>
        <form action="logout.php" method="post">
            <input type="submit" value="Cerrar Sesión">
        </form>
    </div>
</body>
</html>
