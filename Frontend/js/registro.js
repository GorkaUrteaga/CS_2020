let warning;

window.addEventListener('load',function(){
    let conpass = document.getElementById("confirmacion_password");
    let pass = document.getElementById("password");
    let submit = document.getElementById("registrar");
    warning = document.getElementById("warning");
    
    submit.addEventListener("click",passIguals);
    pass.addEventListener("keyup", CapsStatus);
    conpass.addEventListener("keyup", CapsStatus);

});

function CapsStatus(event){
    if (event.getModifierState("CapsLock")) {
        warning.style.display = "block";
    } else {
        warning.style.display = "none";
    }
}

function passIguals(event){
    if(password.value!=confirmacion_password.value){
        document.getElementsByClassName("error")[0].textContent = "LAS CONTRASEÑAS NO COINCIDEN!";
        event.preventDefault();
    }
}