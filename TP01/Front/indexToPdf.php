<?php

require_once '../Back/verificarUsuarioPdo.php';
include_once '../Back/composer/vendor/autoload.php';
include_once '../Back/entidades/fabrica.php';


$fabrica = new Fabrica("La fabrica");
$listaEmpleados = $fabrica->TraerTodosEmpleadosDB();
$fabrica->SetEmpleados($listaEmpleados);

$tabla =  $fabrica->GenerarTabla('pdf');

header('Content-Type: application/pdf');
$mpdf = new \Mpdf\Mpdf();

//Mostrar tabla con los empleados.

$mpdf->SetProtection(array(), $_SESSION["DNIEmpleado"]);
$mpdf->SetHeader('Barrios Crespo Matías||{PAGENO}{nbpg}');
$mpdf->SetFooter($_SERVER["REQUEST_URI"]);
$mpdf->WriteHTML($tabla);
$mpdf->Output('listadoEmpleados.pdf', 'I');  