<div class="modal fade" role="dialog" id="email-report-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reportar problema</h4>
      </div>
      <div class="modal-body">
        <form id="mail" class="form-horizontal" action="" method="post">

          <div class='form-group'>
            <label class="col-lg-2 control-label">Asunto: </label>
            <div class='col-lg-10'>
              <input id="asunto-report" class="form-control" type="text" name="asunto" placeholder="ESCRIBE EL ASUNTO">
            </div>
          </div>

          <div class='form-group'>
            <label class="col-lg-2 control-label">Mensaje: </label>
            <div class='col-lg-10'>
              <textarea id="image_bug" class="form-control" name="msj" rows="8" cols="80" placeholder="ESCRIBE EL MENSAJE"></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Adjunto: </label>
            <div class='col-lg-10'>
              <img id="screenshot" src="" height="200" width="300">
              <input type="hidden" id="image-screenshot" name="image" value="">
            </div>
          </div>

          <div class="messages"></div>

        </form>
      </div>
      <div class="modal-footer">
        <span>
          <button type="button" class='btn btn-success' name='enviar'>Enviar</button>
          <button type="button" name="cerrar" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </span>
      </div>
    </div>
  </div>
</div>
