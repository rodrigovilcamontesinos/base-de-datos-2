<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_cliente = $_POST['nombre_cliente'];

    // Consulta SQL con doble JOIN para buscar servicios utilizados por nombre del cliente
    $stmt = $conn->prepare("
    SELECT sc.servicio_cliente_id, c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, s.nombre_servicio, r.fecha_entrada, r.fecha_salida, sc.fecha_servicio, sc.cantidad, sc.precio_total
    FROM servicio_cliente sc
    JOIN cliente c ON sc.cliente_id = c.cliente_id
    JOIN servicio s ON sc.servicio_id = s.servicio_id
    JOIN reserva r ON sc.reserva_id = r.reserva_id
    WHERE c.nombre LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $nombre_cliente);
    $stmt->execute();
    $servicios_cliente = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda de Servicios</title>
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
        <h1 class="my-5 text-center">Resultados de Búsqueda de Servicios</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID de Servicio</th>
                    <th>Nombre Cliente</th>
                    <th>Apellido Cliente</th>
                    <th>Nombre del Servicio</th>
                    <th>Fecha de Entrada</th>
                    <th>Fecha de Salida</th>
                    <th>Fecha del Servicio</th>
                    <th>Cantidad</th>
                    <th>Precio Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($servicio_cliente = $servicios_cliente->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($servicio_cliente['servicio_cliente_id']); ?></td>
                    <td><?php echo htmlspecialchars($servicio_cliente['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($servicio_cliente['apellido_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($servicio_cliente['nombre_servicio']); ?></td>
                    <td><?php echo htmlspecialchars($servicio_cliente['fecha_entrada']); ?></td>
                    <td><?php echo htmlspecialchars($servicio_cliente['fecha_salida']); ?></td>
                    <td><?php echo htmlspecialchars($servicio_cliente['fecha_servicio']); ?></td>
                    <td><?php echo htmlspecialchars($servicio_cliente['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($servicio_cliente['precio_total']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mt-4 text-center">
            <a href="buscar_servicios_cliente.php" class="btn btn-secondary">Nueva Búsqueda</a>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>
