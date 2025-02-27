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
            <div>
                <label for="empresas">
                    <input type="radio" name="tipo_tabla" id="empresas" class="tipoTabla" checked="" value="Empresas">
                    <span>Empresas</span>
                </label>
                |
                <label for="usuarios">
                    <input type="radio" name="tipo_tabla" id="usuarios" class="tipoTabla" value="CT">
                    <span>Usuarios</span>
                </label>
            </div>
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

        <div class="row">
        <div class="col-md-12">
            <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <div id="tableEmp">
                        <table class="table table-hover table-bordered" id="tableEm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>EMPRESA</th>
                                    <th>RFC</th>
                                    <th>TELEFONO</th>
                                    <th>CORREO</th>
                                    <th>ESTADO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                    <div id="tableEmpUsuario" class=" notBlock">
                        <table class="table table-hover table-bordered" id="tableEmUsuario">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>EMPRESA</th>
                                    <th>NOMBRE COMPLETO</th>
                                    <th>TELEFONO</th>
                                    <th>CORREO</th>
                                    <th>ESTADO</th>
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
        </div>
    </main>
<?php footerAdmin($data); ?>