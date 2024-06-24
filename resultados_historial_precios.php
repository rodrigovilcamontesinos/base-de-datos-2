<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero_habitacion = $_POST['numero_habitacion'];

    // Consulta SQL ajustada para buscar historial de precios por número de habitación
    $stmt = $conn->prepare("
    SELECT hph.historial_id, h.numero_habitacion, th.nombre_tipo, hph.precio_anterior, hph.precio_nuevo, hph.fecha_cambio
    FROM historial_precio_habitacion hph
    JOIN habitacion h ON hph.habitacion_id = h.habitacion_id
    JOIN tipo_habitacion th ON h.tipo_habitacion_id = th.tipo_habitacion_id
    WHERE h.numero_habitacion = ?
    ORDER BY hph.fecha_cambio DESC");
    $stmt->bind_param("s", $numero_habitacion);
    $stmt->execute();
    $historial_precios = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda de Historial de Precios</title>
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

    <div class="container overlay">
        <h1 class="my-5 text-center">Resultados de Búsqueda de Historial de Precios</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID del Historial</th>
                    <th>Número de Habitación</th>
                    <th>Tipo de Habitación</th>
                    <th>Precio Anterior</th>
                    <th>Precio Nuevo</th>
                    <th>Fecha de Cambio</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($historial_precio = $historial_precios->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($historial_precio['historial_id']); ?></td>
                    <td><?php echo htmlspecialchars($historial_precio['numero_habitacion']); ?></td>
                    <td><?php echo htmlspecialchars($historial_precio['nombre_tipo']); ?></td>
                    <td><?php echo htmlspecialchars($historial_precio['precio_anterior']); ?></td>
                    <td><?php echo htmlspecialchars($historial_precio['precio_nuevo']); ?></td>
                    <td><?php echo htmlspecialchars($historial_precio['fecha_cambio']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mt-4 text-center">
            <a href="buscar_historial_precios.php" class="btn btn-secondary">Nueva Búsqueda</a>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>
