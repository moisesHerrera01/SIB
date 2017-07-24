$(document).ready(function(){
  //abrir modal
  $('.modal_open').click(open_modal);
  $('.modal_open_asignacion').click(open_modal_asignacion);

  $.autocomplete({
    elemet: $('input[name=autocompletecrud]'),
    url: 'index.php/Compras/Gestionar_Solicitud/autocompleteColaboradores',
    name: 'asignado',
    siguiente: 'comentario_compras',
    content: 'suggestionscrud'
  });
});

function open_modal() {
  var id_sol = $(this).data('id');
  $.ajax({
    type: 'post',
    dataType: 'json',
    data: {id : id_sol},
    url: baseurl + "index.php/Compras/Solicitud_Compra/ConsultarSolicitudJson",
    success: function(result) {
      $(".modal .modal-dialog .modal-content .modal-body #cmt1").val(result[0].jefe);
      $(".modal .modal-dialog .modal-content .modal-body #cmt2").val(result[0].autorizante);
      $(".modal .modal-dialog .modal-content .modal-body #cmt3").val(result[0].compras);
    },
  });
  $("#cmt-modal").modal('toggle');
}

function open_modal_asignacion() {

  $.autocomplete({
    elemet: $('#asignacion_modal input[name=autocomplete]'),
    url: 'index.php/Compras/Gestionar_Solicitud/autocompleteColaboradores',
    name: 'empleado',
    siguiente: 'cerrar',
    content: 'suggestions'
  });

  $("#asignacion_modal").modal('toggle');

  var id_sol = $(this).data('id');
  var id_empleado = $(this).data('empleado');
  $.ajax({
    type: 'post',
    dataType: 'json',
    data: {id : id_empleado},
    url: baseurl + "index.php/Usuario_Rol/obtenerEmpleadoJSON",
    success: function(result) {
      $("#asignacion_modal .modal-dialog .modal-content .modal-body input[name=autocomplete]").val(result.nombre_empleado);
      $("#asignacion_modal .modal-dialog .modal-content .modal-body input[name=empleado]").val(id_empleado);
      $("#asignacion_modal .modal-dialog .modal-content .modal-body input[name=id]").val(id_sol);
    },
  });

  $('button[name=asignar]').click(function () {
    var formData = new FormData($("#asignacion")[0]);
    $.ajax({
        url: baseurl + "index.php/Compras/Gestionar_Solicitud/asignarEmpleadoSolicitud",
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
          $("#asignacion-"+id_sol).html($("#asignacion_modal .modal-dialog .modal-content .modal-body input[name=autocomplete]").val());
        }
    });
  });
}
