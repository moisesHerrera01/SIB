<?php
  $atributos = array(
    'class' => 'form-horizontal stepMe',
    'role' => 'form',
    'enctype'=>"multipart/form-data"
  );
  echo $this->breadcrumb->build_breadcrump($this->uri->uri_string());

  echo "<div class='content-form'>";
    echo "<div class='limit-content-title'>";
      echo "<span class='icono icon-paste icon-title'> Nueva solicitud de compra</span>";
    echo "</div>";
    echo "<div class='limit-content'>";
      echo form_open("/Compras/Solicitud_Compra/RecibirDatos", $atributos);

      $fun = array(
          'name' => 'autocomplete4',
          'placeholder' => 'INGRESE FUENTE DE FONDOS',
          'class' => "form-control",
          'autocomplete' => 'off'
      );

      $dat= array(
          'name' => 'fecha',
          'placeholder' => 'Escribe la fecha de ingreso',
          'class' => "form-control",
          'type'=>'date'
      );

      $sol = array(
          'name' => 'autocomplete1',
          'placeholder' => 'Ingrese nombre del solicitante',
          'class' => "form-control",
          'autocomplete' => 'off'
      );

      $cargo = array(
          'name' => 'cargo',
          'placeholder' => 'Ingrese Cargo del solicitante',
          'class' => "form-control",
      );

      $linea = array(
          'name' => 'linea',
          'placeholder' => 'Ingrese la dependencia',
          'class' => "form-control",
      );

      $auto = array(
          'name' => 'autocomplete2',
          'placeholder' => 'Ingrese nombre del autorizante',
          'class' => "form-control",
          'autocomplete' => 'off'
      );

      $cargo_auto = array(
          'name' => 'cargo_auto',
          'placeholder' => 'Cargo del autorizante',
          'class' => "form-control",
      );

      $dep_auto = array(
          'name' => 'dep_auto',
          'placeholder' => 'Dependencia del autorizante',
          'class' => "form-control",
      );

      $admin = array(
          'name' => 'autocomplete3',
          'placeholder' => 'Propuesta de administrador OC',
          'class' => "form-control",
          'autocomplete' => 'off'
      );

      $cargo_admin = array(
          'name' => 'cargo_admin',
          'placeholder' => 'Cargo del administrador OC',
          'class' => "form-control",
      );

      $dep_admin = array(
          'name' => 'dep_admin',
          'placeholder' => 'Dependencia del administrador OC',
          'class' => "form-control",
      );

      $just = array(
        'name' => 'justificacion',
        'placeholder' => 'ESCRIBA LA JUSTIFICACION ',
        'class' => "form-control",
        "rows" => "3"
      );

      $esp = array(
          'id'=>"archivo",
          'name' => 'archivo',
          'enctype'=>"multipart/form-data",
          'style' => "display: none;"
      );

      $val = array(
          'name' => 'valor',
          'placeholder' => 'Ingrese valor estimado',
          'class' => "form-control"
      );

      $for= array(
        'name' => 'forma',
        'placeholder' => 'INGRESE LA FORMA DE ENTREGA',
        'class' => "form-control",
      );

      $lug= array(
        'name' => 'lugar',
        'placeholder' => 'INGRESE EL LUGAR DE ENTREGA',
        'class' => "form-control",
      );

      $otra= array(
        'name' => 'otras',
        'placeholder' => 'INGRESE OTRAS CONDICIONES NECESARIAS',
        'class' => "form-control",
        'rows'=>'2'
      );

      $obs= array(
        'name' => 'comentario',
        'placeholder' => 'INGRESE OBSERVACIONES',
        'class' => "form-control",
        'value' => 'N/A',
        'rows'=>'2'
      );

      $atriLabel = array('class' => 'col-lg-2 control-label');
      $button = array('class' => 'btn btn-success',);

    echo "<fieldset>";
      echo "<legend>Paso 1: Solicitante, Autorizante y Fuente de Fondos.</legend>";

      echo "<div class='form-group'>";
        echo form_label('Fuente:', 'fun', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($fun);
          echo form_hidden('fuentes');
          echo '<div id="suggestions4" class="suggestions"></div>';
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Fecha:', 'dat', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($dat);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Solicitante:', 'sol', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($sol);
          echo form_hidden('sol');
          echo '<div id="suggestions1" class="suggestions"></div>';
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Cargo:', 'cargo', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($cargo);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Dependencia:', 'linea', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($linea);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Autorizante:', 'auto', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($auto);
          echo form_hidden('auto');
          echo '<div id="suggestions2" class="suggestions"></div>';
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Cargo:', 'cargo_auto', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($cargo_auto);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Dependencia:', 'dep_auto', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($dep_auto);
        echo "</div>";
      echo "</div>";
    echo "</fieldset>";

    echo "<fieldset>";
      echo "<legend>Paso 2: Administrador OC, Justificación y Adjuntos.</legend>";
      echo "<div class='form-group'>";
        echo form_label('Admin OC:', 'admin', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($admin);
          echo form_hidden('admin');
          echo '<div id="suggestions3" class="suggestions"></div>';
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Cargo:', 'cargo_admin', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($cargo_admin);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Dependencia:', 'dep_admin', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($dep_admin);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Justificación:', 'just', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_textarea($just);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Adjuntar: ', 'esp', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo "<div class='input-group'>";
            echo "<label class='input-group-btn'>";
              echo '<span class="btn btn-primary">Buscar&hellip;';
                echo form_upload($esp);
              echo '</span>';
            echo "</label>";
            echo '<input id="file_name" name="file_name" type="text" class="form-control" readonly style="margin-top: 0.25em;">';
          echo "</div>";
        echo "</div>";
      echo "</div>";
    echo "</fieldset>";

    echo "<fieldset>";
      echo "<legend>Paso 3: Condiciones.</legend>";
      echo "<div class='form-group'>";
        echo form_label('Valor:', 'val', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($val);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Forma:', 'for', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($for);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Lugar:', 'lug', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($lug);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Otras condiciones:', 'otra', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_textarea($otra);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Observaciones:', 'obs', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_textarea($obs);
        echo "</div>";
      echo "</div>";

      echo form_hidden('id');
      echo form_submit('','Siguiente', $button);

      echo "<button class='btn btn-warning' type='reset' value='Reset'>Limpiar</button>";

      echo "</fieldset>";
      echo form_close();
      echo "</div>";
      echo "<div class='barra_carga'>";
      echo "</div>";
    echo "</div>";

  $buscar = array(
    'name' => 'buscar',
    'type' => 'search',
    'placeholder' => 'Buscar id',
    'class' => 'form-control',
    'autocomplete' => 'off',
    'id' => 'buscar',
    'url' => 'index.php/Compras/Solicitud_Compra/mostrarTabla'
  );

  echo "<div class='content_buscar'>";
  echo form_input($buscar);
  echo "</div>";
?>