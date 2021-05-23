<?php
session_start();

include_once '../entidades/empleado.php';
include_once '../entidades/fabrica.php';

//region DatosEmpleado

$nombre = isset($_POST["txtNombre"]) ? $_POST["txtNombre"] : "Error";
$apellido = isset($_POST["txtApellido"]) ? $_POST["txtApellido"] : "Error";
$dni = isset($_POST["txtDni"]) ? $_POST["txtDni"] : "Error";
$sexo = isset($_POST["cboSexo"]) ? $_POST["cboSexo"] : "Error";
$legajo = isset($_POST["txtLegajo"]) ? $_POST["txtLegajo"] : "Error";
$sueldo = isset($_POST["txtSueldo"]) ? $_POST["txtSueldo"] : "Error";
$turno = isset($_POST["rdoTurno"]) ? $_POST["rdoTurno"] : "Error";
//endregion

//region DatosFile
$nombreFoto = isset($_FILES['txtFoto']['name']) ? $_FILES['txtFoto']['name'] : null;
$tamanioFoto = isset($_FILES['txtFoto']['size']) ? $_FILES['txtFoto']['size'] : null;
$tmpNameFoto = isset($_FILES['txtFoto']['tmp_name']) ? $_FILES['txtFoto']['tmp_name'] : null;
if (isset($nombreFoto)) {
    $array = explode(".", $_FILES['txtFoto']['name']);
    $extension = end($array);
    $destino = "../fotos/" . $dni . "-" . $apellido . "." . $extension;
    $pathFoto = $dni . "-" . $apellido . "." . $extension;
    $nombreFotoSinExtension = pathinfo($nombreFoto, PATHINFO_FILENAME);
}
//endregion

$btnEnviar = isset($_POST["btnEnviar"]) ? $_POST["btnEnviar"] : "Error";

$dniEmpleadoModificado = isset($_POST["hdnModificar"]) ? $_POST["hdnModificar"] : "Error";
$path = '../archivos/empleados.txt';

//Instancia fábrica, se actualiza desde el archivo de texto.
$fabrica = new Fabrica("La fabrica");
$fabrica->SetCantidadMaxima(7);


switch ($btnEnviar) {

    case 'Enviar':

        //Guardar la foto // Corrobora que el nombre exista y que el tamaño sea un numero.
        //Si es false no ingresa.
        if ($nombreFoto && $tamanioFoto)
            GuardarFoto($nombreFoto, $extension, $tamanioFoto, $tmpNameFoto, $destino, $nombreFotoSinExtension);

        if ($nombre) {
            $empleado = new Empleado($nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno);
            $empleado->SetPathFoto($pathFoto);
            // ---------------------------------Cargar la fábrica--------------------------
            $fabrica->TraerDeArchivo($path);
            // ---------------------------------Agregar nuevo empleado----------------------
            if ($fabrica->AgregarEmpleado($empleado)) {
                $fabrica->GuardarEnArchivo($path);

                //Traer tabla desde el archivo.
                $tabla = $fabrica->GenerarTabla();
                echo $tabla;
            }
        }
        break;

    case 'Modificar':
        // ---------------------------------Cargar la fábrica--------------------------
        $fabrica->TraerDeArchivo($path);
        // ---------------------------------Buscar el empleado--------------------------
        $empleadoModificado = BuscarEmpleado($fabrica, $dni);

        // ---------------------------------Path a eliminar--------------------------
        $pathFotoEliminada = $empleadoModificado->GetPathFoto();
        //Trim por problemas de espacio, que coincida la el path.
        $pathFotoEliminada = trim($pathFotoEliminada);
        unlink($pathFotoEliminada);

        // ----------------------------Eliminar y reemplzar empleado-----------------------
        if ($fabrica->EliminarEmpleado($empleadoModificado)) {

            $nuevoEmpleado = new Empleado($nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno);
            $nuevoEmpleado->SetPathFoto($pathFoto);
            if ($fabrica->AgregarEmpleado($nuevoEmpleado)) {
                $fabrica->GuardarEnArchivo($path);
                //Tananio foto retorna false SINO es una imagen.
                if ($nombreFoto && $tamanioFoto)
                    $fotoGuardada = GuardarFoto($nombreFoto, $extension, $tamanioFoto, $tmpNameFoto, $destino, $nombreFotoSinExtension);
            }
        }

        break;

    case  'EnviarEmpleados':
        $fabrica->TraerDeArchivo($path);
        echo $fabrica->GenerarTabla();
        break;

    case 'GenerarFormularioAltaModificar':
        echo GenerarFormularioHtml();
        break;

}


function GenerarFormularioHtml()
{
    $valorDniEmpleado = isset($_POST["inputHidden"]) ? $_POST["inputHidden"] : null;
    $pathArchivo = '../archivos/empleados.txt';

    $empleadoAuxiliar = new Empleado();
    $indice = null;

    $fabrica = new Fabrica("La fabriquita");
    $fabrica->SetCantidadMaxima = 7;
    $fabrica->TraerDeArchivo($pathArchivo);

    if (isset($valorDniEmpleado)) {

        $indice = IndiceEmpleado($fabrica, $valorDniEmpleado);
        if ($indice !== null) {
            $arrayEmpleados = $fabrica->GetEmpleados();
            $empleadoAuxiliar = $arrayEmpleados[$indice];
        }
    }

    $tituloPagina = "Alta empleados";
    $btnEnviar = "Enviar";
    $nombre = "";
    $apellido = "";
    $dni = "";
    $sexo = "";
    $legajo = "";
    $sueldo = "";
    $turno = "";
    $pathFoto = "";
    $manejadora = 'ManejadorAjax.AgregarEmpleado()';

    if (isset($valorDniEmpleado)) {
        $tituloPagina = "Modificar empleado";
        $btnEnviar = "Modificar";
        $nombre = $empleadoAuxiliar->GetNombre();
        $apellido = $empleadoAuxiliar->GetApellido();
        $dni = $empleadoAuxiliar->GetDni();
        $sexo = $empleadoAuxiliar->GetSexo();
        $legajo = $empleadoAuxiliar->GetLegajo();
        $sueldo = $empleadoAuxiliar->GetSueldo();
        $turno = $empleadoAuxiliar->GetTurno();
        $pathFoto = $empleadoAuxiliar->GetPathFoto();
        $manejadora = 'ManejadorAjax.Modificar()';
    }

    //region Formulario HTML
    $formulario = "";
    $formulario .= '
        <h2><' . $tituloPagina . '></h2>
        <table align="left">
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
                   value=' . $empleadoAuxiliar->GetDni() . '>
            <span style="display: none;" id="txtDniError">*</span>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <label for="txtApellido">Apellido:</label>
        </td>
        <td colspan="3">
            <input type="text" name="txtApellido" id="txtApellido"
                   value=' . $empleadoAuxiliar->GetApellido() . '>
            <span style="display: none;" id="txtApellidoError">*</span>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <label for="txtNombre">Nombre:</label>
        </td>
        <td colspan="3">
            <input type="text" name="txtNombre" id="txtNombre" value=' . $empleadoAuxiliar->GetNombre() . '>
            <span style="display: none;" id="txtNombreError">*</span>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <label for="cboSexo">Sexo:</label>
        </td>
        <td colspan="6">
            <select name="cboSexo" id="cboSexo" value="<?= $sexo ?>">
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
                   value=' . $empleadoAuxiliar->GetLegajo() . '>
            <span style="display: none;" id="txtLegajoError">*</span>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <label for="txtSueldo">Sueldo:</label>
        </td>
        <td colspan="6">
            <input type="number" name="txtSueldo" id="txtSueldo" min="8000" max="25000" step="500"
                   value=' . $empleadoAuxiliar->GetSueldo() . '>
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
            <input type="file" name="txtFoto" id="txtFoto" value=' . $empleadoAuxiliar->GetPathFoto() . '>
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
        <input type="submit" name="btnEnviar" id="" value="' . $btnEnviar . '"
               onclick=" ' . $manejadora . ' ">
    </td>
</tr>
</tbody>
</table>';


    return $formulario;

    //endregion

}


//Busca dentro de la fábrica por dni
//El empleado siempre debería estar ya que es un dni que no se puede modificar
// porque su atributo es input es readOnly.
function BuscarEmpleado($fabrica, $dni)
{
    $empleadoEncontrado = array();
    foreach ($fabrica->GetEmpleados() as $item) {
        if ($item->GetDni() == $dni) {
            $empleadoEncontrado = $item;
            break;
        }
    }
    return $empleadoEncontrado;
}

function GuardarFoto($nombreFoto, $extension, $tamanioFoto, $tmpNameFoto, $destino, $nombreFotoSinExtension): bool
{
    $uploadOk = false;
    if ($nombreFoto) {

        $uploadOk = false;
        switch ($extension) {
            case "jpg":
            case "bmp":
            case "gif":
            case "png":
            case "jpeg":
//1MB
                if ($tamanioFoto <= 1000000) {

                    move_uploaded_file($tmpNameFoto, $destino);
                    $uploadOk = true;
                }
                break;
        }
    }
    return $uploadOk;
}

function IndiceEmpleado($fabrica, $dniEmpleado)
{
    $contador = 0;
    $indiceEmpleado = 0;
    foreach ($fabrica->GetEmpleados() as $item) {
        if ($item->GetDni() == $dniEmpleado) {
            $indiceEmpleado = $contador;
            break;
        }
        $contador++;
    }
    return $indiceEmpleado;
}


