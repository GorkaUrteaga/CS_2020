$(document).ready(function(){
    aplicarListeners();
    $('#guardarButton').prop('disabled', !validacionGeneral($("input.perc")));
});


let validarReal = function (v) {
	if (typeof(v) == 'string')
	{
		if (cadenabuida(v)) 
			return false;
	}
	if (isNaN(v))
	{
			return false;
	}
	return !Number.isNaN(v);
}

function cadenabuida(str){
	return str.trim().length == 0;
}   

function aplicarListeners(){
    //$('#editButton').on("click",validacionGeneral($("input.perc")));
    $('#table_items').on('input', 'input.perc', function() {
        let errores = [];
        let percs = $('#table_items input[type="text"]');
        validacionIndividual($(this)[0]);
        $('#guardarButton').prop('disabled',!validacionGeneral($("input.perc")));
    });
}


function validacionIndividual(input){
    if(validarReal($(input).val())){
        if($(input).val()>0 && $(input).val()<=100){
            $(input).removeClass("errorInput");
            return;
        }
        $(input).addClass("errorInput");
        return;
    }
    $(input).addClass("errorInput");
    return;
}

function validacionGeneral(inputs){
    let suma=0;
    for(let i=0;i<inputs.length;i++){
        suma += parseFloat($(inputs[i]).val());
    }
    $("#js_porcentaje").text("La suma de todos los sintomas es: "+suma+"%");
    let errinputs = $(".errorInput");
    if(suma==100 && errinputs.length==0 ){
        return true;
    }
    return false;
}