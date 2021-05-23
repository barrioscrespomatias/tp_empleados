<?php
include_once 'persona.php';

class Empleado extends Persona
{
    protected $_legajo;
    protected $_sueldo;
    protected $_turno;
    protected $_pathFoto;

    //Constructor de clase que llama a la clase padre.
    public function __construct($nombre = "", $apellido = "", $dni = "", $sexo = "", $legajo = "", $sueldo = "", $turno = "")
    {
        parent::__construct($nombre, $apellido, $dni, $sexo);
        $this->_legajo = $legajo;
        $this->_sueldo = $sueldo;
        $this->_turno = $turno;
    }

    //region Getters


    //Retorna el valor del atributo Legajo.
    public function GetLegajo()
    {
        $retorno = "";
        if ($this->_legajo > 0)
            $retorno = $this->_legajo;

        return $retorno;
    }

    //Retornoa el Path de la foto del empleado
    public function GetPathFoto()
    {
        $retorno = "";
        if (strlen($this->_pathFoto) > 0)
            $retorno = $this->_pathFoto;

        return $retorno;

    }

    //Retorna el valor del atributo Sueldo.
    public function GetSueldo()
    {
        $retorno = "";
        if ($this->_sueldo > 0)
            $retorno = $this->_sueldo;

        return $retorno;
    }

    //Retorna el valor del atributo Turno.
    public function GetTurno()
    {
        $retorno = "";
        if (strlen($this->_turno) > 0)
            $retorno = $this->_turno;

        return $retorno;
    }
    /* #endregion */

    //endregion

    //region Setters
    public function SetPathFoto($foto)
    {
        $this->_pathFoto = $foto;
    }

    public function SetLegajo($legajo)
    {
        $this->_legajo = $legajo;
    }

    public function SetSueldo($sueldo)
    {
        $this->_sueldo = $sueldo;
    }

    public function SetTurno($turno)
    {
        $this->_turno = $turno;
    }
    //endregion


    //Recibe un array de idiomas. Muestra los idiomas
    // que habla un empleado
    public function Hablar($idioma): string
    {
        $strSalida = "";
        if ($idioma != null) {
            $strSalida .= "El empleado habla ";
            foreach ($idioma as $item) {
                $strSalida .= $item . ", ";
            }
            $cantidadLetras = strlen($strSalida);

            // Se modifica la última "," agregada.
            // en la posición cantidad de str -2
            // se utiliza "-2" ya que el último es el caracter de escape.
            $strSalida[$cantidadLetras - 2] = ".";
            $strSalida .= "<br>";
        } else
            $strSalida = "Sólo habla su idioma nativo.<br>";
        return $strSalida;
    }

    // Muestra toda la informacion del empleado. 
    // Reutiliza método Tostring de la clase padre.
    public function ToString(): string
    {
        $strSalida = "";
        if ($this != null) {
            $strSalida = parent::ToString();
            $strSalida .= $this->_legajo . "-" . $this->_sueldo . "-" . $this->_turno . "-" . $this->_pathFoto;
        }
        return $strSalida;

    }
}
