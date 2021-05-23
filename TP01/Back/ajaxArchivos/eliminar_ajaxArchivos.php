<?php

include_once '../entidades/fabrica.php';

$legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : null;
/*$nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : "Error";
$pathFoto = isset($_GET["pathFoto"]) ? $_GET["pathFoto"] : "Error";*/


if (isset($legajo)) {


    $path = "../archivos/empleados.txt";
    $archivo = fopen($path, "r");
    $fabrica = new Fabrica("La fabrica");
    $fabrica->SetCantidadMaxima(7);
    $fabrica->TraerDeArchivo($path);

    while (!feof($archivo)) {
        $lineaDeArchivo = fgets($archivo);
        $persona = explode("-", $lineaDeArchivo);

        if ($persona[0] != NULL) {
            if (count($persona) == CANT_ATRIBUTOS && $persona[4] == $legajo) {
                $empleadoEliminado = new Empleado($persona[0], $persona[1], $persona[2], $persona[3], $persona[4], $persona[5], $persona[6]);

                $pathFoto = trim($persona[7]."-".$persona[8]);

                if ($fabrica->EliminarEmpleado($empleadoEliminado)) {
                    unlink($pathFoto);
                    $fabrica->GuardarEnArchivo($path);
                    echo $fabrica->GenerarTabla();
                    break;
                }
            }
        }
    }
}


