<?php

  $atributos = array(
    'class' => 'form-horizontal stepMe',
    'role' => 'form'
  );

  echo $this->breadcrumb->build_breadcrump($this->uri->uri_string());

  echo "<div class='content-form'>";
    echo "<div class='limit-content-title'>";
      echo "<span class='icono icon-paste icon-title'> Orden Compra</span>";
    echo "</div>";
    echo "<div class='limit-content'>";
      echo form_open("/Compras/Orden_Compra/RecibirDatos", $atributos);

      $num = array(
          'name' => 'numero',
          'placeholder' => 'INGRESE número de orden de compra',
          'class' => "form-control"
      );

      $pro = array(
          'name' => 'autocomplete1',
          'placeholder' => 'INGRESE nombre del proveedor',
          'class' => "form-control",
          'autocomplete' => 'off'
      );

      $sol_compra = array(
          'name' => 'autocomplete2',
          'placeholder' => 'INGRESE número de Disponibilidad Financiera',
          'class' => "form-control",
          'autocomplete' => 'off'
      );

      $fecha = array(
          'name' => 'fecha',
          'placeholder' => 'Ingrese fecha de la orden de compra',
          'class' => "form-control",
          'type' =>'date'
      );

      $obs = array(
          'name' => 'obs',
          'placeholder' => 'INGRESE LAS OBSERVACIONES',
          'class' => "form-control",
          'rows' => '3'
      );

      $lu_not = array(
          'name' => 'lu_not',
          'placeholder' => 'INGRESE el lugar de notificación',
          'class' => "form-control"
      );

      $monto = array(
          'name' => 'monto_total_oc',
          'placeholder' => 'Ingrese el monto total de la orden de compra',
          'class' => "form-control",
          'type' => 'number'
      );

      $tipo= array(
          'default'=>'SELECCIONE EL TIPO DOCUMENTO',
          'ORDEN' => 'ORDEN',
          'CONTRATO' => 'CONTRATO'
      );

      $folio = array(
          'name' => 'folio',
          'placeholder' => 'Ingrese el numero de folio de la orden de compra',
          'class' => "form-control",
          'type' => 'number'
      );

      $atriLabel = array('class' => 'col-lg-2 control-label');

      $button = array('class' => 'btn btn-success',);

      echo "<fieldset>";
        echo "<legend>Paso 1: N° orden, proveedor, disponibilidad y fecha.</legend>";

      echo "<div class='form-group'>";
        echo form_label('Nº Orden Compra:', 'num', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($num);
        echo "</div>";
      echo "</div>";


      echo "<div class='form-group'>";
        echo form_label('Proveedor:', 'nom', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($pro);
          echo form_hidden('proveedor');
          echo '<div id="suggestions1" class="suggestions"></div>';
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Disponibilidad:', 'sol', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($sol_compra);
          echo form_hidden('det_disponibilidad');
          echo form_hidden('sol_compra');
          echo '<div id="suggestions2" class="suggestions"></div>';
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Fecha:', 'fecha', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($fecha);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Folio:', 'lfolio', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($folio);
        echo "</div>";
      echo "</div>";
      echo "</fieldset>";

      echo "<fieldset>";
        echo "<legend>Paso 2: Observaciones, monto, notificaciones y tipo de doc.</legend>";
      echo "<div class='form-group'>";
        echo form_label('Observación:', 'obs', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_textarea($obs);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Notificaciones:', 'lnot', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($lu_not);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Monto:', 'monto', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_input($monto);
        echo "</div>";
      echo "</div>";

      echo "<div class='form-group'>";
        echo form_label('Tipo:', 'tipo', $atriLabel);
        echo "<div class='col-lg-10'>";
          echo form_dropdown('tipo', $tipo, 'default', array('class' => 'form-control'));
        echo "</div>";
      echo "</div>";

      echo form_hidden('id');
      echo form_submit('','Guardar', $button);

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
      'placeholder' => 'Buscar por el id del req.',
      'class' => 'form-control',
      'autocomplete' => 'off',
      'id' => 'buscar',
      'url' => 'index.php/Compras/Orden_Compra/mostrarTabla'
    );

    echo "<div class='content_buscar'>";
    echo form_input($buscar);
  echo "</div>";
?>
