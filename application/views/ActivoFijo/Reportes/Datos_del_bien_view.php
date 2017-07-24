<?php

echo $this->breadcrumb->build_breadcrump(implode('/', array_slice($this->uri->segment_array(), 0, 4)));

echo "<div style='text-align:center'>";
    echo "<div class='form-group'>";
    echo "<h3><font color=black>4-Reporte de datos del bien</font></h3>";
  echo "</div>";
echo "</div>";

$bien = array(
    'name' => 'autocomplete',
    'placeholder' => 'DESCRIPCIÓN O CÓDIGO DEL BIEN',
    'class' => "form-control",
    'autocomplete' => 'off'
);

$button = array('class' => 'btn btn-success',);
$atriLabel = array('class' => 'col-lg-2 control-label');

$atributos = array(
  'class' => 'form-horizontal',
  'role' => 'form',
);

echo "<div class='content-form'>";
  echo "<div class='limit-content-title'>";
    echo "<span class='icono icon-filter icon-title'> Filtro</span>";
  echo "</div>";
  echo "<div class='limit-content'>";
    echo form_open("/ActivoFijo/Reportes/Datos_del_bien/RecibirDatosBien", $atributos);

      echo "<div class='form-group'>";
        echo form_label('Bien:', 'fun', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($bien);
          echo form_hidden('bien');
          echo '<div id="suggestions" class="suggestions"></div>';
        echo "</div>";
      echo "</div>";

      echo form_submit('','Generar', $button);
    echo form_close();
  echo "</div>";
echo "</div>";
?>