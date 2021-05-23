namespace ManejadorAjax {
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
        let direccion: string = '../Back/ajaxArchivos/administracion_ajaxArchivos.php';

        let form: FormData = new FormData();

        form.append('txtNombre', nombre);
        form.append('txtApellido', apellido);
        form.append('txtDni', dni);
        form.append('cboSexo', sexo);
        form.append('txtLegajo', legajo);
        form.append('txtSueldo', sueldo);
        form.append('rdoTurno', turno);
        form.append('txtFoto', foto.files[0]);
        form.append('btnEnviar', 'Enviar');


        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);

        xhr.onreadystatechange = () => {

            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarTablaDom(xhr.responseText);
                // console.log(xhr.responseText);
            }
        };

    }

    export function EliminarEmpleado(legajo:string)
    {
        let xhr: XMLHttpRequest = new XMLHttpRequest();

        let direccion: string = '../Back/ajaxArchivos/eliminar_ajaxArchivos.php';
        let form: FormData = new FormData();

        form.append('legajo', legajo);

        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);

        xhr.onreadystatechange = () => {

            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarTablaDom(xhr.responseText);                
            }
        };



    }

    export function ModificarEmpleado(dni:string)
    {
        let xhr: XMLHttpRequest = new XMLHttpRequest();

        let direccion: string = '../Back/ajaxArchivos/administracion_ajaxArchivos.php';


        let form: FormData = new FormData();

        form.append('inputHidden', dni);
        form.append('btnEnviar', 'GenerarFormularioAltaModificar');

        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);

        // xhr.open("POST", direccion, true);
        // xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        // xhr.send(dni);

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
        let legajo: string = (<HTMLSelectElement>document.getElementById("txtLegajo")).value;
        let sueldo: string = (<HTMLSelectElement>document.getElementById("txtSueldo")).value;
        let turno: any = ObtenerTurnoSeleccionado();

        let foto: any = (<HTMLInputElement>document.getElementById("txtFoto"));
        let direccion: string = '../Back/ajaxArchivos/administracion_ajaxArchivos.php';

        let form: FormData = new FormData();

        form.append('txtNombre', nombre);
        form.append('txtApellido', apellido);
        form.append('txtDni', dni);
        form.append('cboSexo', sexo);
        form.append('txtLegajo', legajo);
        form.append('txtSueldo', sueldo);
        form.append('rdoTurno', turno);
        form.append('txtFoto', foto.files[0]);
        form.append('btnEnviar', 'Modificar');


        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);

        xhr.onreadystatechange = () => {

            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarTablaDom(xhr.responseText);
                
                CargarPagina();
            }
        };
        
    }

    export function CargarPagina()
    {
        ObtenerEmpleados();
        ObtenerFormulario();
    }

    function ObtenerEmpleados()
    {
        let xhr: XMLHttpRequest = new XMLHttpRequest();

        let direccion: string = '../Back/ajaxArchivos/administracion_ajaxArchivos.php';
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

        let direccion: string = '../Back/ajaxArchivos/administracion_ajaxArchivos.php';
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