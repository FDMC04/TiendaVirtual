let tablePedidos;
let rowTable;
tablePedidos = $('#tablePedidos').dataTable({
    "aProcessing":true,
    "aServerSide":true,
    "language":{
        "url":"//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url":" "+base_url+"/Pedidos/getPedidos",
        "dataSrc":""
     },
     "columns":[
         {"data":"idpedido"},
         {"data":"transaccion"},
         {"data":"fecha"},
         {"data":"monto"},
         {"data":"tipopago"},
         {"data":"status"},
         {"data":"options"}
     ],
     "columnDefs": [
         { 'className': "textcenter", "targets": [ 3 ] },
         { 'className': "textright", "targets": [ 4 ] },
         { 'className': "textcenter", "targets": [ 5 ] },
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

function fntTransaccion(idtransaccion){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Pedidos/getTransaccion/'+idtransaccion;
    divLoading.style.display = "flex";
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            if(objData.status){
                document.querySelector("#divModal").innerHTML = objData.html;
                $('#modalReembolso').modal('show');
            }else{
                swal("Error", objData.msg, "error");
            }
            divLoading.style.display = "none";
            return false;
        }
    }
}

function fntReembolsar(){
    let idtransaccion = document.querySelector("#idtransaccion");
    let observacion = document.querySelector("#txtObservacion");
    if(idtransaccion == '' || observacion == ''){
        swal("", "Complete los datos para continuar.", "error");
        return false;       
    }
    swal({
		title: "Hacer Reembolso",
		text: "¿Realmente quiere realizar el reembolso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, reembolsar!",
		cancelButtonText: "No, cancelar!",
		closeOnConfirm: true,
		closeOnCancel: true,
	}, function(isConfirm){
        if(isConfirm){
            $('#modalReembolso').modal('hide');
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Pedidos/setReembolso';
            let formData = new FormData();
            formData.append('idtransaccion', idtransaccion.value);
            formData.append('observacion', observacion.value);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4) return;
                if(request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status){
                        window.location.reload();
                    }else{
                        swal("Error", objData.msg, "error");
                    }
                    divLoading.style.display = "none";
                    return false;
                }
            }
        }
    });

}


function fntEditInfo(element,$idpedido){
    rowTable = element.parentNode.parentNode.parentNode;
    // console.log(rowTable);
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Pedidos/getPedido/'+$idpedido;
    divLoading.style.display = "flex";
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                document.querySelector("#divModal").innerHTML = objData.html;
                $('#modalFormPedido').modal('show');
                $('select').selectpicker();
                fntUpdateInfo();
            }else{
                swal("Error", objData.msg, "error");
            }
            divLoading.style.display = "none";
            return false;
        }
    }
}

function fntUpdateInfo(){
    let formUpdatePedido = document.querySelector("#formUpdatePedido");
    formUpdatePedido.onsubmit = function(e){
        e.preventDefault();
        let transaccion;
        if(document.querySelector("#txtTransaccion")){
            transaccion = document.querySelector("#txtTransaccion").value;
            if(transaccion == ""){
                swal("", "Complete los datos para continuar.", "error");
                return false;
            }
        }
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Pedidos/setPedido/';
        divLoading.style.display = "flex";
        let formData = new FormData(formUpdatePedido);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4) return;
            if(request.status == 200){
                // console.log(request.responseText);
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    swal("",objData.msg,"success");
                    $('#modalFormPedido').modal('hide');
                    if(document.querySelector("#txtTransaccion")){
                        rowTable.cells[1].textContent = document.querySelector("#txtTransaccion").value;
                        rowTable.cells[4].textContent = document.querySelector("#listTipopago").selectedOptions[0].innerText;
                        rowTable.cells[5].textContent = document.querySelector("#listEstado").value;
                    }else{
                        rowTable.cells[5].textContent = document.querySelector("#listEstado").value;
                    }
                }else{
                    swal("Error",objData.msg,"error");
                }

                divLoading.style.display = "none";
                return false;
            }
        }
    }
}