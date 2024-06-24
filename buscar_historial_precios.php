<?php
require 'includes/auth.php';
check_login();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Historial de Precios</title>
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
        <h1 class="my-5 text-center">Buscar Historial de Precios</h1>
        <form action="resultados_historial_precios.php" method="post">
            <div class="form-group">
                <label for="numero_habitacion">Número de Habitación:</label>
                <input type="text" class="form-control" id="numero_habitacion" name="numero_habitacion" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
        <div class="mt-4 text-center">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>
