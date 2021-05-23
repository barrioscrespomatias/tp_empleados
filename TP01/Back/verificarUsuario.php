<?php

session_start();
 

// include_once './entidades/empleado.php';
// include_once './entidades/fabrica.php';

$btnEnviar = isset($_POST['btnEnviar']) ? $_POST['btnEnviar'] : "Error";
$dni = isset($_POST['txtDni']) ? $_POST['txtDni'] : "Error";
$apellido = isset($_POST['txtApellido']) ? $_POST['txtApellido'] : "Error";
$path = "./archivos/empleados.txt";

switch ($btnEnviar) {
    case "Enviar":
        $flag = false;
        $archivo = fopen($path, "r");
        while (!feof($archivo)) {
            $lineaDeArchivo = fgets($archivo);
            $persona = explode("-", $lineaDeArchivo);

            if ($persona[0] != NULL) {
                //Si el empleado existe, pongo TRUE la bandera.
                if ($persona[1] == $apellido && $persona[2] == $dni) {
                    $_SESSION['DNIEmpleado'] = $dni;
                    $flag = true;
                    break;
                }
            }
        }
        if ($flag)
            header('location: mostrar.php');
        else{
            echo "Error!!!<br>Los datos ingresados no corresponden con ningun empleado.<br>";
            ?>
            <a href="../Front/login.html">Volver al Login</a>
            <?php            
        }           

        break;
}
