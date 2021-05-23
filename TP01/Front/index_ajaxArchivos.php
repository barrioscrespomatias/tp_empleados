<?php

include_once '../Back/verificarUsuario.php';

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <script src="./javascript/validaciones.js"></script>
    <script src="./manejador_ajaxArchivos/manejador.js"></script>
    <title>Modificar el titulo</title>

</head>
    <body onload="ManejadorAjax.CargarPagina()">
        <div id="divAlta" style="width: 20%; display:inline"></div>
        <div id="divModificar" style="width: 20%; display:inline"></div>


        <div id="divTablaEmpleados" style="width: 70%; display:inline">
            <p>empleados</p>
        </div>
    </body>
    <footer>
        <a href="">Cerrar Sesión</a>
    </footer>
</html>