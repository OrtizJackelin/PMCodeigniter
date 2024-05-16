var alertPlaceholder = "";
var formularioValido=true;
//Se Ejecuta Despues de Descargar el DOM (HTML)
document.addEventListener("DOMContentLoaded", () => {
 
    const inputs = document.querySelectorAll("input");
    alertPlaceholder = document.getElementById('liveAlertPlaceholder');
    var enviar = document.querySelector("#enviar");
    var send = document.querySelector("#send");



    inputs.forEach(
        function(myinput){
            myinput.addEventListener("blur",validarInputs);
        }
    );
    if(enviar != null) {
        enviar.addEventListener("click", function(event) {
            event.preventDefault(); // Evita el envío predeterminado del formulario
            validarFormulario(event);
            
        });
    }  
    if(send != null) {
        send.addEventListener("click", function(event) {
            event.preventDefault(); // Evita el envío predeterminado del formulario
            validarFormularioIniciarSesion(event);
            
        });
    }
});

function validar(){
    var rol = document.getElementsByName("rol[]");
    var algunoMarcado = false;
    for (var i = 0; i < rol.length; i++) {
        if (rol[i].checked) {
            algunoMarcado = true;
            break;
        } else {
            alert('Debe seleccionar al menos un rol: Validador/Editor', 'warning');
            return false;
        }
    }
    return true;
}

function validarFormulario(event){

    var formulario= document.querySelector("#formularioCrearUsuario");
    if (formulario.checkValidity() && formularioValido && validar()){
        formulario.submit();     
    }
    else{
        formulario.reportValidity();
    }

}

function validarFormularioIniciarSesion(event){

    var formulario= document.querySelector("#formularioIniciarSesion");
    if (formulario.checkValidity() && formularioValido){
        formulario.submit();     
    }
    else{
        formulario.reportValidity();
    }

}

function validarInputs(event){

    var resultado=event.target.checkValidity();

    if(event.target.id ==='email'){
        resultado= validarEmail(event.target.value);     
    }

    if(event.target.id==='clave'){

        resultado= validarClave(event.target.value);
    }
    if(event.target.id==='repetirClave'){

        resultado= validarRepetirClave(event.target.value, document.getElementById("clave").value);
    }

    if(resultado){

        formularioValido=true;        
        event.target.style.borderColor="#ced4da";

    }else{
        formularioValido=false;
        event.target.style.borderColor="crimson";
    }   
}

function validarEmail(email){

    console.log("Entrando en la validación de correo electrónico");
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(regex.test(email)) {
            return true;
        } else {
            alert('El correo electrónico no es válido. Asegúrate de que tenga el formato correcto.','warning');
            return false; 
        }   
}


function validarClave(clave){
    console.log("Entrando en la validación de clave");
    var regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#$%^&+=!])(?!.*\s).{8,}$/;
    if(regex.test(clave)) {
        return true;
    } else {
        alert('La clave no coincide con el patrón (Patrón: al menos A-Z,a-z,#$%&+=,0123456789. minimo 8 digitos)','warning');
        return false; 
    }
    

        /*Esta expresión regular exige lo siguiente:
        Al menos una letra mayúscula.
        Al menos una letra minúscula.
        Al menos un número.
        Al menos un carácter especial (puedes personalizar la lista de caracteres especiales).
        No contiene espacios en blanco.
        Tiene una longitud mínima de 8 caracteres (puedes ajustar este número).
        Aquí tienes una breve explicación de los componentes de la expresión regular:

        ^: Coincide con el inicio de la cadena.
        (?=.*[A-Z]): Busca al menos una letra mayúscula.
        (?=.*[a-z]): Busca al menos una letra minúscula.
        (?=.*\d): Busca al menos un número.
        (?=.*[@#$%^&+=!]): Busca al menos uno de los caracteres especiales en la lista (puedes personalizarlos).
        (?!.*\s): Asegura que no haya espacios en blanco en la cadena.
        .{8,}: Asegura que la longitud de la cadena sea al menos 8 caracteres.
        $: Coincide con el final de la cadena.*/
    
}
function validarRepetirClave(repetirClave, clave){
    console.log("Entrando en la validación de repetir clave");
    console.log(repetirClave);
    console.log(clave);
    if(repetirClave===clave){
        return true;
    }else{
        alert('La clave no coincide.', 'warning');
        return false;
    }
    
}

function alert(message, type) {
    console.log("entro en alert");
    var wrapper = document.createElement('div')
    wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">'+
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">'+
        '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>'+
    '</svg>'+
     message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
  
    alertPlaceholder.append(wrapper)
}



