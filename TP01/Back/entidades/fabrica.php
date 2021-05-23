<?php
const CANT_ATRIBUTOS = 9;
include_once 'empleado.php';
include_once 'interfaces.php';
include_once 'AccesoDatos.php';


class Fabrica implements IArchivo
{
    private $_cantidadMaxima;
    private $_empleados;
    private $_razonSocial;

    //Constructor por defecto.
    public function __construct($razonSocial)
    {
        $this->_cantidadMaxima = 5;
        $this->_razonSocial = $razonSocial;
        $this->_empleados = array();
    }

    //region Getters y Setters
    //Hace públicos los empleados.
    public function GetEmpleados(): array
    {
        return $this->_empleados;
    }

    public function SetEmpleados($listaEmpleados)
    {
        $this->_empleados = $listaEmpleados;
    }
    //endregion


    //Agrega a la fábrica el empleado pasado como parámetro.
    //En caso de poder agregarlo devuelve true.
    //Sino pude agregarlo retorna false y lo notifica por echo.
    //Luego de agregarlo corrobora que el mismo no se encuentre repetido en
    //la lista de empleados. En caso de estar repetido, lo borra y retorna false.
    public function AgregarEmpleado(Empleado $emp): bool
    {
        $retorno = false;
        $cantidadInicialEmpleados = count($this->_empleados);
        $cantidadActualEmpleados = 0;

        if ($emp != null && $cantidadInicialEmpleados < $this->_cantidadMaxima) {
            array_push($this->_empleados, $emp);
            $cantidadActualEmpleados = count($this->_empleados);
            if ($cantidadInicialEmpleados < $cantidadActualEmpleados) {
                $this->EliminarEmpleadosRepetidos();
                if (count($this->_empleados) > $cantidadInicialEmpleados)
                    $retorno = true;
            }

        }

        return $retorno;
    }

    ///Calcula la cantidad de dinero que la fábrica debe gastar en sus empleados.    
    public function CalcularSueldos(): float
    {
        $sueldos = 0;
        if (count($this->_empleados) > 0) {
            foreach ($this->_empleados as $item) {
                $sueldos += $item->GetSueldo();
            }
        } /*else
            echo "No hay ningun empleado cargado";*/

        return $sueldos;
    }

    //Recibe un empleado pasado por parámetro y si se encuentra en la lista de empleados
    // de la fábrica, lo elimina.
    public function EliminarEmpleado(Empleado $emp): bool
    {
        $retorno = false;
        $index = false;
        $contador = 0;

        foreach ($this->_empleados as $item) {
            if ($item->GetLegajo() == $emp->GetLegajo() && $item->GetNombre() == $emp->GetNombre()) {
                $index = $contador;
                break;
            }
            $contador++;
        }

        //Analiza de una forma precisa. !==
        if ($index !== false) {
            unset($this->_empleados[$index]);
            $retorno = true;
            /*            echo "Se ha eliminado el empleado " . $emp->GetNombre() . "<br>";*/
        } /*else
            echo "El empleado no existe!!<br>";*/
        return $retorno;
    }

    private function EliminarEmpleadosRepetidos(): void
    {
        //SORT_REGULAR - compara ítems normalmente (no cambia los tipos)        
        $this->_empleados = array_unique($this->_empleados, SORT_REGULAR);
    }

    //Muestra todos los atributos de la clase Fábrica.
    public function ToString(): string
    {
        $strSalida = "";
        $strSalida .= "Razón social: " . $this->_razonSocial . "<br>";
        $strSalida .= "Cantidad máxima empleados: " . $this->_cantidadMaxima . "<br>";
        $strSalida .= "Cantidad actual de empleados: " . count($this->_empleados) . "<br>";
        $strSalida .= "Lista de empleados: " . "<br><br>";
        foreach ($this->_empleados as $item) {
            $strSalida .= $item->ToString() . "<br>";
        }
        $strSalida .= "<br>";
        return $strSalida;
    }

    /* #region  INTERFACES */

    // Recibe el nombre del archivo de texto donde se guardarán los
    // empleados de la fábrica (empleados.txt). Recorre el array de Empleados y sobreescribe en
    // el archivo de texto, utilizando el método ToString 
    public function GuardarEnArchivo($nombreArchivo): void
    {
        $archivo = fopen($nombreArchivo, "w");
        $contadorEmpleadosGuardados = 0;
        foreach ($this->_empleados as $item) {
            //Aca tengo que guardar el empleado con su path.
            if ($item->GetNombre() != "") {
                fwrite($archivo, $item->ToString() . "\r\n");
                $contadorEmpleadosGuardados++;
            }
        }

        fclose($archivo);
    }

    // Recibe el nombre del archivo de texto donde se encuentran los empleados
    // (empleados.txt). Por cada registro leído, genera un objeto de tipo Empleado y lo agrega a la
    // fábrica (utilizando el método AgregarEmpleado)
    public function TraerDeArchivo($nombreArchivo): void
    {

        $archivo = fopen($nombreArchivo, "r");
        $contador = 0;

        if ($archivo !== false) {
            while (!feof($archivo)) {
                $renglon = fgets($archivo);

                //Renglon
                $empleado = explode("-", $renglon);
                if ($renglon != false && count($empleado) == CANT_ATRIBUTOS) {
                    $variableTipoEmpleado = new Empleado($empleado[0], $empleado[1], $empleado[2], $empleado[3], $empleado[4], $empleado[5], $empleado[6]);
                    $variableTipoEmpleado->SetPathFoto($empleado[7] . "-" . $empleado[8]);
                    if ($this->AgregarEmpleado($variableTipoEmpleado))
                        $contador++;
                }
            }
        }
    }






    /* #endregion */

    /* #region  FUNCIONES PROPIAS */

    // Setea la cantidad máxima en el numero pasado como parámetro
    public function SetCantidadMaxima($cantidad)
    {
        $this->_cantidadMaxima = $cantidad;
    }

    //Si el empleado existe que recibe como parámetro tiene el mismo legajo
    // que alguno de los empleados existentes en la lista de empleados, retorna
    // false, sino true.
    public function EmpleadoExiste(Empleado $emp): bool
    {
        $retorno = false;
        foreach ($this->_empleados as $item) {
            if ($item->GetLegajo() == $emp->GetLegajo()) {
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }
    /* #endregion */

    /**
     * Genera una tabla con empleados trayendo cada uno desde el metodo GetEmpleados de la clase fabrica.
     * Si el parámetro es NULL, entonces mostrará los botones. En caso contrario, no los mostrará (para generar un pdf)
     * @return string
     */
    function GenerarTabla($parametro=null): string
    {
        $retorno = "";
        $retorno .= '<h2 style="text-align: center">Lista de empleados</h2>';
        $retorno .= '<table align="right"; width="60%">';
        $listaEmpleados = $this->GetEmpleados();


        foreach ($listaEmpleados as $item) {
            $retorno .= '<tr>';
            $retorno .= '<td colspan=6>';
            $retorno .= $item->ToString();
            $retorno .= '</td>';
            $retorno .= '<td colspan=2>';
            $retorno .= '<img src=' . '../Back/fotos/' . $item->GetPathFoto() . ' alt="fotoEmpleado" width=90px height=90px>';
            $retorno .= '</td>';

            if ($parametro == null) {
                $retorno .= '<td colspan=2>';
                $retorno .= '<input type="button" value="Modificar" onclick="ManejadorAjax.ModificarEmpleado(' . $item->GetDni() . ')">';
                $retorno .= '</td>';
                $retorno .= '<td colspan=2>';
                $retorno .= '<input type="button" value="Eliminar" onclick="ManejadorAjax.EliminarEmpleado(' . $item->GetLegajo() . ')">';
            }
            $retorno .= '</td>';
            $retorno .= '</tr>';
        }
        $retorno .= '</table>';

        return $retorno;

    }

    //region PDO

    public function AgregarEmpleadoDB(Empleado $empleado)
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();

        $empleadoAuxiliar = new Empleado();

        $empleadoAuxiliar->SetNombre($empleado->GetNombre());
        $empleadoAuxiliar->SetApellido($empleado->GetApellido());
        $empleadoAuxiliar->SetDni($empleado->GetDni());
        $empleadoAuxiliar->SetSexo($empleado->GetSexo());
        $empleadoAuxiliar->SetLegajo($empleado->GetLegajo());
        $empleadoAuxiliar->SetSueldo($empleado->GetSueldo());
        $empleadoAuxiliar->SetTurno($empleado->GetTurno());
        $empleadoAuxiliar->SetPathFoto($empleado->GetPathFoto());

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleados (nombre,apellido,dni,sexo,legajo,sueldo,turno,pathFoto)"
            . " VALUES(:nombre, :apellido, :dni, :sexo, :legajo, :sueldo, :turno, :pathFoto)");

        //bindParam asocia un valor con la clave del insert.
        // $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $empleadoAuxiliar->GetNombre(), PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $empleadoAuxiliar->GetApellido(), PDO::PARAM_STR);
        $consulta->bindValue(':dni', $empleadoAuxiliar->GetDni(), PDO::PARAM_INT);
        $consulta->bindValue(':sexo', $empleadoAuxiliar->GetSexo(), PDO::PARAM_STR);
        $consulta->bindValue(':legajo', $empleadoAuxiliar->GetLegajo(), PDO::PARAM_INT);
        $consulta->bindValue(':sueldo', $empleadoAuxiliar->GetSueldo(), PDO::PARAM_STR);
        $consulta->bindValue(':turno', $empleadoAuxiliar->GetTurno(), PDO::PARAM_STR);
        $consulta->bindValue(':pathFoto', $empleadoAuxiliar->GetPathFoto(), PDO::PARAM_STR);

        $retorno = $consulta->execute();

        return $retorno;
    }

    public function TraerTodosEmpleadosDB()
    {
        //retorna una lista de empleados.
        $listaEmpleados = array();

        $objetoAccesoDatos = AccesoDatos::RetornarObjetoAcceso();

        /*        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT empleados.nombre,empleados.apellido,
                                                                 empleados.dni,empleados.sexo,empleados.legajo,
                                                                 empleados.sueldo,empleados.turno,empleados.pathFoto,
                FROM empleados");*/

        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM empleados");

        //Atenti con el alias.

        $consulta->execute();

        $consulta->execute();
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            $empleado = new Empleado();
            /*$empleado->Set = $fila->id;*/

            $empleado->SetNombre($fila->nombre);
            $empleado->SetApellido($fila->apellido);
            $empleado->SetDni($fila->dni);
            $empleado->SetSexo($fila->sexo);
            $empleado->SetLegajo($fila->legajo);
            $empleado->SetSueldo($fila->sueldo);
            $empleado->SetTurno($fila->turno);
            $empleado->SetPathFoto($fila->pathFoto);

            array_push($listaEmpleados, $empleado);
        }
        return $listaEmpleados;
    }

    public function EliminarEmpleadoDB($legajo)
    {
        $retorno = false;

        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM empleados WHERE empleados.legajo = :legajo");

        $consulta->bindParam(':legajo', $legajo, PDO::PARAM_INT);

        $consulta->execute();

        $eliminado = $consulta->rowCount();
        if ($eliminado > 0)
            $retorno = true;

        return $retorno;
    }

    public function ModificarEmpleado(Empleado $empleado)
    {
        $retorno = false;

        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleados SET nombre = :nombre,
            apellido = :apellido,sexo = :sexo, sueldo = :sueldo,turno=:turno,pathFoto=:foto
            WHERE empleados.dni = :dni");


        $consulta->bindParam(':nombre', $empleado->GetNombre(), PDO::PARAM_STR);
        $consulta->bindParam(':apellido', $empleado->GetApellido(), PDO::PARAM_STR);
        $consulta->bindParam(':sexo', $empleado->GetSexo(), PDO::PARAM_STR);
        $consulta->bindParam(':sueldo', $empleado->GetSueldo(), PDO::PARAM_STR);
        $consulta->bindParam(':turno', $empleado->GetTurno(), PDO::PARAM_STR);
        $consulta->bindParam(':foto', $empleado->GetPathFoto(), PDO::PARAM_STR);
        $consulta->bindParam(':dni', $empleado->GetDni(), PDO::PARAM_INT);

        $consulta->execute();
        $filasAfectadas = $consulta->rowCount();
        if ($filasAfectadas > 0)
            $retorno = true;

        return $retorno;


    }


    /**
     * Buscar un empleado en la base de datos
     * Lo puede buscar por DNI o por Legajo.
     * @param null $legajo
     * @param null $dni
     * @return mixed|null
     */
    public function BuscarEmpleado($legajo = null, $dni = null)
    {
        $empleadoAuxiliar = null;


        foreach ($this->_empleados as $item) {
            if ($item->GetLegajo() == $legajo || $item->GetDni() == $dni) {
                $empleadoAuxiliar = $item;
                break;
            }
        }

        return $empleadoAuxiliar;
    }

    //ExisteEmpleado


    //endregion


}
