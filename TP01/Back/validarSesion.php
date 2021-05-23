<?php
session_start();

$sesionDNIEmpleado = isset($_SESSION['DNIEmpleado']) ? $_SESSION['DNIEmpleado'] : null;
if($sesionDNIEmpleado == null)
    header('location: ../Front/login.html');

?>