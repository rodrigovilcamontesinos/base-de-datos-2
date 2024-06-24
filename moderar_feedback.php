<?php
require 'includes/auth.php';
check_login();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $retroalimentacion_id = $_POST['retroalimentacion_id'];
    $accion = $_POST['accion'];

    if ($accion === 'aprobar') {
        $stmt = $conn->prepare("UPDATE retroalimentacion SET moderado = 1 WHERE retroalimentacion_id = ?");
        $stmt->bind_param("i", $retroalimentacion_id);
    } elseif ($accion === 'rechazar') {
        $stmt = $conn->prepare("DELETE FROM retroalimentacion WHERE retroalimentacion_id = ?");
        $stmt->bind_param("i", $retroalimentacion_id);
    }

    if ($stmt->execute()) {
        header("Location: feedback.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error al moderar el feedback</div>";
    }
}
?>
