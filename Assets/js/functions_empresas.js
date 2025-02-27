let tableEm;
let tableEmUsuario;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
    tableEm = $('#tableEm').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language":{
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
        "ajax":{
			"url":" "+base_url+"/Empresas/getEmpresas",
			"dataSrc":""
        },
        "columns":[
            {"data":"idemp"},
            {"data":"nombreemp"},
            {"data":"rfc"},
            {"data":"telefono"},
            {"data":"correo"},
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
                    "columns": [0,1,2,3,4,5]
                }
            },
            {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0,1,2,3,4,5]
                }
            },
            {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0,1,2,3,4,5]
                }
            },
            {
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr": "Exportar a CSV",
                "className": "btn btn-info",
                "exportOptions": {
                    "columns": [0,1,2,3,4,5]
                }
            }

        ],
        "resonsieve":"true",
        "bDestroy":"true",
        "iDisplayLength":10,
        "order":[[0,"desc"]], 
        "initComplete":function(){
        }
    });

	tableEmUsuario = $('#tableEmUsuario').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language":{
			"url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
        "ajax":{
			"url":" "+base_url+"/Empresas/getEmpUsuarios",
			"dataSrc":""
        },
        "columns":[
            {"data":"idusuario"},
            {"data":"nombreemp"},
            {"data":"nombreusuario"},
            {"data":"telefono"},
            {"data":"correo"},
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
                    "columns": [0,1,2,3,4,5]
                }
            },
            {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Exportar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0,1,2,3,4,5]
                }
            },
            {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0,1,2,3,4,5]
                }
            },
            {
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr": "Exportar a CSV",
                "className": "btn btn-info",
                "exportOptions": {
                    "columns": [0,1,2,3,4,5]
                }
            }

        ],
        "resonsieve":"true",
        "bDestroy":"true",
        "iDisplayLength":10,
        "order":[[0,"desc"]], 
        "initComplete":function(){
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
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        if(rowTable == ""){
                            tableEm.api().ajax.reload();
                        }else{
                            htmlStatus = intStatus == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactico</span>';
                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = strRFC;
                            rowTable.cells[3].textContent = intTelefono;
                            rowTable.cells[4].textContent = strEmail;
                            rowTable.cells[5].innerHTML = htmlStatus;
                        }
                        $('#modalFormEmpresa').modal('hide');
                        formEmpresa.reset();
                        swal("Empresa", objData.msg , "success");
                    } else {
                        swal("Error", objData.msg, "error");
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
            let strNombreU = document.querySelector('#txtNombreU').value;
            let intTelUsuario = document.querySelector('#txtTelUsuario').value;
            let strCorreo = document.querySelector('#txtCorreo').value;
            let intEstado = document.querySelector('#listEstado').value;
            if(intEmpresa == '' || strNombreU == '' || intTelUsuario == '' || strCorreo == ''){
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
            let ajaxUrl = base_url+'/Empresas/setUsuario';
            let formData = new FormData(formEmpUsuario);
            request.open("POST",ajaxUrl,true);
            request.send(formData);

            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200)
                {
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableEmUsuario.api().ajax.reload();
                        }else{
                            htmlStatus = intEstado == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactico</span>';
                            rowTable.cells[1].textContent = intEmpresa;
                            rowTable.cells[2].textContent = strNombreU;
                            rowTable.cells[3].textContent = intTelUsuario;
                            rowTable.cells[4].textContent = strCorreo;
                            rowTable.cells[5].innerHTML = htmlStatus;
                        }
                        $('#modalFormEmpUsuario').modal('hide');
                        formEmpUsuario.reset();
                        swal("Usuarios", objData.msg, "success");
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
    fntEmpresaUsuario();
}, false);

// funcion para cargar la lista de la empresas en el modal de usuarios de empresa
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


function fntEditEmpUsuario(element, idusuario)
{
	rowTable = element.parentNode.parentNode.parentNode;
	document.querySelector('#titleModal').innerHTML = "Actualizar Usuario de Empresa";
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";

	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Empresas/getEmpUsuario/'+idusuario;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200)
		{
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				document.querySelector("#idUemp").value = objData.data.idusuario;
				document.querySelector("#listEmpid").value = objData.data.empresaid;
				$('#listEmpid').selectpicker('render');
				document.querySelector("#txtNombreU").value = objData.data.nombreusuario;
				document.querySelector("#txtTelUsuario").value = objData.data.telefono;
				document.querySelector("#txtCorreo").value = objData.data.correo;

				if(objData.data.status == 1)
				{
					document.querySelector("#listEstado").value = 1;
				}else{
					document.querySelector("#listEstado").value = 2;
				}
				$('#listEstado').selectpicker('render');
			}
		}

		$('#modalFormEmpUsuario').modal('show');
	}

}

function fntEditEmpresa(element, idemp)
{
	rowTable = element.parentNode.parentNode.parentNode;
	document.querySelector('#titleModal').innerHTML = "Actualizar Empresa";
	document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	document.querySelector('#btnText').innerHTML = "Actualizar";



	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Empresas/getEmpresa/'+idemp;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200)
		{
			let objData = JSON.parse(request.responseText);
			if(objData.status)
			{
				document.querySelector("#idEmp").value = objData.data.idemp;
				document.querySelector("#txtNombreEmp").value = objData.data.nombreemp;
				document.querySelector("#txtRFC").value = objData.data.rfc;
				document.querySelector("#txtTelefono").value = objData.data.telefono;
				document.querySelector("#txtEmail").value = objData.data.correo;

				if(objData.data.status == 1)
				{
					document.querySelector("#listStatus").value = 1;
				}else{
					document.querySelector("#listStatus").value = 2;
				}
				$('#listStatus').selectpicker('render');
			}
		}

		$('#modalFormEmpresa').modal('show');
	}

}

function fntDelEmpresa(idemp){
	
	swal({
		title: "Eliminar Empresa",
		text: "¿Realmente quiere eliminar esta empresa?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, eliminar!",
		cancelButtonText: "No, cancelar!",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function(isConfirm){
		if (isConfirm){
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Empresas/delEmpresa';
			let strData = "idEmp="+idemp;
			request.open("POST",ajaxUrl,true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(strData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status){
						swal("Eliminar", objData.msg , "success");
						tableEm.api().ajax.reload();
					}else{
						swal("Atencion", objData.msg , "error");
					}
				}
			}
		}
	});
}

function fntDelEmpUsuario(idusuario){
	
	swal({
		title: "Eliminar Usuario de Empresa",
		text: "¿Realmente quiere eliminar este usuario?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, eliminar!",
		cancelButtonText: "No, cancelar!",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function(isConfirm){
		if (isConfirm){
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Empresas/delEmpUsuario';
			let strData = "idUemp="+idusuario;
			request.open("POST",ajaxUrl,true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(strData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);
					if(objData.status){
						swal("Eliminar", objData.msg , "success");
						tableEmUsuario.api().ajax.reload();
					}else{
						swal("Atencion", objData.msg , "error");
					}
				}
			}
		}
	});
}

if(document.querySelector(".tipoTabla")){
	let tipo = document.querySelectorAll(".tipoTabla");
	tipo.forEach(function(tipo) {
		tipo.addEventListener('click', function(){
			if(this.value == "Empresas"){
				document.querySelector("#tableEmp").classList.remove("notBlock");
				document.querySelector("#tableEmpUsuario").classList.add("notBlock");
			}else{
				document.querySelector("#tableEmp").classList.add("notBlock");
				document.querySelector("#tableEmpUsuario").classList.remove("notBlock");
			}
		})
	})
}

function openModalEmp(){
	rowTable = "";
	document.querySelector('#idEmp').value="";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nueva Empresa";
	document.querySelector('#formEmpresa').reset()
	$('#modalFormEmpresa').modal('show');
}

function openModalUsu(){
	rowTable = "";
	document.querySelector('#idUemp').value="";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nueva Usuario de Empresa";
	document.querySelector('#formEmpUsuario').reset()
	$('#modalFormEmpUsuario').modal('show');
}