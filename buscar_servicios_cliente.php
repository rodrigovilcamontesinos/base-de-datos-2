<?php
require 'includes/auth.php';
check_login();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Servicios Utilizados</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Video de Fondo -->
    <video autoplay muted loop id="video-background">
        <source src="videos/background.mp4" type="video/mp4">
        Tu navegador no soporta la etiqueta de video.
    </video>

    <div class="container">
        <h1 class="my-5 text-center">Buscar Servicios Utilizados</h1>
        <form action="resultados_servicios_cliente.php" method="post">
            <div class="form-group">
                <label for="nombre_cliente">Nombre del Cliente:</label>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
        <div class="mt-4 text-center">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Sistema de Gestión Hotelera</p>
    </footer>
</body>
</html>
