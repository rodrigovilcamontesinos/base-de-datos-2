<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $habitacion_id = $_POST['habitacion_id'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];
    $user_id = $_SESSION['user_id'];

    // Verificar disponibilidad de la habitación
    $stmt = $conn->prepare("SELECT COUNT(*) FROM reserva WHERE habitacion_id = ? AND 
    ((fecha_entrada BETWEEN ? AND ?) OR (fecha_salida BETWEEN ? AND ?))");
    $stmt->bind_param("issss", $habitacion_id, $fecha_entrada, $fecha_salida, $fecha_entrada, $fecha_salida);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $error = "La habitación no está disponible en las fechas seleccionadas.";
    } else {
        // Obtener precio de la habitación
        $stmt = $conn->prepare("SELECT th.precio_por_noche FROM habitacion h 
        JOIN tipo_habitacion th ON h.tipo_habitacion_id = th.tipo_habitacion_id 
        WHERE h.habitacion_id = ?");
        $stmt->bind_param("i", $habitacion_id);
        $stmt->execute();
        $stmt->bind_result($precio_por_noche);
        $stmt->fetch();
        $stmt->close();

        $dias = (strtotime($fecha_salida) - strtotime($fecha_entrada)) / 86400;
        $monto_total = $dias * $precio_por_noche;

        // Insertar la reserva
        $stmt = $conn->prepare("INSERT INTO reserva (cliente_id, habitacion_id, fecha_entrada, fecha_salida, monto_total) 
        VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissd", $user_id, $habitacion_id, $fecha_entrada, $fecha_salida, $monto_total);

        if ($stmt->execute()) {
            // Actualizar el estado de la habitación a 'Ocupada'
            $stmt = $conn->prepare("UPDATE habitacion SET estado = 'Ocupada' WHERE habitacion_id = ?");
            $stmt->bind_param("i", $habitacion_id);
            $stmt->execute();

            header("Location: mis_reservas.php");
            exit();
        } else {
            $error = "Error al realizar la reserva.";
        }
    }
}

// Obtener habitaciones disponibles
$stmt = $conn->prepare("SELECT h.habitacion_id, h.numero_habitacion, th.nombre_tipo, h.piso 
FROM habitacion h 
JOIN tipo_habitacion th ON h.tipo_habitacion_id = th.tipo_habitacion_id 
WHERE h.estado = 'Disponible'");
$stmt->execute();
$habitaciones = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Habitación</title>
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
        <h1 class="my-5">Reservar Habitación</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="reserva.php" method="post">
            <div class="form-group">
                <label for="habitacion_id">Habitación:</label>
                <select class="form-control" name="habitacion_id" required>
                    <?php while ($habitacion = $habitaciones->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($habitacion['habitacion_id']); ?>">
                            <?php echo htmlspecialchars($habitacion['numero_habitacion'] . ' - ' . $habitacion['nombre_tipo'] . ' - Piso ' . $habitacion['piso']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_entrada">Fecha de Entrada:</label>
                <input type="date" class="form-control" name="fecha_entrada" required>
            </div>
            <div class="form-group">
                <label for="fecha_salida">Fecha de Salida:</label>
                <input type="date" class="form-control" name="fecha_salida" required>
            </div>
            <button type="submit" class="btn btn-primary">Reservar</button>
        </form>
        <div class="mt-4 text-center">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Sistema de Gestión Hotelera</p>
    </footer>
</body>
</html>
