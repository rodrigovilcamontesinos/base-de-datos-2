<?php
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    // Verificar si el usuario es mayor de 18 años
    $fecha_actual = new DateTime();
    $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);
    $edad = $fecha_actual->diff($fecha_nacimiento_dt)->y;

    if ($edad < 18) {
        $error = "Debes tener al menos 18 años para registrarte.";
    } else {
        $stmt = $conn->prepare("INSERT INTO cliente (nombre, apellido, email, telefono, direccion, fecha_nacimiento, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nombre, $apellido, $email, $telefono, $direccion, $fecha_nacimiento, $contrasena);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
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

    <header class="overlay">
        <h1 class="text-center">Registro de Usuario</h1>
    </header>
    <div class="container overlay">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" class="form-control" name="contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
        </form>
        <div class="mt-4 text-center">
            <a href="login.php" class="btn btn-secondary">¿Ya tienes una cuenta? Inicia Sesión</a>
        </div>
    </div>
</body>
</html>
