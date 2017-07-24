var not = 0;
var max = 2;
var activo = 0;

$(document).ready(function() {

  $('html').click(function () {
    $('.container-area-notice').slideUp();
    $('.tgs').slideUp();
    activo = 0;
  });

  $('.container-area-notice').click(function (e) {
    e.stopPropagation();
  });

  $('#notice').click(function (e) {
    if (1 == activo) {

      $('.container-area-notice').slideUp();
      $('.tgs').slideUp();
      activo = 0;

    } else if (0 == activo) {

      $('.container-area-notice').slideDown();
      $('.tgs').slideDown();
      Notificaciones();
      activo = 1;

    }

    e.stopPropagation();
  });

  TotalNotificaciones();
  setInterval(function() {
      TotalNotificaciones();
  }, 60000);
});

var getLocation = function() {
  var arrayLocation = String(window.location).split('/');
  return arrayLocation[5];
}


var Notificaciones = function() {
  var elemet = $(this);
  var content = $('.content-area-notice');
  $.ajax({
    type: 'post',
    dataType: 'json',
    url: baseurl + "index.php/CNotificacion/ConsultarNotificaciones",
    //data: {},
    success: function(result) {
      var mensaje = "";
      var i;
      if (result) {
        for (i = 0; i < result.length; i++) {
          mensaje += "<div class='alert alert-notification alert-dismissable'>";
            mensaje += "<button type='button' class='close' data-id='"+result[i].id_notificacion+"' data-dismiss='alert'>&times;</button>";
            mensaje += "<a href="+result[i].url_notificacion+"><div class='cont-icon " + GenerarIcon(result[i].url_notificacion) + "'></div>" ;
            mensaje += "<div class='cont-notice'>"+result[i].mensaje_notificacion+"</div>" ;
          mensaje += "</a></div>";
        }
      } else {
        mensaje = "<div class='content-no-notice'>Has leído todas las notificaciones</div>";
      }

      content.html(mensaje);

      $('.close').click(function() {
        var id = $(this).data('id');
        $(this).parent().hide(400);
        $.ajax({
          type: 'post',
          data: { id: id },
          url: baseurl + "index.php/CNotificacion/EliminarDato",
          success: function(result) {
            $('#notice .badge').text(result);
          }
        });
      });
    },
  });
}

var GenerarIcon = function (url) {
  var urls = url.split('/');
  var icon = "";
  switch (urls[5]) {
    case "Compras":
      icon = "icon-compra";
      break;
    case "Bodega":
      icon = "icon-database";
      break;
    case "ActivoFijo":
      icon = "icon-office";
      break;
    default:
      icon = "icon-bell";
  }
  return icon;
}

var Notificacion = function() {
  var elemet = $(this);
  var content = $('.content-notice');
  $.ajax({
    type: 'post',
    dataType: 'json',
    url: baseurl + "index.php/CNotificacion/ConsultarNotificaciones",
    success: function(result) {
      var mensaje = "";
      for (var i = 0; i < result.length; i++) {
        mensaje += "<div class='alert alert-"+ result[i].clase_notificacion +" alert-dismissable' style='display: 'none''><a href="+result[i].url_notificacion+">";
          mensaje += "<button type='button' class='close' data-id='"+result[i].id_notificacion+"' data-dismiss='alert'>&times;</button>";
          mensaje += result[i].mensaje_notificacion;
        mensaje += "</a></div>";
        if (max == i) {
            break;
            max = 2;
        }
      }

      content.html(mensaje);

      $(".content-notice .alert").slideDown();
      setInterval(function() {
          $(".content-notice .alert").slideUp();
      }, 5000);
    },
  });
}

var TotalNotificaciones = function () {
  var elemet = $(this);
  var content = $('.content-area-notice');
  $.ajax({
    type: 'post',
    dataType: 'json',
    url: baseurl + "index.php/CNotificacion/TotalNotificaciones",
    success: function(result) {
      $('#notice .badge').text(result);
      if (result > not) {
          max = 0;
          Notificacion();
      }
      not = result;
    },
  });
}
