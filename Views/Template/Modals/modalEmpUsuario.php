<div class="modal fade" id="modalFormEmpUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title fs-5" id="titleModal">Nueva Usuario de Empresa</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="title-body">
              <form id="formEmpUsuario" name="formEmpUsuario" class="form-horizontal">
              <input type="hidden" name="idUemp" id="idUemp" value="">
                <p class="text-primary">Todos los campos son obligatorios</p>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="listEmpid">Empresa:</label>
                    <select data-live-search="true" name="listEmpid" id="listEmpid" class="form-control" required>
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="txtNombreU">Nombre:</label>
                    <input type="text" class="form-control valid validText" id="txtNombreU" name="txtNombreU" required="">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="txtTelUsuario">Teléfono</label>
                    <input type="text" class="form-control valid validNumber" id="txtTelUsuario" name="txtTelUsuario" required="" onkeypress="return controlTag(event);">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="txtCorreo">Email</label>
                    <input type="email" class="form-control valid validEmail" id="txtCorreo" name="txtCorreo" required="">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="listEstado">Status</label>
                    <select name="listEstado" id="listEstado" class="form-control selectpicker" required>
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



