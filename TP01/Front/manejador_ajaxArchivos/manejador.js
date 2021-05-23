var ManejadorAjax;
(function (ManejadorAjax) {
    function AgregarEmpleado() {
        var xhr = new XMLHttpRequest();
        var nombre = document.getElementById("txtNombre").value;
        var apellido = document.getElementById("txtApellido").value;
        var dni = document.getElementById("txtDni").value;
        var sexo = document.getElementById("cboSexo").value;
        var legajo = document.getElementById("txtLegajo").value;
        var sueldo = document.getElementById("txtSueldo").value;
        var turno = ObtenerTurnoSeleccionado();
        var foto = document.getElementById("txtFoto");
        var direccion = '../Back/ajaxArchivos/administracion_ajaxArchivos.php';
        var form = new FormData();
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
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarTablaDom(xhr.responseText);
                // console.log(xhr.responseText);
            }
        };
    }
    ManejadorAjax.AgregarEmpleado = AgregarEmpleado;
    function EliminarEmpleado(legajo) {
        var xhr = new XMLHttpRequest();
        var direccion = '../Back/ajaxArchivos/eliminar_ajaxArchivos.php';
        var form = new FormData();
        form.append('legajo', legajo);
        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarTablaDom(xhr.responseText);
            }
        };
    }
    ManejadorAjax.EliminarEmpleado = EliminarEmpleado;
    function ModificarEmpleado(dni) {
        var xhr = new XMLHttpRequest();
        var direccion = '../Back/ajaxArchivos/administracion_ajaxArchivos.php';
        var form = new FormData();
        form.append('inputHidden', dni);
        form.append('btnEnviar', 'GenerarFormularioAltaModificar');
        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);
        // xhr.open("POST", direccion, true);
        // xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        // xhr.send(dni);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarFormulario(xhr.responseText);
            }
        };
    }
    ManejadorAjax.ModificarEmpleado = ModificarEmpleado;
    function Modificar() {
        var xhr = new XMLHttpRequest();
        var nombre = document.getElementById("txtNombre").value;
        var apellido = document.getElementById("txtApellido").value;
        var dni = document.getElementById("txtDni").value;
        var sexo = document.getElementById("cboSexo").value;
        var legajo = document.getElementById("txtLegajo").value;
        var sueldo = document.getElementById("txtSueldo").value;
        var turno = ObtenerTurnoSeleccionado();
        var foto = document.getElementById("txtFoto");
        var direccion = '../Back/ajaxArchivos/administracion_ajaxArchivos.php';
        var form = new FormData();
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
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarTablaDom(xhr.responseText);
                CargarPagina();
            }
        };
    }
    ManejadorAjax.Modificar = Modificar;
    function CargarPagina() {
        ObtenerEmpleados();
        ObtenerFormulario();
    }
    ManejadorAjax.CargarPagina = CargarPagina;
    function ObtenerEmpleados() {
        var xhr = new XMLHttpRequest();
        var direccion = '../Back/ajaxArchivos/administracion_ajaxArchivos.php';
        var form = new FormData();
        form.append('btnEnviar', 'EnviarEmpleados');
        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarTablaDom(xhr.responseText);
            }
        };
    }
    function ObtenerFormulario() {
        var xhr = new XMLHttpRequest();
        var direccion = '../Back/ajaxArchivos/administracion_ajaxArchivos.php';
        var form = new FormData();
        form.append('btnEnviar', 'GenerarFormularioAltaModificar');
        xhr.open('POST', direccion, true);
        xhr.setRequestHeader("enctype", "multipart/form-data");
        xhr.send(form);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                CargarFormulario(xhr.responseText);
            }
        };
    }
    function CargarFormulario(cadena) {
        var tabla = document.getElementById("divAlta");
        tabla.innerHTML = "";
        tabla.innerHTML += cadena;
    }
    function CargarTablaDom(cadena) {
        var tabla = document.getElementById("divTablaEmpleados");
        tabla.innerHTML = "";
        tabla.innerHTML += cadena;
    }
    var ObtenerTurnoSeleccionado = function () {
        var retorno = "";
        var valorRdio = document.getElementsByName("rdoTurno");
        valorRdio.forEach(function (element) {
            if (element.checked)
                retorno += element.value;
        });
        return retorno;
    };
})(ManejadorAjax || (ManejadorAjax = {}));
