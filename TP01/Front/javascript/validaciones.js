"use strict";
// namespace Validaciones {
/* #region  VALIDACIONES 02 */
var AdministrarValidaciones = function () {
    var retorno = false;
    /* #region  DNI */
    console.log("Corroborando que el campo DNI no se encuentre vac\u00EDo");
    if (!ValidarCamposVacios("txtDni")) {
        console.log("Ok...\n");
        var valorDni = parseInt(document.getElementById("txtDni").value);
        console.log("Corroborando que el valor del DNI se encuentre entre los parámetros correctos");
        var rangoNumericoCorrecto = ValidarRangoNumerico(valorDni, 1000000, 55000000);
        if (rangoNumericoCorrecto) {
            document.getElementById("txtDniError").style.display = "none";
            console.log("Ok...\n");
        }
        else {
            //Si el rango numérico no es correcto, modifica el valor del span.
            AdministrarSpanError("txtDniError", !rangoNumericoCorrecto);
            console.log("Error en txt Dni");
        }
    }
    else {
        AdministrarSpanError("txtDniError", true);
        console.log("Campo DNI vacío");
    }
    /* #endregion */
    /* #region  APELLIDO */
    console.log("Corroborando que el campo Apellido no se encuentre vac\u00EDo");
    var apellido = document.getElementById("txtApellido").value;
    var camposVacios = ValidarCamposVacios("txtApellido");
    if (!camposVacios) {
        document.getElementById("txtApellidoError").style.display = "none";
        console.log("Ok...\n");
    }
    else {
        AdministrarSpanError("txtApellidoError", camposVacios);
        console.log("Campo Apellido está vacío");
    }
    /* #endregion */
    /* #region  NOMBRE */
    console.log("Corroborando que el campo Nombre no se encuentre vac\u00EDo");
    var nombre = document.getElementById("txtNombre").value;
    camposVacios = ValidarCamposVacios("txtNombre");
    if (!camposVacios) {
        document.getElementById("txtNombreError").style.display = "none";
        console.log("Ok...\n");
    }
    else {
        AdministrarSpanError("txtNombreError", camposVacios);
        console.log("Campo Nombre está vacío");
    }
    /* #endregion */
    /* #region  LEGAJO */
    console.log("Corroborando que el campo Legajo no se encuentre vac\u00EDo");
    if (!ValidarCamposVacios("txtLegajo")) {
        console.log("Ok...\n");
        var valorLegajo = parseInt(document.getElementById("txtLegajo").value);
        console.log("Corroborando que el valor del Legajo se encuentre entre los parámetros correctos");
        var rangoNumericoCorrecto = ValidarRangoNumerico(valorLegajo, 100, 550);
        if (rangoNumericoCorrecto) {
            document.getElementById("txtLegajoError").style.display = "none";
            console.log("Ok...\n");
        }
        else {
            AdministrarSpanError("txtLegajoError", !rangoNumericoCorrecto);
            console.log("Error en txt legajo");
        }
    }
    else {
        AdministrarSpanError("txtLegajoError", true);
        console.log("Campo Legajo está vacío");
    }
    /* #endregion */
    /* #region  SUELDO y TURNO */
    console.log("Corroborando que el campo Sueldo se encuentre vac\u00EDo");
    if (!ValidarCamposVacios("txtSueldo")) {
        console.log("Ok...\n");
        var valorSueldo = parseInt(document.getElementById("txtSueldo").value);
        var valorCboTurno = ObtenerTurnoSeleccionado();
        var sueldoMaximo = ObtenerSueldoMaximo(valorCboTurno);
        console.log("Corroborando que el valor del Sueldo se encuentre entre los parámetros correctos");
        var rangoNumericoCorrecto = ValidarRangoNumerico(valorSueldo, 8000, sueldoMaximo);
        if (rangoNumericoCorrecto) {
            document.getElementById("txtSueldoError").style.display = "none";
            console.log("Ok...\n");
        }
        else {
            AdministrarSpanError("txtSueldoError", !rangoNumericoCorrecto);
            console.log("Error en txt sueldo");
        }
    }
    else {
        AdministrarSpanError("txtSueldoError", true);
        console.log("Campo Sueldo está vacío");
    }
    /* #endregion */
    /* #region  SEXO */
    console.log("Corroborando que el campo Sexo sea correcto");
    var valorCombo = document.getElementById("cboSexo").value;
    var comboCorrecto = ValidarCombo(valorCombo, "---");
    if (comboCorrecto) {
        document.getElementById("cboSexoError").style.display = "none";
        console.log("Ok...\n");
    }
    else {
        AdministrarSpanError("cboSexoError", !comboCorrecto);
        console.log("No se ha seleccionado el Sexo");
    }
    /* #endregion */
    /* #region  FOTO */
    console.log("Corroborando que el campo FOTO no se encuentre vac\u00EDo");
    var foto = document.getElementById("txtFoto").value;
    camposVacios = ValidarCamposVacios("txtFoto");
    if (!camposVacios) {
        document.getElementById("txtFotoError").style.display = "none";
        console.log("Ok...\n");
    }
    else {
        AdministrarSpanError("txtFotoError", camposVacios);
        console.log("No se ha seleccionado ninguna foto");
    }
    /* #endregion */
    var verificarValidaciones = VerificarValidacionesLogin();
    if (verificarValidaciones) {
        retorno = true;
    }
    return retorno;
};
/* #endregion */
/* #region  VALIDACIONES 04 */
var AdministrarValidacionesLogin = function () {
    console.log("Validando que el campo DNI no se encuentre vac\u00EDo");
    if (!ValidarCamposVacios("txtDni")) {
        console.log("Ok..!");
        console.log("Corroborando que el DNI se encuentre dentro de los par\u00E1metros establecidos");
        var valorDni = parseInt(document.getElementById("txtDni").value);
        var rangoNumericoCorrecto = ValidarRangoNumerico(valorDni, 1000000, 55000000);
        var valorSpan = void 0;
        if (!rangoNumericoCorrecto) {
            alert("El valor del DNI " + valorDni + " est\u00E1 fuera del rango permitido!");
            AdministrarSpanError("errorTxtDni", !rangoNumericoCorrecto);
        }
        else {
            document.getElementById("errorTxtDni").style.display = "none";
            console.log("Ok...");
        }
    }
    else
        alert("El campo DNI está vacío!!");
    console.log("Validando que el campo APELLIDO no se encuentre vacío");
    if (!ValidarCamposVacios("txtApellido")) {
        console.log("Ok..!");
        console.log("Corroborando que el APELLIDO contenga solo letras...");
        var valorApellido = document.getElementById("txtApellido").value;
        var letrasValidas = ValidarLetras(valorApellido);
        if (!letrasValidas) {
            alert("El valor del APELLIDO " + valorApellido + " no contiene solo letras!");
            AdministrarSpanError("errorTxtApellido", !letrasValidas);
        }
        else {
            document.getElementById("errorTxtApellido").style.display = "none";
            console.log("Ok...");
        }
    }
    else
        alert("El campo APELLIDO está vacío!!");
    var validacionesSpan = VerificarValidacionesLogin();
    if (validacionesSpan)
        console.log("Se han pasado todas las validaciones!!");
    else
        alert("Error, no se han pasado todas las validaciones!");
};
/* #endregion */
/* #region  FUNCIONES */
var campo;
///Modifica el display de un valor de un valor tomado desde un ID.
var AdministrarSpanError = function (txt, error) {
    if (error) {
        document.getElementById(txt).style.display = "block";
    }
};
var VerificarValidacionesLogin = function () {
    var retorno = true;
    var i = 0;
    var valorDisplay;
    var camposFormulario = document.getElementsByTagName("span");
    for (i; i < camposFormulario.length; i++) {
        valorDisplay = camposFormulario[i].style.display;
        if (valorDisplay == "block") {
            retorno = false;
            break;
        }
    }
    return retorno;
};
// Corrobora que un campo esté vacío.
// Si está vacío retorna true, sino false.
var ValidarCamposVacios = function (cadena) {
    var retorno = false;
    var campoStr = document.getElementById(cadena).value;
    if (campoStr.length == 0)
        retorno = true;
    return retorno;
};
//Valida un rango numérico. 
// Si el valor ingresado se encuentra dentro de los parámetros esperados
// del mínimo y el máximo, retorna true, sino false.
var ValidarRangoNumerico = function (valor, minimo, maximo) {
    var retorno = false;
    if (valor >= minimo && valor <= maximo && valor != null && valor != NaN)
        retorno = true;
    return retorno;
};
//Valida que el valor seleccionado del combobox sea distinto de un valor pasado como parámetro
// retorna true si es distinto, sino false
var ValidarCombo = function (valorCombo, valorComboIncorrecto) {
    var retorno = false;
    if (valorCombo != valorComboIncorrecto)
        retorno = true;
    return retorno;
};
var ObtenerTurnoSeleccionado = function () {
    var retorno = "";
    var valorRdio = document.getElementsByName("rdoTurno");
    valorRdio.forEach(function (element) {
        if (element.checked)
            retorno += element.value;
    });
    return retorno;
};
var ObtenerSueldoMaximo = function (turno) {
    var sueldoMaximo = 0;
    switch (turno) {
        case "Mañana":
            sueldoMaximo = 20000;
            break;
        case "Tarde":
            sueldoMaximo = 18500;
            break;
        case "Noche":
            sueldoMaximo = 25000;
            break;
    }
    return sueldoMaximo;
};
///Valida que un string ingresa sea solo letras.
var ValidarLetras = function (str) {
    var retorno = false;
    var cantidadStr = str.length;
    //Toma como letras a las que van desde la a hasta la z y las vocales con acento
    //Además con el caracter especial \s tiene en cuenta los espacios.
    //Si pusiera \S no tendría en cuenta los espacios.
    //g: global, es decir que tiene en cuenta a toda la cadena.
    //i: Tiene en cuenta tanto las mayúsculas como las minúsculas
    var letrasIngresadas = str.match(/[A-ZÁ-Ú\s]/gi);
    if (letrasIngresadas != null)
        if (cantidadStr == letrasIngresadas.length)
            retorno = true;
    return retorno;
};
/* #endregion */
// }
//# sourceMappingURL=validaciones.js.map