<div class="modal fade modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title h4">Permisos Roles de Usuarios</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>

      <div class="modal-body">
        
        <div class="col-md-12">
          <div class="tile">
            <form action="" id="formPermisos" name="formPermisos">
              <!-- Input que tiene el valor de idrol -->
              <input type="hidden" id="idrol" name="idrol" value="<?= $data['idrol'] ?>" required="">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Modulo</th>
                      <th>Ver</th>
                      <th>Crear</th>
                      <th>Actualizar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $no=1;
                      // Variable igual a data ingresando al item modulos
                      $modulos = $data['modulos'];
                      for($i=0; $i < count($modulos); $i++){
                        // Se crea la variable permisos que es igual a la variable modulos en su posicion e ingresa al item permisos
                        $permisos = $modulos[$i]['permisos'];
                        // Se crean las variables que son iguales a la condicion, si la variable permisos en el item (r, w, u o d) es igual a 1 entonces se le da el valor de checked
                        $rCheck = $permisos['r'] == 1 ? " checked " : "";
                        $wCheck = $permisos['w'] == 1 ? " checked " : "";
                        $uCheck = $permisos['u'] == 1 ? " checked " : "";
                        $dCheck = $permisos['d'] == 1 ? " checked " : "";

                        // Se le asigna el valor de la variable modulos en el item idmodulo dependiendo de la ubicacion ($i)
                        $idmod = $modulos[$i]['idmodulo'];
                      
                    ?>
                    <tr>
                      <td>
                        <?= $no; ?>
                        <input type="hidden" name="modulos[<?= $i; ?>][idmodulo]" value="<?= $idmod ?>" required>
                      </td>
                      <td>
                        <?= $modulos[$i]['titulo']; ?>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?= $i; ?>][r]" <?= $rCheck; ?> ><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?= $i; ?>][w]" <?= $wCheck; ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?= $i; ?>][u]" <?= $uCheck; ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?= $i; ?>][d]" <?= $dCheck; ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                    </tr>
                    <?php  
                        $no++;
                      }
                    ?>
                  </tbody>
                </table>
              </div>

              <div class="text-center">
                <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i> Guardar</button>
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="app-menu__iconc fas fa-sign-out-alt" aria-hidden="true"></i> Salir</button>
              </div>
            </form>
          </div>
        </div>
      </div>    

    </div>
  </div>
</div>