<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_SESSION['user_id'];
    $calificacion = $_POST['calificacion'];
    $comentarios = $_POST['comentarios'];

    $stmt = $conn->prepare("INSERT INTO retroalimentacion (cliente_id, fecha_retroalimentacion, calificacion, comentarios) VALUES (?, NOW(), ?, ?)");
    $stmt->bind_param("iis", $cliente_id, $calificacion, $comentarios);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Gracias por tu feedback</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al enviar el feedback</div>";
    }
}

// Mostrar feedback pendiente de moderación
$stmt = $conn->prepare("SELECT r.retroalimentacion_id, c.nombre, r.calificacion, r.comentarios, r.fecha_retroalimentacion FROM retroalimentacion r JOIN cliente c ON r.cliente_id = c.cliente_id WHERE r.moderado = 0");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Retroalimentación</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="my-5">Deja tu Feedback</h1>
        <form action="feedback.php" method="post">
            <div class="form-group">
                <label for="calificacion">Calificación (1-5):</label>
                <input type="number" class="form-control" name="calificacion" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="comentarios">Comentarios:</label>
                <textarea class="form-control" name="comentarios" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <h2 class="my-5">Comentarios Pendientes de Moderación</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Calificación</th>
                    <th>Comentarios</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['calificacion']); ?></td>
                    <td><?php echo htmlspecialchars($row['comentarios']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_retroalimentacion']); ?></td>
                    <td>
                        <form action="moderar_feedback.php" method="post" style="display:inline;">
                            <input type="hidden" name="retroalimentacion_id" value="<?php echo $row['retroalimentacion_id']; ?>">
                            <button type="submit" name="accion" value="aprobar" class="btn btn-success btn-sm">Aprobar</button>
                            <button type="submit" name="accion" value="rechazar" class="btn btn-danger btn-sm">Rechazar</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
