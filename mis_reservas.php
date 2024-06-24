<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

$user_id = $_SESSION['user_id'];

// Obtener las reservas del usuario
$stmt = $conn->prepare("SELECT reserva.reserva_id, reserva.fecha_entrada, reserva.fecha_salida, reserva.monto_total, pago.pago_id, pago.metodo_pago, pago.fecha_pago FROM reserva LEFT JOIN pago ON reserva.reserva_id = pago.reserva_id WHERE reserva.cliente_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$reservas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
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
        <h1 class="my-5 text-center">Mis Reservas</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID de Reserva</th>
                    <th>Fecha de Entrada</th>
                    <th>Fecha de Salida</th>
                    <th>Monto Total</th>
                    <th>Estado de Pago</th>
                    <th>Método de Pago</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($reserva = $reservas->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($reserva['reserva_id']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['fecha_entrada']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['fecha_salida']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['monto_total']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['pago_id'] ? 'Pagado' : 'Pendiente'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['metodo_pago'] ?? 'N/A'); ?></td>
                    <td>
                        <?php if (!$reserva['pago_id']): ?>
                        <form action="pagar_reserva.php" method="post" class="d-inline-block">
                            <input type="hidden" name="reserva_id" value="<?php echo htmlspecialchars($reserva['reserva_id']); ?>">
                            <button type="submit" class="btn btn-success btn-sm">Pagar</button>
                        </form>
                        <?php endif; ?>
                        <form action="cancelar_reserva.php" method="post" class="d-inline-block">
                            <input type="hidden" name="reserva_id" value="<?php echo htmlspecialchars($reserva['reserva_id']); ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                        </form>
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
