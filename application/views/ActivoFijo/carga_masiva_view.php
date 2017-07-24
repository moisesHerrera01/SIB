
<style media="screen">
  .cargar_masiva, .response {
    display: none;
    margin-left: 15em;
  }

  .mensaje_carga, .mensaje_subida {
    display: inline-block;
    position: relative;
    min-width: 10em;
  }
</style>

<form class='form-horizontal' enctype='multipart/form-data'>
  <label class="btn btn-success btn-file">
    Seleccion Archivo&hellip; <input type="file" id="archivo" name="archivo" style="display: none;">
  </label>
  <div class="messages"></div>
  <p></p>
  <input id="subir" class='btn btn-success' type='button' name='subir' value='Subir Archivo'>
  <div class="mensaje_subida"></div>
</form>

<div class='content_table table-responsive'></div>

<div class="cargar_masiva">
  <p>El archivo ha sido cargado.</p>
  <button id="cargar" class='btn btn-success' type="button" name="button">Carga Masiva</button>
  <div class="mensaje_carga"></div>
</div>

<div class="response"></div>
