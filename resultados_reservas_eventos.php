<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_cliente = $_POST['nombre_cliente'];

    // Consulta SQL con doble JOIN para buscar reservas de eventos por nombre del cliente
    $stmt = $conn->prepare("
    SELECT re.reserva_evento_id, c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, e.nombre_evento, e.fecha_evento, re.cantidad, re.monto_total
    FROM reserva_evento re
    JOIN cliente c ON re.cliente_id = c.cliente_id
    JOIN evento e ON re.evento_id = e.evento_id
    WHERE c.nombre LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $nombre_cliente);
    $stmt->execute();
    $reservas_eventos = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda de Eventos</title>
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
        <h1 class="my-5 text-center">Resultados de Búsqueda de Eventos</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID de Reserva</th>
                    <th>Nombre Cliente</th>
                    <th>Apellido Cliente</th>
                    <th>Nombre del Evento</th>
                    <th>Fecha del Evento</th>
                    <th>Cantidad</th>
                    <th>Monto Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($reserva_evento = $reservas_eventos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($reserva_evento['reserva_evento_id']); ?></td>
                    <td><?php echo htmlspecialchars($reserva_evento['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($reserva_evento['apellido_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($reserva_evento['nombre_evento']); ?></td>
                    <td><?php echo htmlspecialchars($reserva_evento['fecha_evento']); ?></td>
                    <td><?php echo htmlspecialchars($reserva_evento['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($reserva_evento['monto_total']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mt-4 text-center">
            <a href="buscar_reservas_eventos.php" class="btn btn-secondary">Nueva Búsqueda</a>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Sistema de Gestión Hotelera</p>
    </footer>
</body>
</html>
