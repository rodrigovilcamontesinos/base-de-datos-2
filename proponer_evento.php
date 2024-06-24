<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_evento = $_POST['nombre_evento'];
    $fecha_evento = $_POST['fecha_evento'];
    $descripcion = $_POST['descripcion'];
    $nombre_organizador = $_POST['nombre_organizador'];
    $contacto_organizador = $_POST['contacto_organizador'];
    $precio_evento = $_POST['precio_evento'];

    $stmt = $conn->prepare("INSERT INTO evento (nombre_evento, fecha_evento, descripcion, nombre_organizador, contacto_organizador, precio_evento) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssd", $nombre_evento, $fecha_evento, $descripcion, $nombre_organizador, $contacto_organizador, $precio_evento);
    $stmt->execute();

    echo "Evento propuesto con éxito.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proponer Evento</title>
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
        <h1 class="my-5 text-center">Proponer Evento</h1>
        <form action="proponer_evento.php" method="post">
            <div class="form-group">
                <label for="nombre_evento">Nombre del Evento:</label>
                <input type="text" class="form-control" id="nombre_evento" name="nombre_evento" required>
            </div>
            <div class="form-group">
                <label for="fecha_evento">Fecha del Evento:</label>
                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="nombre_organizador">Nombre del Organizador:</label>
                <input type="text" class="form-control" id="nombre_organizador" name="nombre_organizador" required>
            </div>
            <div class="form-group">
                <label for="contacto_organizador">Contacto del Organizador:</label>
                <input type="text" class="form-control" id="contacto_organizador" name="contacto_organizador" required>
            </div>
            <div class="form-group">
                <label for="precio_evento">Precio del Evento:</label>
                <input type="number" class="form-control" id="precio_evento" name="precio_evento" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Proponer</button>
                <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>
