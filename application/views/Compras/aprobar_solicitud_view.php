<?php
  $USER = $this->session->userdata('logged_in');

  $atributos = array(
    'class' => 'form-horizontal',
    'role' => 'form',
    'enctype'=>"multipart/form-data"
  );

  echo $this->breadcrumb->build_breadcrump($this->uri->uri_string());

  $buscar = array(
    'name' => 'buscar',
    'type' => 'search',
    'placeholder' => 'Buscar id',
    'class' => 'form-control',
    'autocomplete' => 'off',
    'id' => 'buscar',
    'url' => 'index.php/Compras/Aprobar_Solicitud/mostrarTabla'
  );

  echo "<div class='content_buscar'>";
  echo form_input($buscar);
  echo "</div>";
?>
