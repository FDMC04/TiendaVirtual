<div class="modal fade" id="modalFormUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title fs-5" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="title-body">
              <form id="formUsuario" name="formUsuario" class="form-horizontal">
                <input type="hidden" name="idUsuario" id="idUsuario" value="">
                <p class="text-primary">Todos los campos son obligatorios</p>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="txtIdentificacion">Identificación</label>
                    <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" required="">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="txtNombre">Nombres</label>
                    <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="txtApellido">Apellidos</label>
                    <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="txtTelefono">Teléfono</label>
                    <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="txtEmail">Email</label>
                    <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="listRolid">Tipo usuario</label>
                    <!-- data-live-search crea un buscador es una funcion del archivo bootstrap-select -->
                    <select data-live-search="true" name="listRolid" id="listRolid" class="form-control" required>
                      
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="listStatus">Status</label>
                    <!-- La clase selectpicker es del archivo bootstrap-select -->
                    <select name="listStatus" id="listStatus" class="form-control selectpicker" required>
                      <option value="1">Activo</option>
                      <option value="2">Inactivo </option>
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="txtPassword">Password</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                  </div>
                </div>

                <div class="tile-footer">
                  <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;

                  <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                </div>
              </form>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modalViewUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title fs-5" id="titleModal">Datos del usuario</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificacion:</td>
              <td id="celIdentificacion"></td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre"></td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="celApellido"></td>
            </tr>
            <tr>
              <td>Teléfono:</td>
              <td id="celTelefono"></td>
            </tr>
            <tr>
              <td>Email (Usuario):</td>
              <td id="celEmail"></td>
            </tr>
            <tr>
              <td>Tipo Usuario:</td>
              <td id="celTipoUsuario"></td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado"></td>
            </tr>
            <tr>
              <td>Fecha Registro:</td>
              <td id="celFechaRegistro"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

