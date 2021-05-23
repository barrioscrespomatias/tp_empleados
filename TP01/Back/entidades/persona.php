<?php

abstract class Persona
{
    private $_apellido;
    private $_dni;
    private $_nombre;
    private $_sexo;

    public function __construct($nombre, $apellido, $dni, $sexo)
    {
        $this->_nombre = $nombre;
        $this->_apellido = $apellido;
        $this->_dni = $dni;
        $this->_sexo = $sexo;
    }

    //region Getters

    //Retorna el valor del atributo Apellido.
    public function GetApellido()
    {
        $retorno = "";
        if(strlen($this->_apellido)>0)
            $retorno =  $this->_apellido;

        return $retorno;
    }

    //Retorna el valor del atributo Dni.
    public function GetDni()
    {
        $retorno = "";

        if($this->_dni>0)
            $retorno =  $this->_dni;

        return $retorno;
    }

    //Retorna el valor del atributo nombre.
    public function GetNombre()
    {
        $retorno = "";
        if(strlen($this->_nombre)>0)
        $retorno =  $this->_nombre;

        return $retorno;
    }

    //Retorna el valor el atributo sexo.
    public function GetSexo()
    {
        $retorno = "";
        if(strlen($this->_sexo)>0)
            $retorno =  $this->_sexo;

        return $retorno;
    }
    //endregion

    //region Setters
    public function SetApellido($apellido)
    {
        $this->_apellido = $apellido;
    }

    public function SetNombre($nombre)
    {
        $this->_nombre = $nombre;
    }

    public function SetDni($dni)
    {
        $this->_dni = $dni;
    }

    public function SetSexo($sexo)
    {
        $this->_sexo = $sexo;
    }
    //endregion


    //Método abstracto que recibe por parámetro un array de idiomas.
    public abstract function Hablar($idioma);

    //Muestra toda la informacion de la Persona con todos sus atributos.
    public function ToString()
    {
        $strSalida = "";
        if ($this != null)
            $strSalida .= $this->_nombre . "-" . $this->_apellido . "-" . $this->_dni . "-" . $this->_sexo . "-";
        else
            $strSalida = "No se pudo mostrar la persona.<br>";

        return $strSalida;
    }
}
