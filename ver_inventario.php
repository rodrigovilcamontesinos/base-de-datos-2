<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

// Obtener la lista de artículos del inventario
$stmt = $conn->prepare("SELECT nombre_articulo, descripcion, cantidad FROM inventario");
$stmt->execute();
$inventario = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario Disponible</title>
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
        <h1 class="my-5 text-center">Inventario Disponible</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre del Artículo</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($articulo = $inventario->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($articulo['nombre_articulo']); ?></td>
                    <td><?php echo htmlspecialchars($articulo['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($articulo['cantidad']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mt-4 text-center">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
    <footer class="footer overlay">
        <p class="text-center">&copy; 2023 Sistema de Gestión Hotelera</p>
    </footer>
</body>
</html>
