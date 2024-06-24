<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_SESSION['user_id'];
    $actividad_id = $_POST['actividad_id'];
    $fecha_reserva = $_POST['fecha_reserva'];
    $cantidad = $_POST['cantidad'];
    $monto_total = $_POST['monto_total'];

    // Comprobar que el actividad_id existe en la tabla actividad
    $stmt = $conn->prepare("SELECT actividad_id FROM actividad WHERE actividad_id = ?");
    $stmt->bind_param("i", $actividad_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si la actividad existe, proceder con la inserción de la reserva
        $stmt = $conn->prepare("INSERT INTO reserva_actividad (cliente_id, actividad_id, fecha_reserva, cantidad, monto_total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissi", $cliente_id, $actividad_id, $fecha_reserva, $cantidad, $monto_total);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Actividad reservada con éxito</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al reservar la actividad</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>La actividad seleccionada no existe</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Actividad</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="my-5">Reservar Actividad</h1>
        <form action="reserva_actividad.php" method="post">
            <div class="form-group">
                <label for="actividad_id">ID de Actividad:</label>
                <input type="text" class="form-control" name="actividad_id" required>
            </div>
            <div class="form-group">
                <label for="fecha_reserva">Fecha de Reserva:</label>
                <input type="date" class="form-control" name="fecha_reserva" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" class="form-control" name="cantidad" required>
            </div>
            <div class="form-group">
                <label for="monto_total">Monto Total:</label>
                <input type="number" step="0.01" class="form-control" name="monto_total" required>
            </div>
            <button type="submit" class="btn btn-primary">Reservar</button>
        </form>
        <div class="mt-4">
            <a href="reserva_actividad.php" class="btn btn-secondary">Reservar Otra Actividad</a>
            <a href="reserva.php" class="btn btn-secondary">Reservar Habitación</a>
            <a href="empleados.php" class="btn btn-secondary">Ver Información de Empleados</a>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>
