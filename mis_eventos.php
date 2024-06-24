<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

$cliente_id = $_SESSION['cliente_id'];

$stmt = $conn->prepare("
    SELECT re.reserva_evento_id, e.nombre_evento, e.fecha_evento, e.precio_evento, re.cantidad, re.monto_total
    FROM reserva_evento re
    JOIN evento e ON re.evento_id = e.evento_id
    WHERE re.cliente_id = ?
");
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$eventos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Eventos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Video de Fondo -->
    <video autoplay muted loop id="video-background">
        <source src="videos/background.mp4" type="video/mp4">
        Tu navegador no soporta la etiqueta de video.
    </video>

    <div class="container">
        <h1 class="my-5 text-center">Mis Eventos</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID de Reserva</th>
                    <th>Nombre del Evento</th>
                    <th>Fecha del Evento</th>
                    <th>Precio del Evento</th>
                    <th>Cantidad</th>
                    <th>Monto Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($evento = $eventos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($evento['reserva_evento_id']); ?></td>
                    <td><?php echo htmlspecialchars($evento['nombre_evento']); ?></td>
                    <td><?php echo htmlspecialchars($evento['fecha_evento']); ?></td>
                    <td><?php echo htmlspecialchars($evento['precio_evento']); ?></td>
                    <td><?php echo htmlspecialchars($evento['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($evento['monto_total']); ?></td>
                    <td>
                        <a href="cancelar_evento.php?id=<?php echo $evento['reserva_evento_id']; ?>" class="btn btn-danger btn-sm">Cancelar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mt-4 text-center">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>
