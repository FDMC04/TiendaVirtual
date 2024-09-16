let tableRoles;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function(){
	tableRoles = $('#tableRoles').dataTable({
		"aProcessing":true,
		"aServerSide":true,
		"language":{
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url": " "+base_url+"/Roles/getRoles",
			"dataSrc":""
		},
		"columns":[
			{"data":"idrol"},
			{"data":"nombrerol"},
			{"data":"descripcion"},
			{"data":"status"},
			{"data":"options"}
		],
 		"columnDefs": [
 			{ 'className': "textcenter", "targets": [ 3 ] }
 		],
		'dom': 'lBfrtip',
 		'buttons': [
 			{
 				"extend": "copyHtml5",
 				"text": "<i class='far fa-copy'></i> Copiar",
 				"titleAttr": "Copiar",
 				"className": "btn btn-secondary",
 				"exportOptions": {
 					"columns": [0,1,2,3]
 				}
 				// Esto sirve para delimitar que columnas se van a exportar
 				// "exportOptions": { 
                // "columns": [ 0, 1, 2, 3, 4, 5] 
            	// }
 			},
 			{
 				"extend": "excelHtml5",
 				"text": "<i class='fas fa-file-excel'></i> Excel",
 				"titleAttr": "Exportar a Excel",
 				"className": "btn btn-success",
 				"exportOptions": {
 					"columns": [0,1,2,3]
 				}
 			},
 			{
 				"extend": "pdfHtml5",
 				"text": "<i class='fas fa-file-pdf'></i> PDF",
 				"titleAttr": "Exportar a PDF",
 				"className": "btn btn-danger",
 				"exportOptions": {
 					"columns": [0,1,2,3]
 				}
 			},
 			{
 				"extend": "csvHtml5",
 				"text": "<i class='fas fa-file-csv'></i> CSV",
 				"titleAttr": "Exportar a CSV",
 				"className": "btn btn-info",
 				"exportOptions": {
 					"columns": [0,1,2,3]
 				}
 			}

 		],
		"resonsieve":"true",
		"bDestroy": true,
		"iDisplayLength": 10,
		"order":[[0,"desc"]], 
		"initComplete": function() {
            // Llamar a la función para asignar eventos cuando la tabla ha sido inicializada
            // fntEditRol();
            // fntDelRol();
            // fntPermisos();
            
        }
	});
	// Nuevo Rol
	let formRol = document.querySelector("#formRol");
	formRol.onsubmit = function(e){
		// Se previene que se recargue el formulario o la pagina para que no se vuelvan a enviar los datos por la url
		e.preventDefault();

		// Se crea una variable que selecciona el elemento con el id idRol y obtiene su valor
		let intIdRol = document.querySelector("#idRol").value;

		// se obtiene los valores de lo elementos a traves del id de los campos del formulario
		let strNombre = document.querySelector('#txtNombre').value;
		let strDescripcion = document.querySelector('#txtDescripcion').value;
		let intStatus = document.querySelector('#listStatus').value;
		// Se verifica que los campos no se envien vacios
		if(strNombre == '' || strDescripcion == '' || intStatus == '')
		{
			// De ser asi se envia un alert para avisar que se encuentran vacios
			swal("Atencion", "Todos los campos son obligatorios.", "error");
			return false;
		}
		divLoading.style.display = "flex";
		// Validacion donde se detecta si se encuentra en un navegador chrome o firefox, de ser asi se crea un elemento xmlhttp, si se encuentra en edge se crea un elemento activexobject
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		// Se crea una variable que nos dirige al metodo setRol
		let ajaxUrl = base_url+'/Roles/setRol';
		// Se hace referencia al formulario con formData
		let formData = new FormData(formRol);
		// Por medio del request se abre, se coloca el metodo por el que se envia la informacion, se le asigna a donde se dirige con la variable ajaxUrl
		request.open("POST",ajaxUrl,true);
		// Se envia la informacion almacenada en la variable formdata
		request.send(formData);
		// Se detona una funcion para obtener la informacion
		request.onreadystatechange = function(){
			// Si el requeste nos devuelve un ready state de 4 y el estatus es 200 es porque si llego la informacion
			if(request.readyState == 4 && request.status == 200){
				// Se obtiene el formato json para convertirlo en un objeto de javascript
				let objData = JSON.parse(request.responseText);
				// Si el status es verdadeto (true)
				if(objData.status)
				{
					if(rowTable == ""){
							// Se refresca el datatables
							tableRoles.api().ajax.reload();	
						}else{
							htmlStatus = intStatus == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactico</span>';
							rowTable.cells[1].textContent = strNombre;
							rowTable.cells[2].textContent = strDescripcion;
							rowTable.cells[3].innerHTML = htmlStatus;
						}
					// Se cierra el modal
					$('#modalFormRol').modal("hide");
					// resetear el formulario
					formRol.reset();
					// Se muestra una alerta con el mensaje del objeto con el msg
					swal("Roles de usuario", objData.msg , "success");
					
				}else{
					// Si el status no es verdadero se muestra un mensaje de error
					swal("Error", objData.msg , "error");
				}
			}
			divLoading.style.display = "none";
          	return false;
		}
	}
});

$('#tableRoles').DataTable();

function openModal(){
	rowTable = "";
	// Se selecciona el elemento que tiene el id idRol y se vacia su valor para no causar problemas cada vez que se abre el formulario
	document.querySelector('#idRol').value = "";
	// Se selecciona el elemento que tiene la clase modal-header y se cambia la clase headerUpdate por la clase headerRegister
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	// Se selecciona el elemento con la clase btnActionForm y se cambia la clase btn-info por la clase btn-primary
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	// Se selecciona el elemento con el id btnText y se cambia el texto con el innerHTML
	document.querySelector('#btnText').innerHTML = "Guardar";
	// Se selecciona el elemento con el id titleModal y se cambia el texto con el innerHTML
	document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
	// Se selecciona el elemento con el id formRol y se reinicia (reinicia el formulario)
	document.querySelector('#formRol').reset();


	$('#modalFormRol').modal('show');
}

// Se agrega el elemento load cuando se cargue todo el documento y se ejecuta la funcion
window.addEventListener('load', function(){
	// Se manda a llamar la siguiente funcion
	// fntEditRol();
	// fntDelRol();
	// fntPermisos();
	
}, false);

// Funcion para editar los roles
function fntEditRol(element, idrol){
	rowTable = element.parentNode.parentNode.parentNode;
	// Selecciona el elemento con el id tilteModal y con el innerHTML se le cambia el texto a Actualizar Rol
	document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
	// Selecciona el elemento con la clase modal-header y remplasa la clase de headerRegister a la clase headerUpdate
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	// Selecciona el elemento con el id btnActionForm y remplaza la clase de btn-primary a la clase bnt-info
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	// Selecciona el elemento con el id btnText y cambia su texto con el innerHTML 
	document.querySelector('#btnText').innerHTML = "Actualizar";

	// Scripts para ejecutar el AJAX
	// Se refiere a la variable idrol con el this y se accede con getAttribute al atributo rl
	// El atributo rl es el que se encuentra en el boton de editar
	// Se valida si estamos en un ordenador Chrome o Firefox para crear el objeto new XMLHttpRequest, pero si estan en Edge se creara el objeto ActiveXObject
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	// Se crea una variable para crear la ruta que hara funcionar el metodo
	let ajaxUrl = base_url+'/Roles/getRol/'+idrol;
	// Se abre la conexion y se envia como parametro el metodo GET, despues se envia la variable que contiene la url
	request.open("GET",ajaxUrl,true);
	// Se envia la peticion
	request.send();

	// Se obtiene la respuesta
	request.onreadystatechange = function(){
		// Se valida que la variable request tiene como readyState igual a 4 y si se envia un stado 200
		if(request.readyState == 4 && request.status == 200){
			// Se convierte a un objeto la respuesta obtenida
			let objData = JSON.parse(request.responseText);

			// Si el estado es igual a verdadero
			if(objData.status)
			{
				// Se seleccionan los elementos del formulario y se les da el valor de los datos obtenidos
				document.querySelector("#idRol").value = objData.data.idrol;
				document.querySelector("#txtNombre").value = objData.data.nombrerol;
				document.querySelector("#txtDescripcion").value = objData.data.descripcion;

				// Se valida que el estado sea igual a 1
				if(objData.data.status == 1)
				{
					// Se arma esta variable para crear una option con el valor de activo
					var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
				}else
				{
					// De lo contrario se creara esta option con el valor de inactivo
					var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
				}
				// Se crea una varia html y se le coloca la variable de optionSelect, donde se coloca la opcion de activo y de inactivo
				let htmlSelect = `${optionSelect} 
				<option value="1">Activo</option>
				<option value="2">Inactivo</option>
				`;
				// Se selecciona el elemento con el id listStatus y se le coloca la variable htmlSelect
				document.querySelector("#listStatus").innerHTML = htmlSelect;
				// Se muestra el formulario
				$('#modalFormRol').modal('show');
			}else{
				// Si no se cumple la validacion se muestra el mensaje de error
				swal("Error", objData.msg , "error");
			}
		}
	}
}

// Se crea la funcion para eliminar los registros
function fntDelRol(idrol){
	// Se crea la variable idrol que obtiene el valor del atributo rl del boton para eliminar
	
	swal({
		title: "Eliminar Rol",
		text: "¿Realmente quiere eliminar el Rol?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, eliminar!",
		cancelButtonText: "No, cancelar!",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function(isConfirm){
		// Si la varable isConfirm es verdadero se ejecuta lo siguiente
		if (isConfirm){
			// Se crea la variable request donde se valida el tipo de navegador que se utiliza para crear un objeto
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			// Se crea la variable ajaxUrl donde se manda la url del metodo que se va a utilzar
			let ajaxUrl = base_url+'/Roles/delRol';
			// Se crea la variable strData donde se asigna el parametro que se va a enviar
			let strData = "idrol="+idrol;
			// Se abre la proteccion y se indica el metodo que se va a usar, asi como la direccion
			request.open("POST",ajaxUrl,true);
			// De esta forma se van a enviar los datos
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			// Se envian los datos
			request.send(strData);
			// Se recibe la respuesta y se ejcuta la funcion
			request.onreadystatechange = function(){
				// Se valida que el readyState tenga valor de 4 y el status de 200
				if(request.readyState == 4 && request.status == 200){
					// De ser asi  se crea la variable objData donde se convierte el valor de la variable request.responseText a un objeto JSON
					let objData = JSON.parse(request.responseText);
					// Si el parametro status es verdadero se hace lo siguiente
					if(objData.status){
						// Se muestra el mensaje con el titulo Eliminar, con el mensaje que se recibio del objData
						swal("Eliminar", objData.msg , "success");
						// Se ejecuta esta funcion para cargar todos los elementos del DataTable 
						tableRoles.api().ajax.reload(function(){
							// Se cargan los eventos fntEditRol y fntDelRol
							// fntEditRol();
							// fntDelRol();
							// fntPermisos();
							
						});
						// Si el parametro status no es verdadero
					}else{
						// Se muestra el mensaje con el titulo Atencion y el mensaje que se recibio del objData
						swal("Atencion", objData.msg , "error");
					}
				}
			}
		}
	});
}

// Funcion para asignar los permisos a los roles
function fntPermisos(idrol){
	// Se crea un objeto dependiendo del navegador que se utilice
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	// Se crea la variable ajaxUrl que contiene la url del metodo que se va a utilizar y se envia el parametro idrol
	let ajaxUrl = base_url+'/Permisos/getPermisosRol/'+idrol;
	// Se abre la conexion y se envia la peticion de tipo GET enviada a la direccion de la variable ajaxUrl
	request.open("GET",ajaxUrl,true);
	// Se envia la peticion
	request.send();


	request.onreadystatechange = function(){
		// Se verifica si la variable request en el status tiene el valor de 200
		if(request.readyState == 4 && request.status == 200){
			
			// Se selecciona el elemento con el id contentAjax y se cambia su html con el innerHTML colocandole la respuesta de la variable request.
			document.querySelector('#contentAjax').innerHTML = request.responseText;
			// Se hace referencia al elemento modalPermisos y se abre
			$('.modalPermisos').modal('show');
			// Se selecciona el elemento con el id formPermisos y se le agrega el evento que activa la funcion al momento de enviar datos
			document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false);
		}
	}

}

// let formRol = document.querySelector("#formRol");
// 	formRol.onsubmit = function(e){
// 		// Se previene que se recargue el formulario o la pagina para que no se vuelvan a enviar los datos por la url
// 		e.preventDefault();

function fntSavePermisos(event){
	// Esto hace que no se recargue la pagina despues de darle clic a guardar en el formulario
	event.preventDefault();
	// Se valida que tipo de ordenador esta cargando el sistema y se crea un objeto especial para cada ordenador
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	// Se crea la direccion del metodo que se va a utiliza
	let ajaxUrl = base_url+'/Permisos/setPermisos';
	// Se selecciona el elemento con el id formPermisos y su contenido se almacena en la variable
	let formElement = document.querySelector("#formPermisos");
	// Se crea un objeto FormData que cotiene la variable formElement
	let formData = new FormData(formElement);
	// Se abre la conexion y se especifica el metodo que se ba a utilizar y la direccion a donde se enviara
	request.open("POST",ajaxUrl,true);
	// Se envia el FormData
	request.send(formData);

	// Se recibe la respuesta y se ejecuta la funcion
	request.onreadystatechange = function(){
		// Se valida que el readyState sea 4 y que tenga un status de 200
		if(request.readyState == 4 && request.status == 200){
			// Se convierte la respuesta en un objeto de tipo JSON y se guarda en la variable
			let objData = JSON.parse(request.responseText);
			// Se verifica que el status sea igual a verdadero
			if(objData.status){
				// Y se muestran los mensajes
				swal("Permisos de usuario", objData.msg, "success");
			}else{
				swal("Error", objData.msg, "error");
			}
		}
	}
}

// // Llamar a la función para asignar eventos cuando los datos se cargan dinámicamente
// $(document).on('click', '.btnEditRol', function() {
//     $('#modalFormRol').modal('show');
// });