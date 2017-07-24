<?php

  $atributos = array(
    'class' => 'form-horizontal stepMe',
    'role' => 'form'
  );

  echo $this->breadcrumb->build_breadcrump($this->uri->uri_string());
  echo "<div class='content-form'>";
    echo "<div class='limit-content-title'>";
      echo "<span class='icono icon-paste icon-title'> Equipo informático</span>";

    echo "</div>";
    echo "<div class='limit-content'>";
  echo form_open("/ActivoFijo/Equipo_informatico/RecibirDatos", $atributos);

  $tipo = array(
      'default' => 'TIPO COMPUTADORA',
      'LAPTOP' => 'LAPTOP',
      'DESKTOP' => 'DESKTOP',
      'SERVIDOR' => 'SERVIDOR'
  );

  $hdd = array(
      'name' => 'autocomplete3',
      'placeholder' => 'SELECCIONE LA CAPACIDAD DEL DISCO DURO',
      'class' => "form-control autocomplete",
      'autocomplete' => 'off'
  );

  $v_hdd = array(
      'name' => 'v_hdd',
      'placeholder' => 'Ingrese la velocidad del disco duro',
      'class' => "form-control"
  );

  $proc = array(
      'name' => 'autocomplete2',
      'placeholder' => 'SELECCIONE EL TIPO DE PROCESADOR',
      'class' => "form-control autocomplete",
      'autocomplete' => 'off',
  );

  $v_proc = array(
      'name' => 'v_procesador',
      'placeholder' => 'Ingrese la velocidad del procesador',
      'class' => "form-control"
  );

  $mem = array(
      'name' => 'autocomplete4',
      'placeholder' => 'SELECCIONE EL TIPO DE MEMORIA',
      'class' => "form-control autocomplete",
      'autocomplete' => 'off'
  );

  $v_mem = array(
      'name' => 'v_memoria',
      'placeholder' => 'Ingrese la velocidad de la memoria',
      'class' => "form-control"
    );

    $so = array(
        'name' => 'autocomplete5',
        'placeholder' => 'SELECCIONE LA VERSIÓN DEL SISTEMA OPERATIVO',
        'class' => "form-control autocomplete",
        'autocomplete' => 'off',
    );

    $clave_so = array(
        'name' => 'clave_so',
        'placeholder' => 'Ingrese la clave del sistema operativo',
        'class' => "form-control"
    );

    $off = array(
        'name' => 'autocomplete6',
        'placeholder' => 'SELECCIONE LA VERSIÓN DE OFFICE',
        'class' => "form-control autocomplete",
        'autocomplete' => 'off'
    );

    $clave_off = array(
        'name' => 'clave_office',
        'placeholder' => 'Ingrese la clave de office',
        'class' => "form-control"
    );

    $ip = array(
        'name' => 'ip',
        'placeholder' => 'Ingrese la dirección ip',
        'class' => "form-control"
    );

    $punto = array(
        'name' => 'punto',
        'placeholder' => 'Ingrese el número de punto',
        'class' => "form-control"
    );

  $atriLabel = array('class' => 'col-lg-2 control-label');
  $button = array('class' => 'btn btn-success');

echo "<fieldset>";
  echo "<legend>Paso 1: Tipo, HDD y CPU.</legend>";
  echo "<div class='form-group'>";
    echo form_label('Tipo:', 'tipo', $atriLabel);
    echo "<div class='col-lg-10'>";
      echo form_dropdown('tipo_computadora', $tipo, 'default', array('class' => 'form-control'));
    echo "</div>";
  echo "</div>";

        echo "<div class='form-group'>";
          echo form_label('Capacidad:', 'hdd', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($hdd);
            echo form_hidden('hdd');
            echo '<div id="suggestions3" class="suggestions"></div>';
          echo "</div>";
        echo "</div>";

        echo "<div class='form-group'>";
          echo form_label('Velocidad:', 'v_hdd', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($v_hdd);
          echo "</div>";
        echo "</div>";

        echo "<div class='form-group'>";
          echo form_label('Procesador:', 'proc', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($proc);
            echo form_hidden('procesador');
            echo '<div id="suggestions2" class="suggestions"></div>';
          echo "</div>";
        echo "</div>";

        echo "<div class='form-group'>";
          echo form_label('Velocidad:', 'v_proc', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($v_proc);
          echo "</div>";
        echo "</div>";
        echo "</fieldset>";

        echo "<fieldset>";
          echo "<legend>Paso 2: Memoria y SO.</legend>";
        echo "<div class='form-group'>";
          echo form_label('Memoria:', 'mem', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($mem);
            echo form_hidden('memoria');
            echo '<div id="suggestions4" class="suggestions"></div>';
          echo "</div>";
        echo "</div>";

        echo "<div class='form-group'>";
          echo form_label('Velocidad:', 'v_mem', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($v_mem);
          echo "</div>";
        echo "</div>";

        echo "<div class='form-group'>";
          echo form_label('Sistema operativo:', 'so', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($so);
            echo form_hidden('so');
            echo '<div id="suggestions5" class="suggestions"></div>';
          echo "</div>";
        echo "</div>";

        echo "<div class='form-group'>";
          echo form_label('Clave:', 'clave_so', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($clave_so);
          echo "</div>";
        echo "</div>";
        echo "</fieldset>";

        echo "<fieldset>";
          echo "<legend>Paso 3: Ofice y Red.</legend>";
        echo "<div class='form-group'>";
          echo form_label('Office:', 'off', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($off);
            echo form_hidden('office');
            echo '<div id="suggestions6" class="suggestions"></div>';
          echo "</div>";
        echo "</div>";

        echo "<div class='form-group'>";
          echo form_label('Clave:', 'clave_off', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($clave_off);
          echo "</div>";
        echo "</div>";

        echo "<div class='form-group'>";
          echo form_label('Ip:', 'ip', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($ip);
          echo "</div>";
        echo "</div>";

        echo "<div class='form-group'>";
          echo form_label('Punto:', 'punto', $atriLabel);
          echo "<div class='col-lg-10'>";
            echo form_input($punto);
          echo "</div>";
        echo "</div>";

  echo form_hidden('id_equipo_informatico');
  echo form_hidden('id_bien',$id_bien);

  echo form_submit('','Guardar', $button);
  echo "<button class='btn btn-warning' type='reset' value='Reset'>Limpiar</button>";
  echo form_close();
  echo "</div>";
  echo "<div class='barra_carga'>";
echo "</div>";
echo "</div>";
?>
