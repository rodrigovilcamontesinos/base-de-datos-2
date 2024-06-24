<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

$stmt_ingresos = $conn->prepare("SELECT SUM(monto_total) AS ingresos FROM reserva WHERE estado = 'Confirmada'");
$stmt_ingresos->execute();
$result_ingresos = $stmt_ingresos->get_result();
$ingresos = $result_ingresos->fetch_assoc()['ingresos'];

$stmt_reservas = $conn->prepare("SELECT COUNT(*) AS total_reservas FROM reserva");
$stmt_reservas->execute();
$result_reservas = $stmt_reservas->get_result();
$total_reservas = $result_reservas->fetch_assoc()['total_reservas'];

$stmt_servicios = $conn->prepare("SELECT COUNT(*) AS total_servicios FROM servicio_cliente");
$stmt_servicios->execute();
$result_servicios = $stmt_servicios->get_result();
$total_servicios = $result_servicios->fetch_assoc()['total_servicios'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="my-5">Informes Financieros y Operativos</h1>
        <h2>Ingresos</h2>
        <p>Total de ingresos: $<?php echo number_format($ingresos, 2); ?></p>

        <h2>Reservas</h2>
        <p>Total de reservas: <?php echo $total_reservas; ?></p>

        <h2>Servicios Utilizados</h2>
        <p>Total de servicios utilizados: <?php echo $total_servicios; ?></p>
    </div>
</body>
</html>
