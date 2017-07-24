<?php

echo $this->breadcrumb->build_breadcrump(implode('/', array_slice($this->uri->segment_array(), 0, 4)));

echo "<div style='text-align:center'>";
    echo "<div class='form-group'>";
    echo "<h3><font color=black>Total de solicitudes por nivel</font></h3>";
  echo "</div>";
echo "</div>";

$minFecha= array(
    'name' => 'minFecha',
    'placeholder' => 'Escribe la fecha de inicio',
    'class' => "form-control",
    'type'=>'date'
);

$maxFecha= array(
    'name' => 'maxFecha',
    'placeholder' => 'Escribe la fecha de fin',
    'class' => "form-control",
    'type'=>'date'
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
    echo form_open("/Compras/Reportes/Reporte_total_solicitudes/Recibirfechas", $atributos);

      echo "<div class='form-group'>";
        echo form_label('Fecha Inicial:', 'minFecha', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($minFecha);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Fecha Final:', 'maxFecha', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($maxFecha);
        echo "</div>";
      echo "</div>";

      echo form_submit('','Generar', $button);
    echo form_close();
  echo "</div>";
echo "</div>";


/*echo "<div class='content-form'>";
    echo form_open("/Compras/Reportes/Reporte_total_solicitudes/mostrarTabla", $atributos);
    echo form_close();
echo "</div>";*/
?>
