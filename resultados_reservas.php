<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_cliente = $_POST['nombre_cliente'];

    // Consulta SQL con doble JOIN para buscar reservas por nombre del cliente
    $stmt = $conn->prepare("
    SELECT r.reserva_id, c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, h.numero_habitacion, th.nombre_tipo, r.fecha_entrada, r.fecha_salida, r.monto_total
    FROM reserva r
    JOIN cliente c ON r.cliente_id = c.cliente_id
    JOIN habitacion h ON r.habitacion_id = h.habitacion_id
    JOIN tipo_habitacion th ON h.tipo_habitacion_id = th.tipo_habitacion_id
    WHERE c.nombre LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $nombre_cliente);
    $stmt->execute();
    $reservas = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda</title>
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
        <h1 class="my-5 text-center">Resultados de Búsqueda</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID de Reserva</th>
                    <th>Nombre Cliente</th>
                    <th>Apellido Cliente</th>
                    <th>Número de Habitación</th>
                    <th>Tipo de Habitación</th>
                    <th>Fecha de Entrada</th>
                    <th>Fecha de Salida</th>
                    <th>Monto Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($reserva = $reservas->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($reserva['reserva_id']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['apellido_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['numero_habitacion']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_tipo']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['fecha_entrada']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['fecha_salida']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['monto_total']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mt-4 text-center">
            <a href="buscar_reservas.php" class="btn btn-secondary">Nueva Búsqueda</a>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>
