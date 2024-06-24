<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $habitacion_id = $_POST['habitacion_id'];
    $fecha_solicitud = $_POST['fecha_solicitud'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conn->prepare("INSERT INTO solicitud_mantenimiento (habitacion_id, fecha_solicitud, descripcion) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $habitacion_id, $fecha_solicitud, $descripcion);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Solicitud de mantenimiento añadida con éxito</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al añadir la solicitud de mantenimiento</div>";
    }
}

$stmt_habitaciones = $conn->prepare("SELECT * FROM habitacion");
$stmt_habitaciones->execute();
$result_habitaciones = $stmt_habitaciones->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Mantenimiento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="my-5">Gestión de Mantenimiento</h1>
        <form action="mantenimiento.php" method="post">
            <div class="form-group">
                <label for="habitacion_id">Habitación:</label>
                <select class="form-control" name="habitacion_id" required>
                    <?php while ($row = $result_habitaciones->fetch_assoc()): ?>
                    <option value="<?php echo $row['habitacion_id']; ?>"><?php echo htmlspecialchars($row['numero_habitacion']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_solicitud">Fecha de Solicitud:</label>
                <input type="date" class="form-control" name="fecha_solicitud" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Añadir Solicitud de Mantenimiento</button>
        </form>
    </div>
</body>
</html>
