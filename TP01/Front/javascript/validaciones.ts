
// namespace Validaciones {


/* #region  VALIDACIONES 02 */
let AdministrarValidaciones: Function = (): boolean => {
    let retorno: boolean = false;

    /* #region  DNI */
    console.log(`Corroborando que el campo DNI no se encuentre vacío`);
    if (!ValidarCamposVacios("txtDni")) {
        console.log("Ok...\n");

        let valorDni: number = parseInt((<HTMLInputElement>document.getElementById("txtDni")).value);

        console.log("Corroborando que el valor del DNI se encuentre entre los parámetros correctos");
        let rangoNumericoCorrecto: boolean = ValidarRangoNumerico(valorDni, 1000000, 55000000);

        if (rangoNumericoCorrecto) {
            (<HTMLInputElement>document.getElementById("txtDniError")).style.display = "none";
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
    console.log(`Corroborando que el campo Apellido no se encuentre vacío`);
    let apellido: string = (<HTMLInputElement>document.getElementById("txtApellido")).value;

    let camposVacios = ValidarCamposVacios("txtApellido")
    if (!camposVacios) {
        (<HTMLInputElement>document.getElementById("txtApellidoError")).style.display = "none";
        console.log("Ok...\n");
    }

    else {
        AdministrarSpanError("txtApellidoError", camposVacios);
        console.log("Campo Apellido está vacío");
    }



    /* #endregion */

    /* #region  NOMBRE */
    console.log(`Corroborando que el campo Nombre no se encuentre vacío`);
    let nombre: string = (<HTMLInputElement>document.getElementById("txtNombre")).value;
    camposVacios = ValidarCamposVacios("txtNombre");
    if (!camposVacios) {
        (<HTMLInputElement>document.getElementById("txtNombreError")).style.display = "none";
        console.log("Ok...\n");

    }
    else {
        AdministrarSpanError("txtNombreError", camposVacios);
        console.log("Campo Nombre está vacío");
    }

    /* #endregion */

    /* #region  LEGAJO */
    console.log(`Corroborando que el campo Legajo no se encuentre vacío`);
    if (!ValidarCamposVacios("txtLegajo")) {
        console.log(`Ok...\n`);

        let valorLegajo: number = parseInt((<HTMLInputElement>document.getElementById("txtLegajo")).value);
        console.log("Corroborando que el valor del Legajo se encuentre entre los parámetros correctos");
        let rangoNumericoCorrecto = ValidarRangoNumerico(valorLegajo, 100, 550);
        if (rangoNumericoCorrecto) {
            (<HTMLInputElement>document.getElementById("txtLegajoError")).style.display = "none";
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
    console.log(`Corroborando que el campo Sueldo se encuentre vacío`);
    if (!ValidarCamposVacios("txtSueldo")) {
        console.log(`Ok...\n`);

        let valorSueldo: number = parseInt((<HTMLInputElement>document.getElementById("txtSueldo")).value);
        let valorCboTurno: string = ObtenerTurnoSeleccionado();
        let sueldoMaximo: number = ObtenerSueldoMaximo(valorCboTurno);

        console.log("Corroborando que el valor del Sueldo se encuentre entre los parámetros correctos");

        let rangoNumericoCorrecto = ValidarRangoNumerico(valorSueldo, 8000, sueldoMaximo);
        if (rangoNumericoCorrecto) {
            (<HTMLInputElement>document.getElementById("txtSueldoError")).style.display = "none";
            console.log("Ok...\n");
        }

        else {
            AdministrarSpanError("txtSueldoError", !rangoNumericoCorrecto);
            console.log("Error en txt sueldo");
        }

    } else {
        AdministrarSpanError("txtSueldoError", true);
        console.log("Campo Sueldo está vacío");
    }


    /* #endregion */

    /* #region  SEXO */
    console.log(`Corroborando que el campo Sexo sea correcto`);
    let valorCombo = (<HTMLInputElement>document.getElementById("cboSexo")).value;
    let comboCorrecto: boolean = ValidarCombo(valorCombo, "---");
    if (comboCorrecto) {
        (<HTMLInputElement>document.getElementById("cboSexoError")).style.display = "none";
        console.log("Ok...\n");
    }
    else {
        AdministrarSpanError("cboSexoError", !comboCorrecto);
        console.log("No se ha seleccionado el Sexo");
    }

    /* #endregion */

    /* #region  FOTO */
    console.log(`Corroborando que el campo FOTO no se encuentre vacío`);
    let foto: string = (<HTMLInputElement>document.getElementById("txtFoto")).value;
    camposVacios = ValidarCamposVacios("txtFoto");
    if (!camposVacios) {
        (<HTMLInputElement>document.getElementById("txtFotoError")).style.display = "none";
        console.log("Ok...\n");

    }
    else {
        AdministrarSpanError("txtFotoError", camposVacios);
        console.log("No se ha seleccionado ninguna foto");
    }

    /* #endregion */

    let verificarValidaciones = VerificarValidacionesLogin();
    if (verificarValidaciones) {
        retorno = true;
    }

    return retorno;
}
/* #endregion */

/* #region  VALIDACIONES 04 */
let AdministrarValidacionesLogin: Function = (): void => {

    console.log(`Validando que el campo DNI no se encuentre vacío`);
    if (!ValidarCamposVacios(`txtDni`)) {
        console.log(`Ok..!`);

        console.log(`Corroborando que el DNI se encuentre dentro de los parámetros establecidos`);
        let valorDni: number = parseInt((<HTMLInputElement>document.getElementById("txtDni")).value);
        let rangoNumericoCorrecto: boolean = ValidarRangoNumerico(valorDni, 1000000, 55000000);
        let valorSpan: string;
        if (!rangoNumericoCorrecto) {
            alert(`El valor del DNI ${valorDni} está fuera del rango permitido!`);
            AdministrarSpanError("errorTxtDni", !rangoNumericoCorrecto);
        }

        else {
            (<HTMLInputElement>document.getElementById("errorTxtDni")).style.display = "none";
            console.log(`Ok...`);
        }
    }
    else
        alert("El campo DNI está vacío!!");

    console.log("Validando que el campo APELLIDO no se encuentre vacío");
    if (!ValidarCamposVacios("txtApellido")) {
        console.log("Ok..!");
        console.log(`Corroborando que el APELLIDO contenga solo letras...`);
        let valorApellido: string = (<HTMLInputElement>document.getElementById("txtApellido")).value;

        let letrasValidas: boolean = ValidarLetras(valorApellido);
        if (!letrasValidas) {
            alert(`El valor del APELLIDO ${valorApellido} no contiene solo letras!`);
            AdministrarSpanError("errorTxtApellido", !letrasValidas);
        }

        else {
            (<HTMLInputElement>document.getElementById("errorTxtApellido")).style.display = "none";
            console.log(`Ok...`);
        }
    }
    else
        alert("El campo APELLIDO está vacío!!");

    let validacionesSpan: boolean = VerificarValidacionesLogin();
    if (validacionesSpan)
        console.log(`Se han pasado todas las validaciones!!`);
    else
        alert("Error, no se han pasado todas las validaciones!");

}
/* #endregion */

/* #region  FUNCIONES */

let AdministrarModificar:Function = (dniEmpleado:string):void => {
    (<HTMLInputElement>document.getElementById("inputHidden")).value = dniEmpleado;
    let formularioHidden:HTMLFormElement = <HTMLFormElement>document.getElementById("formularioHidden"); 
    formularioHidden.submit();
    console.log("formularioHidden enviado hacia index.php!!");
}


let campo: HTMLInputElement;
///Modifica el display de un valor de un valor tomado desde un ID.
let AdministrarSpanError: Function = (txt: string, error: boolean): void => {
    if (error) {
        (<HTMLInputElement>document.getElementById(txt)).style.display = "block";
    }
}

let VerificarValidacionesLogin: Function = (): boolean => {
    let retorno: boolean = true;
    let i: number = 0;
    let valorDisplay: string
    let camposFormulario: HTMLCollectionOf<HTMLSpanElement> = document.getElementsByTagName("span");
    for (i; i < camposFormulario.length; i++) {
        valorDisplay = camposFormulario[i].style.display;
        if (valorDisplay == "block") {
            retorno = false;
            break;
        }
    }
    return retorno;
}

// Corrobora que un campo esté vacío.
// Si está vacío retorna true, sino false.
let ValidarCamposVacios: Function = (cadena: string): boolean => {
    let retorno: boolean = false;
    let campoStr: string = (<HTMLInputElement>document.getElementById(cadena)).value;
    if (campoStr.length == 0)
        retorno = true;

    return retorno;
}
//Valida un rango numérico. 
// Si el valor ingresado se encuentra dentro de los parámetros esperados
// del mínimo y el máximo, retorna true, sino false.
let ValidarRangoNumerico: Function = (valor: number, minimo: number, maximo: number): boolean => {
    let retorno: boolean = false;
    if (valor >= minimo && valor <= maximo && valor != null && valor != NaN)
        retorno = true;

    return retorno;
}

//Valida que el valor seleccionado del combobox sea distinto de un valor pasado como parámetro
// retorna true si es distinto, sino false
let ValidarCombo: Function = (valorCombo: string, valorComboIncorrecto: string): boolean => {

    let retorno: boolean = false;
    if (valorCombo != valorComboIncorrecto)
        retorno = true;

    return retorno;

}

let ObtenerTurnoSeleccionado: Function = (): number => {
    let retorno: number = 0;
    let valorRdio: NodeListOf<HTMLElement> = document.getElementsByName("rdoTurno");

    valorRdio.forEach(element => {
        if ((<HTMLInputElement>element).checked)
            retorno += parseInt((<HTMLInputElement>element).value);
    });


    return retorno;
}

let ObtenerSueldoMaximo: Function = (turno: string): number => {
    let sueldoMaximo: number = 0;
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
}

///Valida que un string ingresa sea solo letras.
let ValidarLetras: Function = (str: string): boolean => {
    let retorno: boolean = false;
    let cantidadStr = str.length;

    //Toma como letras a las que van desde la a hasta la z y las vocales con acento
    //Además con el caracter especial \s tiene en cuenta los espacios.
    //Si pusiera \S no tendría en cuenta los espacios.
    //g: global, es decir que tiene en cuenta a toda la cadena.
    //i: Tiene en cuenta tanto las mayúsculas como las minúsculas

    let letrasIngresadas: RegExpMatchArray | null = str.match(/[A-ZÁ-Ú\s]/gi);
    if (letrasIngresadas != null)
        if (cantidadStr == letrasIngresadas.length)
            retorno = true;

    return retorno;
}
/* #endregion */

// }