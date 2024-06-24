<?php
require 'includes/auth.php';
check_login();

if (!is_admin()) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Gestión Hotel</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="habitaciones.php">Gestión de Habitaciones</a></li>
                <li class="nav-item"><a class="nav-link" href="servicios.php">Gestión de Servicios</a></li>
                <li class="nav-item"><a class="nav-link" href="empleados.php">Gestión de Empleados</a></li>
                <li class="nav-item"><a class="nav-link" href="feedback.php">Retroalimentación</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="my-5">Panel de Administración</h1>
    </div>
</body>
</html>
