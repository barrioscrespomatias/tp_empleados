<?php
session_start();

var_dump($_SESSION['DNIEmpleado']);

/**
 * Si el empleado está cargado en session, entonces cerrá la sesión.
 * Si no está cargado, no se hace nada.
 */
 $DNIEmpleado = isset($_SESSION['DNIEmpleado']) ? $_SESSION['DNIEmpleado'] : null;
 if($DNIEmpleado!=null){
    session_unset();
    header('location: ../Front/loginPdo.html');
 }



?>