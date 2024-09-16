<div class="modal fade" id="modalFormCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title fs-5" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="tile">
            <div class="title-body">
              <form id="formCliente" name="formCliente" class="form-horizontal">
                <input type="hidden" name="idUsuario" id="idUsuario" value="">
                <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="txtIdentificacion">Identificación <span class="required">*</span></label>
                    <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" required="">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="txtNombre">Nombres <span class="required">*</span></label>
                    <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="txtApellido">Apellidos <span class="required">*</span></label>
                    <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="txtTelefono">Teléfono <span class="required">*</span></label>
                    <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="txtEmail">Email <span class="required">*</span></label>
                    <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="txtPassword">Password</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                  </div>
                </div>
                <hr>
                <p class="text-primary">Datos Fiscales</p>
                <div class="form-row">
                  <div class="form-group col-md-6">
                      <label>Identificación Tributaria <span class="required">*</span></label>
                      <input class="form-control" type="text" id="txtNit" name="txtNit" required="">
                  </div>
                  <div class="form-group col-md-6">
                      <label>Nombre fiscal <span class="required">*</span></label>
                      <input class="form-control" type="text" id="txtNombreFiscal" name="txtNombreFiscal" required="">
                  </div>  
                  <div class="form-group col-md-12">
                      <label>Dirección Fiscal <span class="required">*</span></label>
                      <input class="form-control" type="text" id="txtDirFiscal" name="txtDirFiscal" required="">
                    </div>
                </div>

                <div class="form-row">
                  
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



<div class="modal fade" id="modalViewCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title fs-5" id="titleModal">Datos del cliente</h5>
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
              <td>Identificación Tribunal:</td>
              <td id="celIde"></td>
            </tr>
            <tr>
              <td>Nombre Fiscal:</td>
              <td id="celNomFiscal"></td>
            </tr>
            <tr>
              <td>Dirección Fiscal:</td>
              <td id="celDirFiscal"></td>
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

