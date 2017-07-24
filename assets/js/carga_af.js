$(document).ready(function(){

  /*Comprobar que hay un archivo dato.json*/
   var http = new XMLHttpRequest();
   http.open('HEAD', baseurl+'/uploads/datos.json', false);
   http.send();
   if (http.status!=404) {
     $('.cargar_masiva').show();
   }

    $(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function() {
        //obtenemos un array con los datos del archivo
        var file = $("#archivo")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
    });

    //al enviar el formulario
    $('#subir').click(function() {
        //información del formulario
        var formData = new FormData($(".form-horizontal")[0]);
        var message = "";
        //hacemos la petición ajax
        $.ajax({
            url: baseurl + "index.php/ActivoFijo/Carga_masiva/cargar_archivo",
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
              $(".mensaje_subida").html("<div id='cargando' align='center' class='icono icon-spinner'></div>");
              var angulo = 0;
              setInterval(function(){
                    angulo += 3;
                   $("#cargando").rotate(angulo);
              },10);
            },
            //una vez finalizado correctamente
            success: function(data){
                $(".mensaje_subida").html("<span class='success'>El archivo ha subido correctamente.</span>");
                showMessage(message);
                $('.cargar_masiva').show();
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
    });

    $('#cargar').click(function () {
        //hacemos la petición ajax
        $.ajax({
            url: baseurl + "index.php/ActivoFijo/Carga_masiva/CargaMasiva",
            type: 'POST',
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
              $(".mensaje_carga").html("<div id='cargando' class='icono icon-spinner'></div>");
              var angulo = 0;
              setInterval(function(){
                    angulo += 3;
                   $("#cargando").rotate(angulo);
              },10);
            },
            //una vez finalizado correctamente
            success: function(data){
                $(".mensaje_carga").html("");
                result = JSON.parse(data);
                var tiempo = result.tiempo/60
                $(".response").show();
                $(".response").html("<p>Los datos han sido insertado.</p><p>Tiempo : " + tiempo.toFixed(5) +
                " min<p/><p>Datos insertados : " + result.cantidad + "<p/>");
            },
            //si ha ocurrido un error
            error: function(){
                $(".mensaje_carga").html("<span class='error'>Ha ocurrido un error.</span>");
            }
        });
    });

});

function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}