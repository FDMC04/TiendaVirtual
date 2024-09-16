
// Funcion para bloquear todas las teclas y solo permitir teclear numeros
function controlTag(e)
{	
	// Dentro de la variable tecla se captura lo que se esta escribiendo con la funcion keyCode
	tecla = (document.all) ? e.keyCode : e.which;
	// Se valida si la variable tecla es igual a 8 que corresponde en el keyCode a la tecla para borrar, de ser asi se va a permitir
	// En pocas palabras permite al usuario usar la tecla para borrar
	if(tecla == 8) return true;
	// Si la tecla es 0 o 9 (tabulador) si se puede usar
	else if(tecla == 0 || tecla == 9) return true;
	// La variable patron es para permitir utilizar numeros del 0 al 9
	patron =/[0-9\s]/;
	// a la variable n se le pasa como parametro la tecla que se esta precionando
	n = String.fromCharCode(tecla);
	// returna la tecla solo cuando cumple con el patron
	return patron.test(n);
}

// funcion para delimitar lo que se puede escribir en los campos de tipo str
function testText(txtString){
	// Se guarda dentro de la variable el objeto RegExp que solo permite letras de la A a la Z
	var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$/);
	// Se valida que lo que se esta escribiendo cumpla con el parametro anterior
	if(stringText.test(txtString)){
		// Se regresa un true si cumple
		return true;
	}else{
		// O un falsa en caso de que no cumpla con el parametro
		return false;
	}
}

// Funcion para que solo permita cierta cantidad de digitos
function testEntero(intCant)
{
	// Se le asigna a la variable una expresion regular que solo permite numeros del 0 al 9
	var intCantidad = new RegExp(/^([0-9]*$)/);
	// Se valida que se cumpla con la expresion
	if(intCantidad.test(intCant)){
		return true;
	}else{
		return false;
	}
}

// Funcion para validar el email
function fntEmailValidate(email){
	// Se guarda dentro de la variable el objeto con la expresion regular que solo permite lo siguiente
	var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
	if(stringEmail.test(email) == false){
		return false;
	}else{
		return true;
	}
}

// Funcion para asignarles las validaciones a cada campo de los modals de tipo Text
function fntValidText(){
	let validText = document.querySelectorAll(".validText");
	validText.forEach(function(validText){
		validText.addEventListener('keyup', function(){
			let inputValue = this.value; 
			if(!testText(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		});
	});
}
// Funcion para asignar las validaciones a los campos de tipo Int
function fntValidNumber(){
	let validNumber = document.querySelectorAll(".validNumber");
	validNumber.forEach(function(validNumber){
		validNumber.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testEntero(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		});
	});
}

// Funcion para validar el email
function fntValidEmail(){
	let validEmail = document.querySelectorAll(".validEmail");
	validEmail.forEach(function(validEmail){
		validEmail.addEventListener('keyup', function (){
			let inputValue = this.value;
			if(!fntEmailValidate(inputValue))
			{
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		});
	});
}

window.addEventListener('load', function(){
	fntValidText();
	fntValidEmail();
	fntValidNumber();
}, false);