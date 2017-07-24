var activo = 0;
var url;

$(document).ready(function() {
   url = $(this).attr('title');

  $('html').click(function () {
    $('.container-area-help').slideUp();
    $('.tgsh').slideUp();
    activo = 0;
  });

  $('.container-area-help').click(function (e) {
    e.stopPropagation();
  });

  $('#help').click(function (e) {
    if (1 == activo) {

      $('.container-area-help').slideUp();
      $('.tgsh').slideUp();
      activo = 0;

    } else if (0 == activo) {

      $('.container-area-help').slideDown();
      $('.tgsh').slideDown();
      activo = 1;

    }

    e.stopPropagation();
  });

  $('#bug').click(function() {
    $('.container-area-help').hide();
    $('.tgsh').hide();
    activo = 0;

    html2canvas($("html"), {
      onrendered: function(canvas) {
        theCanvas = canvas;
        //$('#image_bug').html(canvas);
        var dataUrl = canvas.toDataURL("image/png");
        $.ajax({
            url: baseurl + "index.php/Help/seveScreen",
            data:{
                img: dataUrl
            },
            type: 'POST',
            success: function(data)
            {
              if (data != '') {
                $("#screenshot").attr('src',  baseurl + 'uploads/' + data + '.jpg');
                $('#image-screenshot').val(data + '.jpg');
                $('#asunto-report').val('Reportar problema: ' + url);
              }
            }
        });
      },
      height: 200,
      timeout: 50000,
      width: 200,
    });

    $("#email-report-modal").modal('toggle');
  });

  $('button[name=enviar]').click(function () {
    var formData = new FormData($("#mail")[0]);
    $.ajax({
        url: baseurl + "index.php/Help/sendMail",
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(){
          $(".messages").show();
          $(".messages").html("<span class='success'>Enviando...</span>");
        },
        success: function(data){
          $("#email-report-modal").modal('toggle');
          alert("Mensaje enviado.");
        },
        //si ha ocurrido un error
        error: function(){
          $("#email-report-modal").modal('toggle');
          alert("Error en el envio.");
        }
    });
  });

  $('button[name=cerrar]').click(function () {
    var formData = new FormData($("#mail")[0]);
    $.ajax({
        url: baseurl + "index.php/Help/eliminarImagen",
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(){
        },
        success: function(data){
        },
        //si ha ocurrido un error
        error: function(){
        }
    });
  });

});

