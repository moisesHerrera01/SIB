<?php

  $atributos = array(
    'class' => 'form-horizontal',
    'role' => 'form'
  );

  echo $this->breadcrumb->build_breadcrump($this->uri->uri_string());

  echo "<div class='content-form'>";
    echo "<div class='limit-content-title'>";
      echo "<span class='icono icon-paste icon-title'> Oficina</span>";
    echo "</div>";
    echo "<div class='limit-content'>";
  echo form_open("/ActivoFijo/Oficinas/RecibirDatos", $atributos);

  $sa = array(
      'name' => 'autocomplete',
      'placeholder' => 'Seccion-Almacen',
      'class' => "form-control",
      'autocomplete' => 'off'
  );

  $nom = array(
      'name' => 'nombre',
      'placeholder' => 'Ingrese el nombre de la oficina',
      'class' => "form-control"
  );

  $atriLabel = array('class' => 'col-lg-2 control-label');

  $button = array('class' => 'btn btn-success',);

  echo "<div class='form-group'>";
    echo form_label('Sección-Almacen:', 'sa', $atriLabel);
    echo "<div class='col-lg-10'>";
      echo form_input($sa);
      echo form_hidden('seccion_almacen');
      echo '<div id="suggestions" class="suggestions"></div>';
    echo "</div>";
  echo "</div>";

  echo "<div class='form-group'>";
    echo form_label('Nombre:', 'nom', $atriLabel);
    echo "<div class='col-lg-10'>";
      echo form_input($nom);
    echo "</div>";
  echo "</div>";

  echo form_hidden('id');

  echo form_submit('','Guardar', $button);

  echo "<button class='btn btn-warning' type='reset' value='Reset'>Limpiar</button>";

  echo form_close();
  echo "</div>";
echo "</div>";

  $buscar = array(
    'name' => 'buscar',
    'type' => 'search',
    'placeholder' => 'Buscar',
    'class' => 'form-control',
    'autocomplete' => 'off',
    'id' => 'buscar',
    'url' => 'index.php/ActivoFijo/Oficinas/mostrarTabla'
  );

  echo "<div class='content_buscar'>";
  echo form_input($buscar);
  echo "</div>";
?>
