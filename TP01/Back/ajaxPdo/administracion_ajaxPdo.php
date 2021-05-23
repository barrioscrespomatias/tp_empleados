<?php
session_start();

include_once '../entidades/empleado.php';
include_once '../entidades/fabrica.php';

//region DatosEmpleado

$json_empleado = isset($_POST["json_empleado"]) ? $_POST["json_empleado"] : null;
$empleadoStd = json_decode($json_empleado);


//endregion

//region DatosFile
$nombreFoto = isset($_FILES['txtFoto']['name']) ? $_FILES['txtFoto']['name'] : null;
$tamanioFoto = isset($_FILES['txtFoto']['size']) ? $_FILES['txtFoto']['size'] : null;
$tmpNameFoto = isset($_FILES['txtFoto']['tmp_name']) ? $_FILES['txtFoto']['tmp_name'] : null;
if (isset($nombreFoto)) {
    $array = explode(".", $_FILES['txtFoto']['name']);
    $extension = end($array);
    $destino = "../fotos/" . $empleadoStd->dni . "-" . $empleadoStd->apellido . "." . $extension;
    $path = $empleadoStd->dni . "-" . $empleadoStd->apellido . "." . $extension;
    $nombreFotoSinExtension = pathinfo($nombreFoto, PATHINFO_FILENAME);
}
//endregion

$btnEnviar = isset($_POST["btnEnviar"]) ? $_POST["btnEnviar"] : "Error";


//Instancia fábrica, se actualiza desde el archivo de texto.
$fabrica = new Fabrica("La fabrica");
$fabrica->SetCantidadMaxima(7);


switch ($btnEnviar) {

    case 'Enviar':

        //Guardar la foto // Corrobora que el nombre exista y que el tamaño sea un numero.
        //Si es false no ingresa.
        if ($nombreFoto && $tamanioFoto)
            GuardarFoto($nombreFoto, $extension, $tamanioFoto, $tmpNameFoto, $destino, $nombreFotoSinExtension);

        if ($empleadoStd->nombre) {
            $empleado = new Empleado($empleadoStd->nombre, $empleadoStd->apellido, $empleadoStd->dni, $empleadoStd->sexo, $empleadoStd->legajo, $empleadoStd->sueldo, $empleadoStd->turno);
            $empleado->SetPathFoto($path);
            // ---------------------------------Cargar la fábrica--------------------------
            $listaEmpleados = $fabrica->TraerTodosEmpleadosDB();
            $fabrica->SetEmpleados($listaEmpleados);
            // ---------------------------------Agregar nuevo empleado----------------------
            if ($fabrica->AgregarEmpleadoDB($empleado)) {

                //Traer tabla con los empleados de la clase fabrica.
                $tabla = $fabrica->GenerarTabla();
                echo $tabla;
            }
        }
        break;

    case 'Modificar':

        $empleadoAux = new Empleado();
        $empleadoAux->SetNombre($empleadoStd->nombre);
        $empleadoAux->SetApellido($empleadoStd->apellido);
        $empleadoAux->SetDni($empleadoStd->dni);
        $empleadoAux->SetSexo($empleadoStd->sexo);
        $empleadoAux->SetSueldo($empleadoStd->sueldo);
        $empleadoAux->SetTurno($empleadoStd->turno);
        $empleadoAux->SetPathFoto($path);


        $listaEmpleados = $fabrica->TraerTodosEmpleadosDB();
        $fabrica->SetEmpleados($listaEmpleados);

        //Empleado auxiliar que necesita el metodo modificar de la clase fabrica
        $modificado = $fabrica->ModificarEmpleado($empleadoAux);

        //Obtener el path de la foto del empleado anterior.
        $empleadoModificado = $fabrica->BuscarEmpleado(null, $empleadoStd->dni);
        $pathFotoEliminada = $empleadoModificado->GetPathFoto();

        //Trim por problemas de espacio, que coincida la del path.
        $pathFotoEliminada = trim($pathFotoEliminada);
        unlink($pathFotoEliminada);

        //Si se ha modificado el empleado, si la foto existe y el tamanio es optimo
        if ($modificado &&$nombreFoto && $tamanioFoto)
            $fotoGuardada = GuardarFoto($nombreFoto, $extension, $tamanioFoto, $tmpNameFoto, $destino, $nombreFotoSinExtension);

        break;

    case  'EnviarEmpleados':
        $listaEmpleados = $fabrica->TraerTodosEmpleadosDB();
        $fabrica->SetEmpleados($listaEmpleados);
        echo $fabrica->GenerarTabla();
        break;

    case 'GenerarFormularioAltaModificar':
        echo GenerarFormularioHtml();
        break;

}

/**
 * Rertorna un formulario con:
 * a)Los campos vacíos para llenar y crear un nuevo empleado.
 * b)Los campos llenos para modificar
 * Dependiendo el tipo de formulario, el btnEnviar tendrá el onclick AgregarEmpleado
 * o ModifiarEmpleado.
 * Cada uno se enlazará con JS mediante diferentes manejadores.
 *
 * @return string
 */
function GenerarFormularioHtml()
{
    $valorDniEmpleado = isset($_POST["inputHidden"]) ? $_POST["inputHidden"] : null;

    $empleadoAuxiliar = new Empleado();
    if (isset($valorDniEmpleado)) {
        $fabrica = new Fabrica("La fabrica");
        $listaEmpleados = $fabrica->TraerTodosEmpleadosDB();
        $fabrica->SetEmpleados($listaEmpleados);
        $empleadoAuxiliar = $fabrica->BuscarEmpleado(null, $valorDniEmpleado);

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
        <h2 style="text-align: center"><' . $tituloPagina . '></h2>
        <table align="left" width="40%">
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


