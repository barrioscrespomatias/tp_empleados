/// <reference path="../../../node_modules/@types/jquery/index.d.ts" />


$(function(){

    ManejadorAjax.JqueryTraerTodos();

});


namespace ManejadorAjax {


    export function JqueryTraerTodos():void {

        let pagina = "../../Back/POO/nexo.php";
        let datoObjeto = {"op" : "traerListadoCD" };

        $("#divResultado").html("");

        $.ajax({
            type: 'POST',
            url: pagina,
            dataType: "text",
            data: datoObjeto,
            async: true
        })
            .done(function (resultado:any) {

                $("#divResultado").html(resultado);

                manejador_click_btn_eliminar();
            })
            .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
                alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
            });
    }


    export function AgregarEmpleado()
    {
        let xhr: XMLHttpRequest = new XMLHttpRequest();

        let nombre: string = (<HTMLInputElement>document.getElementById("txtNombre")).value;
        let apellido: string = (<HTMLInputElement>document.getElementById("txtApellido")).value;
        let dni: string = (<HTMLInputElement>document.getElementById("txtDni")).value;
        let sexo: string = (<HTMLInputElement>document.getElementById("cboSexo")).value;
        let legajo: string = (<HTMLSelectElement>document.getElementById("txtLegajo")).value;
        let sueldo: string = (<HTMLSelectElement>document.getElementById("txtSueldo")).value;
        let turno: any = ObtenerTurnoSeleccionado();

        let foto: any = (<HTMLInputElement>document.getElementById("txtFoto"));
        let direccion: string = '../Back/ajaxPdo/administracion_ajaxPdo.php';

        let empleado:any = {"nombre":nombre,
                            "apellido":apellido,
                            "dni":dni,
                            "sexo":sexo,
                            "legajo":legajo,
                            "sueldo":sueldo,
                            "turno":turno};


        let form: FormData = new FormData();

        form.append('json_empleado', JSON.stringify(empleado));        
        form.append('txtFoto', foto.files[0]);
        form.append('btnEnviar', 'Enviar');

        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);

        xhr.onreadystatechange = () => {

            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarTablaDom(xhr.responseText);
                RecargarPagina();
            }
        };

    }

    export function EliminarEmpleado(legajo:string)
    {
        let xhr: XMLHttpRequest = new XMLHttpRequest();

        let direccion: string = '../Back/ajaxPdo/eliminar_ajaxPdo.php';
        let form: FormData = new FormData();

        form.append('legajo', legajo);

        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);

        xhr.onreadystatechange = () => {

            if (xhr.readyState == 4 && xhr.status == 200) {
                // CargarTablaDom(xhr.responseText); 
                RecargarPagina();               
            }
        };



    }

    export function ModificarEmpleado(dni:string)
    {
        let xhr: XMLHttpRequest = new XMLHttpRequest();

        let direccion: string = '../Back/ajaxPdo/administracion_ajaxPdo.php';


        let form: FormData = new FormData();

        form.append('inputHidden', dni);
        form.append('btnEnviar', 'GenerarFormularioAltaModificar');



        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);

        xhr.onreadystatechange = () => {

            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarFormulario(xhr.responseText);                
            }
        };
    }

    export function Modificar()
    {
        let xhr: XMLHttpRequest = new XMLHttpRequest();

        let nombre: string = (<HTMLInputElement>document.getElementById("txtNombre")).value;
        let apellido: string = (<HTMLInputElement>document.getElementById("txtApellido")).value;
        let dni: string = (<HTMLInputElement>document.getElementById("txtDni")).value;
        let sexo: string = (<HTMLInputElement>document.getElementById("cboSexo")).value;        
        let sueldo: string = (<HTMLSelectElement>document.getElementById("txtSueldo")).value;
        let turno: any = ObtenerTurnoSeleccionado();

        let foto: any = (<HTMLInputElement>document.getElementById("txtFoto"));
        let direccion: string = '../Back/ajaxPdo/administracion_ajaxPdo.php';

        let empleado:any = {"nombre":nombre,
                            "apellido":apellido,
                            "dni":dni,
                            "sexo":sexo,                            
                            "sueldo":sueldo,
                            "turno":turno};


        let form: FormData = new FormData();
        form.append('json_empleado', JSON.stringify(empleado));
        form.append('txtFoto', foto.files[0]);
        form.append('btnEnviar', 'Modificar');


        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);

        xhr.onreadystatechange = () => {

            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarTablaDom(xhr.responseText);
                
                RecargarPagina();
            }
        };
        
    }

    export function RecargarPagina()
    {
        ObtenerFormulario();
        ObtenerEmpleados();        
    }

    function ObtenerEmpleados()
    {
        let xhr: XMLHttpRequest = new XMLHttpRequest();

        let direccion: string = '../Back/ajaxPdo/administracion_ajaxPdo.php';
        let form: FormData = new FormData();

        form.append('btnEnviar', 'EnviarEmpleados');

        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);

        xhr.onreadystatechange = () => {

            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarTablaDom(xhr.responseText);                
            }
        };


    }

    function ObtenerFormulario()
    {
        let xhr: XMLHttpRequest = new XMLHttpRequest();

        let direccion: string = '../Back/ajaxPdo/administracion_ajaxPdo.php';
        let form: FormData = new FormData();

        form.append('btnEnviar', 'GenerarFormularioAltaModificar');

        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);

        xhr.onreadystatechange = () => {

            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarFormulario(xhr.responseText);                
            }
        };


    }




    function CargarFormulario (cadena:string)
    {
        let tabla : any = document.getElementById("divAlta");
        tabla.innerHTML ="";
        tabla.innerHTML+= cadena;
    }

    function CargarTablaDom (cadena:string)
    {
        let tabla : any = document.getElementById("divTablaEmpleados");
        tabla.innerHTML ="";
        tabla.innerHTML+= cadena;
    }





    let ObtenerTurnoSeleccionado: Function = (): string => {
        let retorno: string = "";
        let valorRdio: NodeListOf<HTMLElement> = document.getElementsByName("rdoTurno");
    
        valorRdio.forEach(element => {
            if ((<HTMLInputElement>element).checked)
                retorno += (<HTMLInputElement>element).value;
        });
    
    
        return retorno;
    }

}