<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

$stmt = $conn->prepare("
    SELECT evento_id, nombre_evento, fecha_evento, descripcion, nombre_organizador, contacto_organizador, precio_evento
    FROM evento
");
$stmt->execute();
$eventos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Eventos</title>
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

    <div class="container">
        <h1 class="my-5 text-center">Eventos Disponibles</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre del Evento</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Organizador</th>
                    <th>Contacto</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($evento = $eventos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($evento['nombre_evento']); ?></td>
                    <td><?php echo htmlspecialchars($evento['fecha_evento']); ?></td>
                    <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($evento['nombre_organizador']); ?></td>
                    <td><?php echo htmlspecialchars($evento['contacto_organizador']); ?></td>
                    <td><?php echo htmlspecialchars($evento['precio_evento']); ?></td>
                    <td>
                        <a href="reservar_evento.php?id=<?php echo $evento['evento_id']; ?>" class="btn btn-primary btn-sm">Reservar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="mt-4 text-center">
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Sistema de Gestión Hotelera</p>
    </footer>
</body>
</html>
