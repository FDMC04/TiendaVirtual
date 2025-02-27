<?php   
  headerAdmin($data); 
  getModal('modalEmpresa',$data);
  getModal('modalEmpUsuario',$data);    
?>
    <main class="app-content">
        <div class="app-title">
        <div>
            <h1>
            <i class="fa-solid fa-user-tag"></i> 
            <?= $data['page_title'] ?>
            
            <?php if($_SESSION['permisosMod']['w']){ ?>
            <button class="btn btn-primary" type="button" onclick="openModalEmp();"><i class="fa-solid fa-plus"></i> Agregar Empresa</button>
            <button class="btn btn-secondary" type="button" onclick="openModalUsu();"><i class="fa-solid fa-plus"></i> Agregar Usuario de Empresa</button>
            <?php } ?>
            </h1>
            <p>Start a beautiful journey here</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/ec"><?= $data['page_title'] ?></a></li>
        </ul>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="listEmpid">Empresa:</label>
                <select data-live-search="true" name="listEmpid" id="listEmpid" class="form-control" required>
                </select>
            </div>
        </div>
        <br>
        <div class="row">
        <div class="col-md-12">
            <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableEc">
                    <thead>
                    <tr>
                        <!-- SIGMA -->
                        <th>ID</th>
                        <!-- KOBREX NO TIENE REMISION -->
                        <th># REMISION</th>
                        <!--  -->
                        <!-- HTR / OSFOC -->    
                        <!-- Tendra la clase notBlock -->
                        <th>REPORTE</th>
                        <!--  -->
                        <th>DESCRIPCION</th>
                        <th>USUARIO</th>
                        <th>FECHA COT</th>
                        <th>COTIZACION</th>
                        <!-- OSFOC NO TIENE ORDEN DE COMPRA, ENTONCES LE TENGO QUE AGREGAR LA CLASE notBlock para que desaparezca cuando se cambie al cliente OSFOC -->
                        <th>OC</th>
                        <!--  -->
                        <th>FACTURA</th>
                        <th>IMPORTE</th>
                        <th>IMPORTE + IVA</th>
                        <th>ABONO</th>
                        <th>RESTANTE</th>
                        <th>FECHA DE PAGO</th>
                        <!-- SWF -->
                         <!-- TENDRA LA CLASE notBlock para aparecerla y desaparecerla al cambiar en el tipo de cliente a SWF -->
                        <th>COMPLEMENTO DE PAGO</th>
                        <!--  -->
                        <th>STATUS</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
        </div>
    </main>
<?php footerAdmin($data); ?>