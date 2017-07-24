<?php
  $USER = $this->session->userdata('logged_in');

  $atributos = array(
    'class' => 'form-horizontal',
    'role' => 'form',
    'enctype'=>"multipart/form-data"
  );

  echo $this->breadcrumb->build_breadcrump($this->uri->uri_string());

  echo "<div class='content-form'>";
    echo "<div class='limit-content-title'>";
      echo "<span class='icono icon-paste icon-title'> Solicitud de Compras</span>";
    echo "</div>";
    echo "<div class='limit-content'>";
      echo form_open("/Compras/Gestionar_Solicitud/ActualizarDatos", $atributos);

      $sol = array(
          'name' => 'solicitante',
          'placeholder' => 'Solicitante',
          'class' => "form-control",
          'readonly'=>"readonly",
          //'value'=> $solicitante,
      );

      $just = array(
          'name' => 'justificacion',
          'placeholder' => 'Justificación',
          'class' => "form-control"
      );

      $val = array(
          'name' => 'valor',
          'placeholder' => 'valor estimado',
          'class' => "form-control"
      );

      $num_sol = array(
          'name' => 'numero_sol',
          'placeholder' => 'Ingrese el número de requerimiento',
          'class' => "form-control"
      );

      $req = array(
          'name' => 'autocompletecrud',
          'placeholder' => 'Seleccione el colaborador a asignar el requerimiento de compra',
          'class' => "form-control",
          'autocomplete' => 'off'
      );

      $com_c = array(
        'name' => 'comentario_compras',
        'class' => "form-control",
        "rows" => "4",
      );

      $atriLabel = array('class' => 'col-lg-2 control-label');

      $button = array('class' => 'btn btn-success',);

      echo "<div class='form-group'>";
        echo form_label('Solicitante:', 'sol', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($sol);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Justificacion:', 'just', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($just);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Valor:', 'val', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($val);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Nº Req:', 'num_sol', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($num_sol);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Asignado a:', 'asignado_crud', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($req);
          echo form_hidden('asignado');
          echo '<div id="suggestionscrud" class="suggestions"></div>';
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Comentario compras:', 'com', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_textarea($com_c);
        echo "</div>";
      echo "</div>";


      echo form_hidden('id');
      echo form_hidden('nivel');
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
    'url' => 'index.php/Compras/Gestionar_Solicitud/mostrarTabla'
  );

  echo "<div class='content_buscar'>";
  echo form_input($buscar);
  echo "</div>";


?>
