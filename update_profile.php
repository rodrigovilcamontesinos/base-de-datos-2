<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    
    $stmt = $conn->prepare("UPDATE cliente SET nombre = ?, apellido = ?, telefono = ?, direccion = ? WHERE cliente_id = ?");
    $stmt->bind_param("ssssi", $nombre, $apellido, $telefono, $direccion, $user_id);
    
    if ($stmt->execute()) {
        $message = "Perfil actualizado con éxito.";
    } else {
        $error = "Error al actualizar el perfil.";
    }
}

// Obtener datos actuales del perfil
$stmt = $conn->prepare("SELECT nombre, apellido, telefono, direccion FROM cliente WHERE cliente_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nombre, $apellido, $telefono, $direccion);
$stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Perfil</title>
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
        <h1 class="my-5 text-center">Actualizar Perfil</h1>
        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="update_profile.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($direccion); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
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
