<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_servicio = $_POST['nombre_servicio'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    $stmt = $conn->prepare("INSERT INTO servicio (nombre_servicio, descripcion, precio) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nombre_servicio, $descripcion, $precio);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Servicio añadido con éxito</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al añadir el servicio</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Servicios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="my-5">Gestión de Servicios</h1>
        <form action="servicios.php" method="post">
            <div class="form-group">
                <label for="nombre_servicio">Nombre del Servicio:</label>
                <input type="text" class="form-control" name="nombre_servicio" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" class="form-control" name="precio" required>
            </div>
            <button type="submit" class="btn btn-primary">Añadir Servicio</button>
        </form>
    </div>
</body>
</html>
