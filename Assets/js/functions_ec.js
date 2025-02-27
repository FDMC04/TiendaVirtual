let tableInventario;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
    tableInventario = $('#tableEc').dataTable({
		"aProcessing":true,
		"aServerSide":true,
		"language":{
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url":" "+base_url+"/Ec/getArticulos",
			"dataSrc":""
 		},
 		"columns":[
 			{"data":"idarticulo"},
 			{"data":"remision"},
 			{"data":"reporte"},
 			{"data":"descripcion"},
 			{"data":"usuarioid"},
 			{"data":"fechacot"},
 			{"data":"cotizacion"},
 			{"data":"oc"},
 			{"data":"factura"},
 			{"data":"importe"},
 			{"data":"iva"},
 			{"data":"abono"},
 			{"data":"restan"},
 			{"data":"fechapago"},
 			{"data":"complemento"},
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
			// fntEmpresa();
			// fntViewUsuario();
			// fntEditUsuario();
			// fntDelUsuario();
 		}
	});

	$('#listEmpid').on('change', function() {
		let empresa = $(this).val();
	
		if (empresa == "1") {
			tableInventario.api().columns([6, 7, 8, 9, 10]).visible(true); // Mostrar estas columnas
			tableInventario.api().columns([11, 12, 13, 14]).visible(false); // Ocultar estas columnas
		} else {
			tableInventario.api().columns([6, 7, 8, 9, 10]).visible(false); // Ocultar estas columnas
			tableInventario.api().columns([11, 12, 13, 14]).visible(true); // Mostrar estas columnas
		}
	});
	

	if(document.querySelector("#formEmpresa")){
		// funcion para crear usuarios
		let formEmpresa = document.querySelector("#formEmpresa");
		formEmpresa.onsubmit = function(e){
			e.preventDefault();
			let strNombre = document.querySelector('#txtNombreEmp').value;
			let strRFC = document.querySelector('#txtRFC').value;
			let intTelefono = document.querySelector("#txtTelefono").value;
			let strEmail = document.querySelector("#txtEmail").value;
            let intStatus = document.querySelector("#listStatus").value;

			if(strNombre == ''  || strRFC == '' || strEmail == '' || intTelefono == '' ){
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
			let ajaxUrl = base_url+'/Empresas/setEmpresa';
			let formData = new FormData(formEmpresa);
			request.open("POST",ajaxUrl,true);
			request.send(formData);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					try {
						let objData = JSON.parse(request.responseText);
						if (objData.status) {
							$('#modalFormEmpresa').modal('hide');
							formEmpresa.reset();
							swal("Empresa", objData.msg , "success");
						} else {
							swal("Error", objData.msg, "error");
						}
					} catch (e) {
						console.error("Error en la conversión JSON:", e);
						console.error("Texto recibido:", request.responseText);
					}
				}
				divLoading.style.display = "none";
				return false;
			}
			

		}
	}

	if(document.querySelector("#formEmpUsuario")){
		let formEmpUsuario = document.querySelector("#formEmpUsuario");
		formEmpUsuario.onsubmit = function(e){
			e.preventDefault();
			let intEmpresa = document.querySelector('#listEmpid').value;
			let strNombre = document.querySelector('#txtNombreU').value;
			let intTelefono = document.querySelector("#txtTelefono").value;
			let strEmail = document.querySelector("#txtEmail").value;
			if(intEmpresa == '' || strNombre == ''  || strEmail == '' || intTelefono == '' ){
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
			let ajaxUrl = base_url+'/Ec/setEmpUsuario';
			let formData = new FormData(formEmpUsuario);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					try {
						let objData = JSON.parse(request.responseText);
						if (objData.status) {
							$('#modalFormEmpUsuario').modal('hide');
							formEmpUsuario.reset();
							swal("Empresa", objData.msg , "success");
						} else {
							swal("Error", objData.msg, "error");
						}
					} catch (e) {
						console.error("Error en la conversión JSON:", e);
						console.error("Texto recibido:", request.responseText);
					}
				}
				divLoading.style.display = "none";
				return false;
			}
			

		}
	}



}, false);

function openModalEmp(){
	rowTable = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nueva Empresa";
	document.querySelector('#formEmpresa').reset()
	$('#modalFormEmpresa').modal('show');
}

function openModalUsu(){
	rowTable = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nueva Usuario de Empresa";
	document.querySelector('#formEmpUsuario').reset()
	$('#modalFormEmpUsuario').modal('show');
}

window.addEventListener('load', function(){
    fntEmpresaUsuario();
}, false);

function fntEmpresaUsuario(){
	if(document.querySelector("#listEmpid")){
		let ajaxUrl = base_url+'/Empresas/getSelectEmpresas';
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
		request.open("GET",ajaxUrl,true);
		request.send();
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				document.querySelector('#listEmpid').innerHTML = request.responseText;
				$('#listEmpid').selectpicker('render');
			}
		}
	}
}

// function fntEmpresa(){
// 	if(document.querySelector("#listEmpid")){
// 		let ajaxUrl = base_url+'/Roles/getSelectRoles';
// 		let request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
// 		request.open("GET",ajaxUrl,true);
// 		request.send();

// 		request.onreadystatechange = function(){
// 			if(request.readyState == 4 && request.status == 200){
// 				document.querySelector('#listRolid').innerHTML = request.responseText;
// 				// document.querySelector('#listRolid').value = 1;
// 				// Con jquery se selecciona el elemento con el id listRolid y con render se actualiza para cargar los registros
// 				$('#listRolid').selectpicker('render');
// 			}
// 		}
// 	}
// }