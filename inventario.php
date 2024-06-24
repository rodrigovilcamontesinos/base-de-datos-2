<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_articulo = $_POST['nombre_articulo'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $proveedor_id = $_POST['proveedor_id'];

    $stmt = $conn->prepare("INSERT INTO inventario (nombre_articulo, descripcion, cantidad, proveedor_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $nombre_articulo, $descripcion, $cantidad, $proveedor_id);

    if ($stmt->execute()) {
        $success_message = "Artículo añadido con éxito";
    } else {
        $error_message = "Error al añadir el artículo";
    }
}

$stmt_proveedores = $conn->prepare("SELECT * FROM proveedor");
$stmt_proveedores->execute();
$result_proveedores = $stmt_proveedores->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Inventario</title>
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
        <h1 class="my-5 text-center">Gestión de Inventario</h1>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="inventario.php" method="post">
            <div class="form-group">
                <label for="nombre_articulo">Nombre del Artículo:</label>
                <input type="text" class="form-control" name="nombre_articulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" class="form-control" name="cantidad" required>
            </div>
            <div class="form-group">
                <label for="proveedor_id">Proveedor:</label>
                <select class="form-control" name="proveedor_id" required>
                    <?php while ($row = $result_proveedores->fetch_assoc()): ?>
                    <option value="<?php echo $row['proveedor_id']; ?>"><?php echo htmlspecialchars($row['nombre_empresa']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Añadir Artículo</button>
        </form>
        <div class="mt-4 text-center">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
    <footer class="footer overlay">
        <p class="text-center">&copy; 2023 Sistema de Gestión Hotelera</p>
    </footer>
</body>
</html>
