<?php

include_once './entidades/fabrica.php';

$legajo = isset($_GET["legajo"]) ? $_GET["legajo"] : "Error";
$nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : "Error";
$pathFoto = isset($_GET["pathFoto"]) ? $_GET["pathFoto"] : "Error";



if ($legajo) {
    $path = "./archivos/empleados.txt";
    $archivo = fopen($path, "r");
    $fabrica = new Fabrica("La fabrica");
    $fabrica->SetCantidadMaxima(7);
    $flag = false;


    while (!feof($archivo)) {
        $lineaDeArchivo = fgets($archivo);
        $persona = explode("-", $lineaDeArchivo);

        if ($persona[0] != NULL) {
            //Si el empleado existe, tomarlo.
            if (count($persona) == CANT_ATRIBUTOS &&  $persona[4] == $legajo && $persona[0] == $nombre) {
                $flag = true;                
                $empleadoEliminado = new Empleado($persona[0], $persona[1], $persona[2], $persona[3], $persona[4], $persona[5], $persona[6]);

                $fabrica = new Fabrica("La fabrica");
                $fabrica->SetCantidadMaxima(7);
                $fabrica->TraerDeArchivo($path);

                if ($fabrica->EliminarEmpleado($empleadoEliminado)) {
                    //Path enviado por GET 
                                       
                    unlink($pathFoto);
                    $fabrica->GuardarEnArchivo($path);
                    echo "<br>Se ha eliminado al empleado " . $empleadoEliminado->GetNombre() . ", legajo numero " . $empleadoEliminado->GetLegajo() . "<br>";
                    // echo "<br><td><a href='../Front/index.html'>Volver al inicio</a></td></tr>";
                    break;
                } else
                    echo "<br>No se ha eliminado al empleado " . $empleadoEliminado->GetNombre() . ", legajo numero " . $empleadoEliminado->GetLegajo() . " ya que no existia.<br>";
            }
        }
    }
    if (!$flag) {
        echo "No existe ningun empleado con el legajo {$legajo} y nombre {$nombre}";
        // echo "<br><td><a href='../Front/index.html'>Volver al inicio</a></td></tr>";
        echo "<br><td><a href='mostrar.php'>Ir a Mostrar empleados -mostrar.php-</a></td></tr>";
    }
} else
    echo $legajo;
