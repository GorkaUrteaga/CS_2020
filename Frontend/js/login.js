window.addEventListener('load',function(){
    document.getElementById("showPass").addEventListener('click',mostrarPass);
    let pass = document.getElementById("password");
    let warning = document.getElementById("warning");
	
	warning.style.display = "none";
	
    pass.addEventListener("keyup", function(event) {
        if (event.getModifierState("CapsLock")) {
            warning.style.display = "block";
        } else {
            warning.style.display = "none";
        }
    
    });
});

function mostrarPass(){
    document.getElementById("password").type = (this.checked)?"text":"password";
}