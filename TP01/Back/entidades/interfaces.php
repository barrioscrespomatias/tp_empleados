<?php

interface IArchivo{
    public function GuardarEnArchivo($nombreDeArchivo): void;
    public function TraerDeArchivo($nombreDeArchivo): void;
}

?>

