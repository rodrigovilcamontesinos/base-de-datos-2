<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_cliente = $_POST['nombre_cliente'];

    // Consulta SQL con doble JOIN para buscar actividades por nombre del cliente
    $stmt = $conn->prepare("
    SELECT ra.reserva_actividad_id, c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, a.nombre_actividad, a.fecha_actividad, ra.cantidad, ra.monto_total
    FROM reserva_actividad ra
    JOIN cliente c ON ra.cliente_id = c.cliente_id
    JOIN actividad a ON ra.actividad_id = a.actividad_id
    WHERE c.nombre LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $nombre_cliente);
    $stmt->execute();
    $actividades_cliente = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda de Actividades</title>
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
        <h1 class="my-5 text-center">Resultados de Búsqueda de Actividades</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID de Actividad</th>
                    <th>Nombre Cliente</th>
                    <th>Apellido Cliente</th>
                    <th>Nombre de la Actividad</th>
                    <th>Fecha de la Actividad</th>
                    <th>Cantidad</th>
                    <th>Monto Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($actividad_cliente = $actividades_cliente->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($actividad_cliente['reserva_actividad_id']); ?></td>
                    <td><?php echo htmlspecialchars($actividad_cliente['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($actividad_cliente['apellido_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($actividad_cliente['nombre_actividad']); ?></td>
                    <td><?php echo htmlspecialchars($actividad_cliente['fecha_actividad']); ?></td>
                    <td><?php echo htmlspecialchars($actividad_cliente['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($actividad_cliente['monto_total']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mt-4 text-center">
            <a href="buscar_actividades_cliente.php" class="btn btn-secondary">Nueva Búsqueda</a>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>
