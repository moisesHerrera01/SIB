<div class="modal fade" role="dialog" id="asignacion_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Asignación a</h4>
      </div>
      <div class="modal-body">
        <form id="asignacion" class="form-horizontal" action="" method="post">

          <div class='form-group'>
            <label class="col-lg-2 control-label">Asignado a: </label>
            <div class='col-lg-10'>
              <input class="form-control" type="text" name="autocomplete" placeholder="Ingrese nombre del colaborador" autocomplete="off">
              <input type="hidden" name="empleado">
              <input type="hidden" name="id">
              <div id="suggestions" class="suggestions"></div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <span>
          <button type="button" name="asignar" class="btn btn-success" data-dismiss="modal">Aceptar</button>
          <button type="reset" name="cerrar" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </span>
      </div>
    </div>
  </div>
</div>
