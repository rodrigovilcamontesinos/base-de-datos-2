<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reserva_evento_id = $_POST['reserva_evento_id'];

    // Eliminar la reserva del evento
    $stmt = $conn->prepare("DELETE FROM reserva_evento WHERE reserva_evento_id = ?");
    $stmt->bind_param("i", $reserva_evento_id);

    if ($stmt->execute()) {
        $message = "Inscripción al evento cancelada con éxito.";
    } else {
        $error = "Error al cancelar la inscripción al evento.";
    }
}
header("Location: mis_eventos.php");
exit();
?>
