let tableUsuarios;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
	tableUsuarios = $('#tableUsuarios').dataTable({
		"aProcessing":true,
		"aServerSide":true,
		"language":{
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":" "+base_url+"/Usuarios/getUsuarios",
			"dataSrc":""
 		},
 		"columns":[
 			{"data":"idpersona"},
 			{"data":"nombres"},
 			{"data":"apellidos"},
 			{"data":"email_user"},
 			{"data":"telefono"},
 			{"data":"nombrerol"},
 			{"data":"status"},
 			{"data":"options"}
 		],
 		"columnDefs": [
 			{ 'className': "textcenter", "targets": [ 6 ] }
 		],
 		'dom': 'lBfrtip',
 		'buttons': [
 			{
 				"extend": "copyHtml5",
 				"text": "<i class='far fa-copy'></i> Copiar",
 				"titleAttr": "Copiar",
 				"className": "btn btn-secondary",
 				"exportOptions": {
 					"columns": [0,1,2,3,4,5,6]
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
 					"columns": [0,1,2,3,4,5,6]
 				}
 			},
 			{
 				"extend": "pdfHtml5",
 				"text": "<i class='fas fa-file-pdf'></i> PDF",
 				"titleAttr": "Exportar a PDF",
 				"className": "btn btn-danger",
 				"exportOptions": {
 					"columns": [0,1,2,3,4,5,6]
 				}
 			},
 			{
 				"extend": "csvHtml5",
 				"text": "<i class='fas fa-file-csv'></i> CSV",
 				"titleAttr": "Exportar a CSV",
 				"className": "btn btn-info",
 				"exportOptions": {
 					"columns": [0,1,2,3,4,5,6]
 				}
 			}

 		],
 		"resonsieve":"true",
 		"bDestroy":"true",
 		"iDisplayLength":10,
 		"order":[[0,"desc"]], 
 		"initComplete":function(){
			// fntRolesUsuario();
			// fntViewUsuario();
			// fntEditUsuario();
			// fntDelUsuario();
 		}
	});


	if(document.querySelector("#formUsuario")){
		// funcion para crear usuarios
		let formUsuario = document.querySelector("#formUsuario");
		formUsuario.onsubmit = function(e){
			e.preventDefault();
			let strIdentificacion = document.querySelector('#txtIdentificacion').value;
			let strNombre = document.querySelector('#txtNombre').value;
			let strApellido = document.querySelector('#txtApellido').value;
			let intTelefono = document.querySelector("#txtTelefono").value;
			let strEmail = document.querySelector("#txtEmail").value;
			let intTipousuario = document.querySelector("#listRolid").value;
			let strPassword = document.querySelector("#txtPassword").value;
			let intStatus = document.querySelector("#listStatus").value;

			if(strIdentificacion == '' || strNombre == ''  || strApellido == '' || strEmail == '' || intTelefono == '' ){
				swal("Atencion", "Todos los campos son obligatorios.", "error");
				return false;
			}

			let elementsValid = document.getElementsByClassName("valid");
			for(let i = 0; i < elementsValid.length; i++)
			{
				if(elementsValid[i].classList.contains('is-invalid'))
				{
					swal("Atencion", "Por favor verifique los campos en rojo.", "error");
					return false;
				}
			}
			divLoading.style.display = "flex";

			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Usuarios/setUsuario';
			let formData = new FormData(formUsuario);
			request.open("POST",ajaxUrl,true);
			request.send(formData);

			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200)
				{
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						if(rowTable == ""){
							tableUsuarios.api().ajax.reload();
						}else{
							htmlStatus = intStatus == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactico</span>';
							rowTable.cells[1].textContent = strNombre;
							rowTable.cells[2].textContent = strApellido;
							rowTable.cells[3].textContent = strEmail;
							rowTable.cells[4].textContent = intTelefono;
							rowTable.cells[5].textContent = document.querySelector("#listRolid").selectedOptions[0].text;
							rowTable.cells[6].innerHTML = htmlStatus;
						}
						$('#modalFormUsuario').modal('hide');
						formUsuario.reset();
						swal("Usuarios", objData.msg , "success");
					}else{
						swal("Error", objData.msg, "error");
					}
				}
				divLoading.style.display = "none";
              	return false;
			}

		}
	}

	// Actualizar perfil
	if(document.querySelector("#formPerfil")){
		let formPerfil = document.querySelector("#formPerfil");
		formPerfil.onsubmit = function(e){
			e.preventDefault();
			let strIdentificacion = document.querySelector('#txtIdentificacion').value;
			let strNombre = document.querySelector('#txtNombre').value;
			let strApellido = document.querySelector('#txtApellido').value;
			let intTelefono = document.querySelector("#txtTelefono").value;
			let strPassword = document.querySelector("#txtPassword").value;
			let strPasswordConfirm = document.querySelector("#txtPasswordConfirm").value;

			if(strIdentificacion == '' || strNombre == ''  || strApellido == '' || intTelefono == '' ){
				swal("Atencion", "Todos los campos son obligatorios.", "error");
				return false;
			}

			if(strPassword != "" || strPasswordConfirm != ""){
				if( strPassword != strPasswordConfirm  ){
					swal("Atencion", "Las contraseñas no son iguales.", "info");
					return false;
				}
				if(strPassword.length < 5){
					swal("Atencion", "La contraseña debe tener un minimo de 5 caracteres.","info");
					return false;
				}
			}

			let elementsValid = document.getElementsByClassName("valid");
			for(let i = 0; i < elementsValid.length; i++)
			{
				if(elementsValid[i].classList.contains('is-invalid'))
				{
					swal("Atencion", "Por favor verifique los campos en rojo.", "error");
					return false;
				}
			}
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Usuarios/putPerfil';
			let formData = new FormData(formPerfil);
			request.open("POST",ajaxUrl,true);
			request.send(formData);

			request.onreadystatechange = function(){
				if(request.readyState != 4 ) return; 
				if(request.status == 200)
				{
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						$('#modalFormPerfil').modal("hide");
						swal({
							title: "",
							text: objData.msg,
							type: "success",
							confirmButtonText: "Aceptar",
							closeOnConfirm: false,
						}, function(isConfirm) {
							if(isConfirm){
								location.reload();
							}
						});
					}else{
						swal("Error", objData.msg, "error");
					}
				}
				divLoading.style.display = "none";
              	return false;
			}

		}
	}

	// Actualizar datos fiscales
	if(document.querySelector("#formDataFiscal")){
		let formDataFiscal = document.querySelector("#formDataFiscal");
		formDataFiscal.onsubmit = function(e){
			e.preventDefault();
			let strNit = document.querySelector('#txtNit').value;
			let strNombreFiscal = document.querySelector('#txtNombreFiscal').value;
			let strDirFiscal = document.querySelector('#txtDirFiscal').value;

			if(strNit == '' || strNombreFiscal == ''  || strDirFiscal == ''){
				swal("Atencion", "Todos los campos son obligatorios.", "error");
				return false;
			}
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Usuarios/putDFiscal';
			let formData = new FormData(formDataFiscal);
			request.open("POST",ajaxUrl,true);
			request.send(formData);

			request.onreadystatechange = function(){
				if(request.readyState != 4 ) return; 
				if(request.status == 200)
				{
					let objData = JSON.parse(request.responseText);
					if(objData.status)
					{
						$('#modalFormDataFiscal').modal("hide");
						swal({
							title: "",
							text: objData.msg,
							type: "success",
							confirmButtonText: "Aceptar",
							closeOnConfirm: false,
						}, function(isConfirm) {
							if(isConfirm){
								location.reload();
							}
						});
					}else{
						swal("Error", objData.msg, "error");
					}
				}
				divLoading.style.display = "none";
              	return false;
			}

		}
	}
}, false);

window.addEventListener('load', function(){
	fntRolesUsuario();
	// fntViewUsuario();
	// fntEditUsuario();
	// fntDelUsuario();
}, false);

// Funcion para mostrar los roles
function fntRolesUsuario(){
	if(document.querySelector("#listRolid")){
		let ajaxUrl = base_url+'/Roles/getSelectRoles';
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
		request.open("GET",ajaxUrl,true);
		request.send();

		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				document.querySelector('#listRolid').innerHTML = request.responseText;
				// document.querySelector('#listRolid').value = 1;
				// Con jquery se selecciona el elemento con el id listRolid y con render se actualiza para cargar los registros
				$('#listRolid').selectpicker('render');
			}
		}
	}
}

// Funcion para ver los usuarios
function fntViewUsuario(idpersona)
{
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				let estadoUsuario = objData.data.status == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactico</span>'; 

				document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
				document.querySelector("#celNombre").innerHTML = objData.data.nombres;
				document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
				document.querySelector("#celTelefono").innerHTML= objData.data.telefono;
				document.querySelector("#celEmail").innerHTML = objData.data.email_user;
				document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombrerol;
				document.querySelector("#celEstado").innerHTML = estadoUsuario;
				document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
				$('#modalViewUser').modal('show');
			}else{
				swal("Error", objData.msg , "error")
			}
		}
	}

}

// Funcion para editar los usuarios
function fntEditUsuario(element, idpersona)
{
	// Se selecciona el elemento y con el parentNode se va hacia afuera de la etiqueta
	// Ejemplo si esta <div><h1>Hola</h1></div>, entonces con un parentNode saldria del h1 y se encontraria dentro del div y con otro saldria del div
	rowTable = element.parentNode.parentNode.parentNode;
	document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";



	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200)
		{
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				document.querySelector("#idUsuario").value = objData.data.idpersona;
				document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
				document.querySelector("#txtNombre").value = objData.data.nombres;
				document.querySelector("#txtApellido").value = objData.data.apellidos;
				document.querySelector("#txtTelefono").value = objData.data.telefono;
				document.querySelector("#txtEmail").value = objData.data.email_user;
				document.querySelector("#listRolid").value = objData.data.idrol;
				$('#listRolid').selectpicker('render');

				if(objData.data.status == 1)
				{
					document.querySelector("#listStatus").value = 1;
				}else{
					document.querySelector("#listStatus").value = 2;
				}
				$('#listStatus').selectpicker('render');
			}
		}

		$('#modalFormUsuario').modal('show');
	}

}

function fntDelUsuario(idpersona){
	
	swal({
		title: "Eliminar Usuario",
		text: "¿Realmente quiere eliminar el Usuario?",
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
			let ajaxUrl = base_url+'/Usuarios/delUsuario';
			// Se crea la variable strData donde se asigna el parametro que se va a enviar
			let strData = "idUsuario="+idpersona;
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
						tableUsuarios.api().ajax.reload();
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


function openModal(){
	rowTable = "";
	document.querySelector('#idUsuario').value="";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
	document.querySelector('#formUsuario').reset()
	$('#modalFormUsuario').modal('show');

}

function openModalPerfil(){
	$('#modalFormPerfil').modal('show');
}