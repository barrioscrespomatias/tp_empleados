<?php

include_once './entidades/empleado.php';
include_once './entidades/fabrica.php';
include_once 'validarSesion.php';


$path = "./archivos/empleados.txt";
$archivo = fopen($path, "r");
$listaEmpleados = array();

while (!feof($archivo)) {
    $lineaDeArchivo = fgets($archivo);
    $persona = explode("-", $lineaDeArchivo);

    if ($persona[0] != NULL && $persona[1] != NULL && $persona[2] != NULL && $persona[3] != NULL && $persona[4] != NULL && $persona[5] != NULL && $persona[6] != NULL) {
        $empleado = new Empleado($persona[0], $persona[1], $persona[2], $persona[3], $persona[4], $persona[5], $persona[6]);
        array_push($listaEmpleados, $empleado);
    }
}

$fabrica = new Fabrica("La fabrica");
$fabrica->SetCantidadMaxima(7);
$fabrica->TraerDeArchivo("./archivos/empleados.txt");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../Front/javascript/funciones.js"></script>
    <title>Document</title>
</head>

<body>
<div class="container">
    <h2>Listado de empleados</h2>
    <table align="center">
        <thead>
        <th colspan="12">
            <h4>Info</h4>
        </th>
        </thead>
        <tr>
            <td colspan="12">
                <hr/>
            </td>
        </tr>
        <?php foreach ($fabrica->GetEmpleados() as $unEmpleado) { ?>
            <tr>
                <td colspan="3">
                    <?= $unEmpleado->ToString() ?>
                </td>
                <td colspan="3">
                    <img src='<?= $unEmpleado->GetPathFoto() ?>' alt="fotoEmpleado" width="90px" height="90px">
                </td>
                <td colspan="3">
                    <a href='eliminar.php?legajo=<?= $unEmpleado->GetLegajo() ?>&nombre=<?php echo $unEmpleado->GetNombre() ?>&pathFoto=<?php echo $unEmpleado->GetPathFoto() ?>'
                       name='delete'>Eliminar</a>
                </td>
                <td colspan="3">
                    <input type="button" value="Modificar"
                           onclick="AdministrarModificar('<?= $unEmpleado->GetDni() ?>')">
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="12">
                <hr/>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <a href='../Front/index.html'>
                    <h2>Alta de empleados</h2>
                </a>
            </td>
            <td colspan="6">
                <a href="cerrarSesion.php">
                    <h2>Cerrar sesión</h2>
                </a>
            </td>
        </tr>
    </table>

    <form action='../Front/index.php' method='POST' id="formularioHidden">
        <table>
            <tr>
                <td>
                    <input type="hidden" id="inputHidden" name="inputHidden">
                </td>
            </tr>
        </table>
    </form>
</div>
</body>

</html>