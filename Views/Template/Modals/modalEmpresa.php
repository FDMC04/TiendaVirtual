<div class="modal fade" id="modalFormEmpresa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title fs-5" id="titleModal">Nueva Empresa</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="title-body">
              <form id="formEmpresa" name="formEmpresa" class="form-horizontal">
              <input type="hidden" name="idEmp" id="idEmp" value="">
                <p class="text-primary">Todos los campos son obligatorios</p>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="txtNombreEmp">Nombre de la empresa:</label>
                    <input type="text" class="form-control" id="txtNombreEmp" name="txtNombreEmp" required="">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="txtRFC">RFC:</label>
                    <input type="text" class="form-control valid validText" id="txtRFC" name="txtRFC" required="">
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
                  <div class="form-group col-md-12">
                    <label for="listStatus">Estado</label>
                    <select name="listStatus" id="listStatus" class="form-control selectpicker" required>
                      <option value="1">Activo</option>
                      <option value="2">Inactivo </option>
                    </select>
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



<!-- <div class="modal fade" id="modalViewUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
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
</div> -->

