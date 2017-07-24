<?php

  $atributos = array(
    'class' => 'form-horizontal stepMe',
    'role' => 'form'
  );

  echo $this->breadcrumb->build_breadcrump($this->uri->uri_string());

  echo "<div class='content-form'>";
    echo "<div class='limit-content-title'>";
      echo "<span class='icono icon-paste icon-title'>Dato Común</span>";
    echo "</div>";
    echo "<div class='limit-content'>";
  echo form_open("/ActivoFijo/Datos_comunes/RecibirDatos", $atributos);

  $sub = array(
      'name' => 'autocomplete1',
      'placeholder' => 'Ingrese Subcategoría',
      'class' => "form-control",
      'autocomplete' => 'off'
  );

  $mar = array(
      'name' => 'autocomplete3',
      'placeholder' => 'Ingrese Marca',
      'class' => "form-control",
      'autocomplete' => 'off'
  );

  $desc = array(
      'name' => 'descripcion',
      'placeholder' => 'Ingrese descripción',
      'class' => "form-control"
  );

  $mod = array(
      'name' => 'modelo',
      'placeholder' => 'Ingrese Modelo',
      'class' => "form-control"
  );

  $col = array(
      'name' => 'color',
      'placeholder' => 'Ingrese color',
      'class' => "form-control",
  );

  $doc = array(
      'name' => 'autocomplete4',
      'placeholder' => 'Ingrese tipo de documento',
      'class' => "form-control",
      'autocomplete' => 'off'
  );

  $nom = array(
      'name' => 'nombre_doc',
      'placeholder' => 'Ingrese Nombre del documento',
      'class' => "form-control"
  );

  $fecha = array(
      'name' => 'fecha',
      'placeholder' => 'Ingrese fecha adquisición',
      'class' => "form-control",
      'type'=>"date"
  );

  $pre = array(
      'name' => 'precio',
      'placeholder' => 'Ingrese precio unitario',
      'class' => "form-control",
      'type'=>"number",
  );

  $prov = array(
      'name' => 'autocomplete5',
      'placeholder' => 'Ingrese proveedor',
      'class' => "form-control",
      'autocomplete' => 'off'
  );

  $proy = array(
      'name' => 'autocomplete6',
      'placeholder' => 'Ingrese Proyecto',
      'class' => "form-control",
      'autocomplete' => 'off'
  );

  $gar = array(
      'name' => 'garantia',
      'placeholder' => 'Ingrese garantia en meses',
      'class' => "form-control",
      'type'=>"number"
  );

  $obs = array(
      'name' => 'observacion',
      'placeholder' => 'Ingrese observacion',
      'class' => "form-control"
  );

  $cuen = array(
      'name' => 'autocomplete7',
      'placeholder' => 'Ingrese cuenta contable',
      'class' => "form-control",
      'autocomplete' => 'off'
  );

 $atriLabel = array('class' => 'col-lg-2 control-label');

 $button = array('class' => 'btn btn-success',);

 if ($dato_comun) {
   $sub['value'] = $dato_comun['nombre_subcategoria'];
   $mar['value'] = $dato_comun['nombre_marca'];
   $desc['value'] = $dato_comun['descripcion'];
   $mod['value'] = $dato_comun['modelo'];
   $col['value'] = $dato_comun['color'];

   $doc['value'] = $dato_comun['nombre_doc_ampara'];
   $nom['value'] = $dato_comun['doc_ampara'];
   $fecha['value'] = $dato_comun['fecha_adquisicion'];
   $pre['value'] = $dato_comun['precio_unitario'];

   $prov['value'] = $dato_comun['nombre_proveedor'];
   $proy['value'] = $dato_comun['nombre_fuente'];
   $gar['value'] = $dato_comun['garantia_mes'];

   $obs['value'] = $dato_comun['observacion'];
   $cuen['value'] = $dato_comun['nombre_cuenta'];
 }

  echo "<fieldset>";
    echo "<legend>Paso 1:</legend>";
    echo "<div class='form-group'>";
      echo form_label('Subcategoría:', 'sub', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($sub);
        echo ($dato_comun) ? form_hidden('subcategoria', $dato_comun['id_subcategoria']) : form_hidden('subcategoria');
        echo '<div id="suggestions1" class="suggestions"></div>';
      echo "</div>";
    echo "</div>";

    echo "<div class='form-group'>";
      echo form_label('Marca:', 'mar', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($mar);
        echo ($dato_comun) ? form_hidden('marca', $dato_comun['id_marca']) : form_hidden('marca');
        echo '<div id="suggestions3" class="suggestions"></div>';
      echo "</div>";
    echo "</div>";

    echo "<div class='form-group'>";
      echo form_label('Descripción:', 'desc', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($desc);
      echo "</div>";
    echo "</div>";

    echo "<div class='form-group'>";
      echo form_label('Modelo:', 'mod', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($mod);
      echo "</div>";
    echo "</div>";

    echo "<div class='form-group'>";
      echo form_label('Color:', 'col', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($col);
      echo "</div>";
    echo "</div>";
  echo "</fieldset>";

  echo "<fieldset>";
    echo "<legend>Paso 2:</legend>";
    echo "<div class='form-group'>";
      echo form_label('Tipo documento:', 'doc', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($doc);
        echo ($dato_comun) ? form_hidden('doc_ampara', $dato_comun['id_doc_ampara']) : form_hidden('doc_ampara');
        echo '<div id="suggestions4" class="suggestions"></div>';
      echo "</div>";
    echo "</div>";

    echo "<div class='form-group'>";
      echo form_label('Nombre documento:', 'nom', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($nom);
      echo "</div>";
    echo "</div>";

    echo "<div class='form-group'>";
      echo form_label('Fecha adquisición:', 'fecha', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($fecha);
      echo "</div>";
    echo "</div>";

    echo "<div class='form-group'>";
      echo form_label('Precio unitario:', 'pre', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($pre);
      echo "</div>";
    echo "</div>";
  echo "</fieldset>";

  echo "<fieldset>";
    echo "<legend>Paso 3:</legend>";
    echo "<div class='form-group'>";
      echo form_label('Proveedor:', 'prov', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($prov);
        echo ($dato_comun) ? form_hidden('proveedor', $dato_comun['id_proveedores']) : form_hidden('proveedor');
        echo '<div id="suggestions5" class="suggestions"></div>';
      echo "</div>";
    echo "</div>";

    echo "<div class='form-group'>";
      echo form_label('Proyecto:', 'proy', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($proy);
        echo ($dato_comun) ? form_hidden('proyecto', $dato_comun['id_fuentes']) : form_hidden('proyecto');
        echo '<div id="suggestions6" class="suggestions"></div>';
      echo "</div>";
    echo "</div>";

    echo "<div class='form-group'>";
      echo form_label('Garantía:', 'gar', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($gar);
      echo "</div>";
    echo "</div>";
  echo "</fieldset>";

  echo "<fieldset>";
    echo "<legend>Paso 4:</legend>";
    echo "<div class='form-group'>";
      echo form_label('Observación:', 'obs', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($obs);
      echo "</div>";
    echo "</div>";

    echo "<div class='form-group'>";
      echo form_label('Cuenta Contable:', 'cuen', $atriLabel);
      echo "<div class='col-lg-10'>";
        echo form_input($cuen);
        echo ($dato_comun) ? form_hidden('cuenta', $dato_comun['id_cuenta_contable']) : form_hidden('cuenta');
        echo '<div id="suggestions7" class="suggestions"></div>';
      echo "</div>";
    echo "</div>";

    echo ($dato_comun) ? form_hidden('id', $dato_comun['id_dato_comun']) : form_hidden('id');

    echo ($dato_comun) ? form_hidden('id_bien', $id_bien) : form_hidden('id_bien');

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
    'placeholder' => 'Buscar',
    'class' => 'form-control',
    'autocomplete' => 'off',
    'id' => 'buscar',
    'url' => 'index.php/ActivoFijo/Datos_comunes/mostrarTabla'
  );

  echo "<div class='content_buscar'>";
  echo form_input($buscar);
  echo "</div>";
?>
