<?php
session_start();

$DNIEmpleado = isset($_SESSION['DNIEmpleado']) ? $_SESSION['DNIEmpleado'] : "noEstaLogueado";
if($DNIEmpleado!="noEstaLogueado"){
    session_unset();
    header('location: ../Front/login.html');
}



?>