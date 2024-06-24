<?php
session_start();

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function check_admin() {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'Administrador') {
        header("Location: login.php");
        exit();
    }
}
?>
