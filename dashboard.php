<?php
require 'includes/auth.php';
check_login();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Video de Fondo -->
    <video autoplay muted loop id="video-background">
        <source src="videos/background.mp4" type="video/mp4">
        Tu navegador no soporta la etiqueta de video.
    </video>

    <div class="overlay">
        <header>
            <h1 class="text-center my-5">Bienvenido al Sistema de Gestión Hotelera</h1>
        </header>
        <div class="container">
            <div class="text-center">
                <img src="images/hotel.jpg" class="img-fluid mb-4" alt="Hotel" style="max-height: 300px;">
            </div>
            <div class="list-group">
                <a href="reserva.php" class="list-group-item list-group-item-action">Reservar Habitación</a>
                <a href="mis_reservas.php" class="list-group-item list-group-item-action">Mis Reservas</a>
                <a href="eventos.php" class="list-group-item list-group-item-action">Ver Eventos</a>
                <a href="mis_eventos.php" class="list-group-item list-group-item-action">Mis Eventos</a>
                <a href="proponer_evento.php" class="list-group-item list-group-item-action">Proponer Evento</a>
                <a href="empleados.php" class="list-group-item list-group-item-action">Lista de Empleados</a>
                <a href="calendar.php" class="list-group-item list-group-item-action">Calendario de Disponibilidad</a>
                <a href="ver_inventario.php" class="list-group-item list-group-item-action">Ver Inventario</a>
                <a href="buscar_reservas.php" class="list-group-item list-group-item-action">Buscar Reservas</a>
                <a href="buscar_reservas_eventos.php" class="list-group-item list-group-item-action">Buscar Reservas de Eventos</a>
                <a href="buscar_servicios_cliente.php" class="list-group-item list-group-item-action">Buscar Servicios Utilizados</a>
                <a href="buscar_historial_precios.php" class="list-group-item list-group-item-action">Buscar Historial de Precios</a>
                <a href="buscar_actividades_cliente.php" class="list-group-item list-group-item-action">Buscar Actividades del Cliente</a>
                <a href="update_profile.php" class="list-group-item list-group-item-action">Actualizar Perfil</a>
                <a href="logout.php" class="list-group-item list-group-item-action">Cerrar Sesión</a>
            </div>
        </div>
        <footer class="footer">
            <p>&copy; 2023 Sistema de Gestión Hotelera</p>
        </footer>
    </div>
</body>
</html>
