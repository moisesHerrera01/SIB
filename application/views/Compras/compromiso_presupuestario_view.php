<?php
  $atributos = array(
    'class' => 'form-horizontal stepMe',
    'role' => 'form'
  );
  echo $this->breadcrumb->build_breadcrump($this->uri->uri_string());
  echo "<div class='content-form'>";
    echo "<div class='limit-content-title'>";
      echo "<span class='icono icon-paste icon-title'> Compromiso Presupuestario  </span>";
    echo "</div>";
    echo "<div class='limit-content'>";
      echo form_open("/Compras/Compromiso_Presupuestario/RecibirDatos", $atributos);
      $num = array(
          'name' => 'numero',
          'placeholder' => 'Ingrese el número de compromiso presupuestario',
          'class' => "form-control"
      );
          $ord = array(
          'name' => 'autocomplete4',
          'placeholder' => 'INGRESE EL NÚMERO DE ORDEN DE COMPRA',
          'class' => "form-control",
          'autocomplete' => 'off'
        );
      $atriLabel = array('class' => 'col-lg-2 control-label');
      $button = array('class' => 'btn btn-success',);
      echo "<div class='form-group'>";
        echo form_label('Compromiso:', 'num', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($num);
        echo "</div>";
      echo "</div>";
          echo "<div class='form-group'>";
            echo form_label('Nº Orden:', 'ord', $atriLabel);
            echo "<div class='col-lg-10'>";
              echo form_input($ord);
              echo form_hidden('orden_compra');
              echo '<div id="suggestions4" class="suggestions"></div>';
            echo "</div>";
          echo "</div>";
      echo form_hidden('id');
        //echo form_hidden('seccion');
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
    'url' => 'index.php/Compras/Compromiso_Presupuestario/mostrarTabla'
  );
  echo "<div class='content_buscar'>";
  echo form_input($buscar);
  echo "</div>";
?>
