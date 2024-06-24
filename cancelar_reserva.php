<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reserva_id = $_POST['reserva_id'];

    // Obtener el ID de la habitación antes de eliminar la reserva
    $stmt = $conn->prepare("SELECT habitacion_id FROM reserva WHERE reserva_id = ?");
    $stmt->bind_param("i", $reserva_id);
    $stmt->execute();
    $stmt->bind_result($habitacion_id);
    $stmt->fetch();
    $stmt->close();

    // Eliminar pagos asociados a la reserva
    $stmt = $conn->prepare("DELETE FROM pago WHERE reserva_id = ?");
    $stmt->bind_param("i", $reserva_id);
    if (!$stmt->execute()) {
        $error = "Error al eliminar los pagos asociados a la reserva.";
    }
    $stmt->close();

    if (!isset($error)) {
        // Eliminar la reserva
        $stmt = $conn->prepare("DELETE FROM reserva WHERE reserva_id = ?");
        $stmt->bind_param("i", $reserva_id);
        if ($stmt->execute()) {
            // Actualizar el estado de la habitación a 'Disponible'
            $stmt = $conn->prepare("UPDATE habitacion SET estado = 'Disponible' WHERE habitacion_id = ?");
            $stmt->bind_param("i", $habitacion_id);
            $stmt->execute();
            $stmt->close();

            header("Location: mis_reservas.php");
            exit();
        } else {
            $error = "Error al cancelar la reserva.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cancelar Reserva</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="my-5">Cancelar Reserva</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="cancelar_reserva.php" method="post">
            <div class="form-group">
                <label for="reserva_id">ID de la Reserva:</label>
                <input type="text" class="form-control" name="reserva_id" required>
            </div>
            <button type="submit" class="btn btn-danger">Cancelar Reserva</button>
        </form>
        <div class="mt-4">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>
