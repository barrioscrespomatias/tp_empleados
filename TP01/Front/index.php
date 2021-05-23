<?php

include_once '../Back/verificarUsuario.php';
include_once '../Back/entidades/fabrica.php';
include_once '../Back/entidades/empleado.php';


$valorDniEmpleado = isset($_POST['inputHidden']) ? $_POST["inputHidden"] : null;
$pathArchivo = '../Back/archivos/empleados.txt';

$empleadoAuxiliar = new Empleado();
$indice = null;

$fabrica = new Fabrica("La fabriquita");
$fabrica->SetCantidadMaxima = 7;
$fabrica->TraerDeArchivo($pathArchivo);

if ($valorDniEmpleado != null) {
    $indice = IndiceEmpleado($fabrica, $valorDniEmpleado);
}

if ($indice != null) {
    $arrayEmpleados = $fabrica->GetEmpleados();
    $empleadoAuxiliar = $arrayEmpleados[$indice];

}

$tituloPagina = "Alta empleados";
$dni = "";
$apellido = "";
$nombre = "";
$sexo = "";
$legajo = "";
$sueldo = "";
$turno = "";
$foto = "";
$btnEnviar = "Enviar";


if (isset($valorDniEmpleado)) {
    $tituloPagina = "Modificar empleado";
    $dni = $empleadoAuxiliar->GetDni();
    $apellido = $empleadoAuxiliar->GetApellido();
    $nombre = $empleadoAuxiliar->GetNombre();
    $sexo = $empleadoAuxiliar->GetSexo();
    $legajo = $empleadoAuxiliar->GetLegajo();
    $sueldo = $empleadoAuxiliar->GetSueldo();
    $turno = $empleadoAuxiliar->GetTurno();
    $foto = $empleadoAuxiliar->GetPathFoto();
    $btnEnviar = "Modificar";
}


function IndiceEmpleado($fabrica, $dniEmpleado): int
{
    $contador = 0;
    foreach ($fabrica->GetEmpleados() as $item) {
        if ($item->GetDni() == $dniEmpleado) {
            $indiceEmpleado = $contador;
            break;
        }
        $contador++;
    }
    return $indiceEmpleado;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <script src="./javascript/validaciones.js"></script>
    <title><?= $tituloPagina ?></title>

</head>


<body>
<div class="container">

    <h2><?= $tituloPagina ?></h2>
    <form action='../Back/administracion.php' method="POST" enctype="multipart/form-data"
          onsubmit="return AdministrarValidaciones()">
        <!-- <form method="POST" enctype="multipart/form-data" onsubmit="return AdministrarValidaciones()">  -->
        <table align="center">
            <thead>
            <td colspan="12">
                <h4>Datos Personales</h4>
            </td>
            </thead>
            <tbody>
            <tr>
                <td colspan="12">
                    <hr/>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <label for="txtDni">DNI:</label>
                </td>
                <td colspan="6">
                    <input type="number" name="txtDni" id="txtDni" max="55000000" min="1000000"
                           value="<?= $dni ?>">
                    <span style="display: none;" id="txtDniError">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <label for="txtApellido">Apellido:</label>
                </td>
                <td colspan="3">
                    <input type="text" name="txtApellido" id="txtApellido"
                           value="<?= $apellido ?>">
                    <span style="display: none;" id="txtApellidoError">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <label for="txtNombre">Nombre:</label>
                </td>
                <td colspan="3">
                    <input type="text" name="txtNombre" id="txtNombre" value="<?= $nombre ?>">
                    <span style="display: none;" id="txtNombreError">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <label for="cboSexo">Sexo:</label>
                </td>
                <td colspan="6">
                    <select name="cboSexo" id="cboSexo">
                        <option value="---">Seleccione</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                    <span style="display: none;" id="cboSexoError">*</span>
                </td>

            </tr>
            <tr>
                <th colspan="12">
                    <h4>Datos Laborales</h4>
                </th>
            </tr>
            <tr>
                <td colspan="12">
                    <hr/>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <label for="txtLegajo">Legajo:</label>
                </td>
                <td colspan="3">
                    <input type="number" id="txtLegajo" name="txtLegajo" min="100" max="550"
                           value="<?= $legajo ?>">
                    <span style="display: none;" id="txtLegajoError">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <label for="txtSueldo">Sueldo:</label>
                </td>
                <td colspan="6">
                    <input type="number" name="txtSueldo" id="txtSueldo" min="8000" max="25000" step="500"
                           value="<?= $sueldo ?>">
                    <span style="display: none;" id="txtSueldoError">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="12 ">
                    <label for="rdoTurno">Turno:</label>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right">
                    <input type="radio" name="rdoTurno" value="Mañana" id="" checked>
                </td>
                <td colspan="9">
                    <label for="rdoTurno">Mañana</label>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right">
                    <input type="radio" value="Tarde" name="rdoTurno" id="">
                </td>
                <td colspan="9">
                    <label for="rdoTurno">Tarde</label>
                </td>

            </tr>
            <tr>
                <td colspan="3" align="right">
                    <input type="radio" value="Noche" name="rdoTurno" id="">

                </td>
                <td colspan="9">
                    <label for="rdoTurno">Noche</label>
                </td>

            </tr>
            <tr>
                <td colspan="3">
                    <label for="txtFoto">Foto:</label>
                </td>
                <td colspan="6">
                    <input type="file" name="txtFoto" id="txtFoto" value="<?= $foto ?>">
                    <span style="display: none;" id="txtFotoError">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <hr/>
                </td>
            </tr>
            <tr>
                <td colspan="12" id="btnLimpiar">
                    <input type="reset" name="btnLimpiar" value="Limpiar">
                </td>
            </tr>
            <tr>
                <td colspan="12" id="btnEnviar">
                    <input type="submit" name="btnEnviar" id="" value="<?= $btnEnviar ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="hdnModificar" value="<?= $dni ?>">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
</body>

</html>