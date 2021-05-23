<?php
require_once '../Back/verificarUsuarioPdo.php';
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./javascript/validaciones.js"></script>
    <script src="./manejador_ajaxPdo/manejador.js"></script>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <title>Modificar el titulo</title>

</head>

<body onload="ManejadorAjax.RecargarPagina()">
<div id="container" >

    <div id="divAlta" ></div>

    <div id="divModificar" ></div>

    <div id="divTablaEmpleados">
        <p></p>
    </div>
    <div id="divPdf">
        <a href="../Front/indexToPdf.php">Mostrar empleados en PDF</a>
    </div>
</div>



</body>
<footer>
    <a href="../Back/cerrarSesionPdo.php"><h2>Cerrar Sesión</h2></a>
</footer>
</html>