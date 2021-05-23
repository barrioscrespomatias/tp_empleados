<?php

include_once '../entidades/fabrica.php';

$legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : null;


if (isset($legajo)) {

    $fabrica = new Fabrica("La fabrica");
    $fabrica->SetCantidadMaxima(7);
    $listaEmpleados = $fabrica->TraerTodosEmpleadosDB();
    $fabrica->SetEmpleados($listaEmpleados);

    //buscar al empleado para conseguir el path de la foto.
    $empleadoAuxiliar = $fabrica->BuscarPorLegajo($legajo);

    if(isset($empleadoAuxiliar))
    $pathFoto = $empleadoAuxiliar->GetPathFoto();

    if ($fabrica->EliminarEmpleadoDB($legajo)) {
        unlink($pathFoto);
        echo $fabrica->GenerarTabla();
    }
}




