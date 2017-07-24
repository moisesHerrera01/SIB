<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carga_masiva extends CI_Controller {

  private $datos = array();
  #indica en base a que se ordena
  private $aux = array();

  public function __construct() {
    parent::__construct();
    if($this->session->userdata('logged_in') == FALSE){
      redirect('login/index/error_no_autenticado');
    }
    $this->load->helper(array('form', 'paginacion'));
    $this->load->library(array('table', 'excel'));
    $this->load->model(array('ActivoFijo/Datos_Comunes_Model', 'ActivoFijo/Categoria_model', 'ActivoFijo/Subcategoria_Model',
                      'ActivoFijo/Doc_Ampara_Model', 'Bodega/Proveedor', 'ActivoFijo/Condicion_bien_model', 
                      'Bodega/Fuentefondos_model', 'ActivoFijo/Bienes_Muebles_Model', 'ActivoFijo/Bienes_inmuebles_model',
                      'ActivoFijo/Movimiento_Model', 'ActivoFijo/Detalle_movimiento_model', 'ActivoFijo/Marcas_model'));
  }

  public function index() {
    $data['title'] = "Carga Masiva - Activo Fijo";
    $data['js'] = "assets/js/carga_af.js";
    $data['body'] = $this->load->view('ActivoFijo/carga_masiva_view', '', TRUE);
    $data['menu'] = $this->menu_dinamico->menus($this->session->userdata('logged_in'), $this->uri->segment(1));
    $this->load->view('base', $data);
  }

  public function cargar_archivo() {

    $config['upload_path'] = "uploads/";
    $config['allowed_types'] = "xls|xlsx|xlsb";
    $config['max_size'] = "50000";

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('archivo')) {
        //*** ocurrio un error
        $data['uploadError'] = $this->upload->display_errors();
        echo $this->upload->display_errors();
        return;
    }

    $this->leer_archivo($this->upload->data('full_path'));
    //$this->mostrarTabla(TRUE);
	}

  public function leer_archivo($archivo = '') {
    if (file_exists($archivo)) {
      set_time_limit(2400);
      ini_set('memory_limit','512M');
      $objPHPExcel = PHPExcel_IOFactory::load($archivo);
      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
        $worksheetTitle     = $worksheet->getTitle();
        $highestRow         = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $nrColumns = ord($highestColumn) - 64;
        $b = FALSE;
        $col;
        for ($row = 1; $row <= 1; ++ $row) {
          for ($col = 0; $col < $highestColumnIndex; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
            $val = mb_strtolower($val, 'UTF-8');
            switch ($col) {
              case 0:
                $b = (strpos($val, 'bien') === FALSE) ? TRUE : FALSE ;
                break;
              case 1:
                $b = (strpos($val, 'descripci') === FALSE) ? TRUE : FALSE ;
                break;
              case 2:
                $b = (strpos($val, 'marca') === FALSE) ? TRUE : FALSE ;
                break;
              case 3:
                $b = (strpos($val, 'marca') === FALSE) ? TRUE : FALSE ;
                break;
              case 4:
                $b = (strpos($val, 'modelo') === FALSE) ? TRUE : FALSE ;
                break;
              case 5:
                $b = (strpos($val, 'chasis') === FALSE) ? TRUE : FALSE ;
                break;
              case 6:
                $b = (strpos($val, 'motor') === FALSE) ? TRUE : FALSE ;
                break;
              case 7:
                $b = (strpos($val, 'placa') === FALSE) ? TRUE : FALSE ;
                break;
              case 8:
                $b = (strpos($val, 'cula') === FALSE) ? TRUE : FALSE ;
                break;
              case 9:
                $b = (strpos($val, 'color') === FALSE) ? TRUE : FALSE ;
                break;
              case 10:
                $b = (strpos($val, 'contable') === FALSE) ? TRUE : FALSE ;
                break;
              case 11:
                $b = (strpos($val, 'catego') === FALSE) ? TRUE : FALSE ;
                break;
              case 12:
                $b = (strpos($val, 'anterior') === FALSE) ? TRUE : FALSE ;
                break;
              case 13:
                $b = (strpos($val, 'actual') === FALSE) ? TRUE : FALSE ;
                break;
              case 14:
                $b = (strpos($val, 'codificar') === FALSE) ? TRUE : FALSE ;
                break;
              case 15:
                $b = (strpos($val, 'catego') === FALSE) ? TRUE : FALSE ;
                break;
              case 16:
                $b = (strpos($val, 'categor') === FALSE) ? TRUE : FALSE ;
                break;
              case 17:
                $b = (strpos($val, 'categor') === FALSE) ? TRUE : FALSE ;
                break;
              case 18:
                $b = (strpos($val, 'categor') === FALSE) ? TRUE : FALSE ;
                break;
              case 19:
                $b = (strpos($val, 'almacen') === FALSE) ? TRUE : FALSE ;
                break;
              case 20:
                $b = (strpos($val, 'seccion') === FALSE) ? TRUE : FALSE ;
                break;
              case 21:
                $b = (strpos($val, 'oficina') === FALSE) ? TRUE : FALSE ;
                break;
              case 22:
                $b = (strpos($val, 'oficina') === FALSE) ? TRUE : FALSE ;
                break;
              case 23:
                $b = (strpos($val, 'empleado') === FALSE) ? TRUE : FALSE ;
                break;
              case 24:
                $b = (strpos($val, 'empleado') === FALSE) ? TRUE : FALSE ;
                break;
              case 25:
                $b = (strpos($val, 'ampara') === FALSE) ? TRUE : FALSE ;
                break;
              case 26:
                $b = (strpos($val, 'ampara') === FALSE) ? TRUE : FALSE ;
                break;
              case 27:
                $b = (strpos($val, 'ampara') === FALSE) ? TRUE : FALSE ;
                break;
              case 28:
                $b = (strpos($val, 'fecha') === FALSE) ? TRUE : FALSE ;
                break;
              case 29:
                $b = (strpos($val, 'precio') === FALSE) ? TRUE : FALSE ;
                break;
              case 30:
                $b = (strpos($val, 'proveedor') === FALSE) ? TRUE : FALSE ;
                break;
              case 31:
                $b = (strpos($val, 'proveedor') === FALSE) ? TRUE : FALSE ;
                break;
              case 32:
                $b = (strpos($val, 'proyecto') === FALSE) ? TRUE : FALSE ;
                break;
              case 33:
                $b = (strpos($val, 'proyecto') === FALSE) ? TRUE : FALSE ;
                break;
              case 34:
                $b = (strpos($val, 'condici') === FALSE) ? TRUE : FALSE ;
                break;
              case 35:
                $b = (strpos($val, 'dato') === FALSE) ? TRUE : FALSE ;
                break;
            }
            if ($b) {
              break;
            }
          }
        }
        if (!$b) {
          for ($row = 2; $row <= $highestRow; ++ $row) {
              $data = array();
              for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                  $cell = $worksheet->getCellByColumnAndRow($col, $row);
                  $val = $cell->getValue();
                  switch ($col) {
                    case 0:
                      $data['id_bien'] = intval(trim($val));
                      break;
                    case 1:
                      $data['descripcion_comun'] = trim($val);
                      break;
                    case 2:
                      $data['marca_comun'] = trim($val);
                      break;
                    case 3:
                      $data['id_marca_comun'] = intval(trim($val));
                      break;
                    case 4:
                      $data['modelo_comun'] = trim($val);
                      break;
                    case 5:
                      $data['serie_comun'] = trim($val);
                      break;
                    case 6:
                      $data['motor_comun'] = trim($val);
                      break;
                    case 7:
                      $data['placa_comun'] = trim($val);
                      break;
                    case 8:
                      $data['matricula_comun'] = trim($val);
                      break;
                    case 9:
                      $data['color_comun'] = trim($val);
                      break;
                    case 10:
                      $data['id_cuenta_comun'] = intval(trim($val));
                      break;
                    case 11:
                      $data['numero_cat_comun'] = intval(trim($val));
                      break;
                    case 12:
                      $data['codigo_ant_bien'] = trim($val);
                      break;
                    case 13:

                      $val = trim($val);
                      $cod = explode('.', $val);
                      if (strlen($cod[1]) < 6) {
                        $cod[1] = '0' . $cod[1];
                      }

                      $data['codigo_bien'] = implode('.', $cod);
                      break;
                    case 14:
                      $data['codificar_bien'] = ($val === 'SI') ? TRUE : FALSE ;
                      break;
                    case 15:
                      $data['nombre_cat_comun'] = trim($val);
                      break;
                    case 16:
                      $data['num_sub_cat_comun'] = trim($val);
                      break;
                    case 17:
                      $data['id_sub_cat_comun'] = intval(trim($val));
                      break;
                    case 18:
                      $data['nombre_sub_cat_comun'] = trim($val);
                      break;
                    case 19:
                      $data['almacen_bien'] = trim($val);
                      break;
                    case 20:
                      $data['seccion_bien'] = trim($val);
                      break;
                    case 21:
                      $data['id_oficina_bien'] = intval(trim($val));
                      break;
                    case 23:
                      $data['id_empleado_bien'] = intval(trim($val));
                      break;
                    case 25:
                      $data['id_ampara_comun'] = intval(trim($val));
                      break;
                    case 26:
                      $data['nombre_ampara_comun'] = trim($val);
                      break;
                    case 27:
                      $data['num_ampara_comun'] = intval(trim($val));
                      break;
                    case 28:
                      $timestamp = PHPExcel_Shared_Date::ExcelToPHP($val);
                      $date = date("Y-m-d", $timestamp);
                      $data['fecha_comun'] = ( $date == date("Y-m-d")) ? "2006-01-01" : $date ;
                      break;
                    case 29:
                      $data['precio_comun'] = number_format(trim($val),3);
                      break;
                    case 30:
                      $data['id_proveedor_comun'] = intval(trim($val));
                      break;
                    case 31:
                      $data['proveedor_comun'] = trim($val);
                      break;
                    case 32:
                      $data['id_fuente_comun'] = intval(trim($val));
                      break;
                    case 33:
                      $data['fuente_comun'] = trim($val);
                      break;
                    case 34:
                      $data['condicion_bien'] = trim($val);
                      break;
                    case 35:
                      $data['id_dato_comun'] = intval(trim($val));
                      break;
                  }
              }
              array_push($this->datos, $data);
              unset($data);
          }
        } else {
          echo "Verifique, el archivo no es compatible";
        }

        break;
      }

      unset($objPHPExcel);
      unlink($archivo);

      $json_datos = json_encode($this->datos, JSON_PRETTY_PRINT);
      unset($GLOBALS['datos']);
      $file1 = 'uploads/datos.json';
      file_put_contents($file1, $json_datos);
      echo $json_datos;
    }
  }

  public function CargaMasiva() {
    $tiempo_inicio = microtime(true);
    date_default_timezone_set('America/El_Salvador');
    set_time_limit(2400);
    $fecha_actual = date("Y-m-d");

    if (file_exists("uploads/datos.json")) {
      $datos_json = file_get_contents("uploads/datos.json");
      $this->datos = json_decode($datos_json, true);

      unset($datos_json);
      unlink("uploads/datos.json");

      if (count($this->datos) > 0) {
        $categoria;
        $proveedor;
        $i = 0;
        foreach ($this->datos as $dato) {
          $categoria = 0;
          /*Insertar categoria*/
          if (!$this->Categoria_model->existeCategoria($dato['numero_cat_comun'], $dato['nombre_cat_comun'])) {
            $categoria = $this->Categoria_model->insertarCategoria(array(
                'nombre_categoria' => $dato['nombre_cat_comun'],
                'numero_categoria' => $dato['numero_cat_comun'],
                'descripcion' => 'N/A',
            ));
          }

          /*Inserta subcategoria*/
          if ($categoria != 0) {
            $dato['id_sub_cat_comun'] = $this->CatSubcategoria_Modelegoria_model->insertarSubcategoria(array(
                'nombre_subcategoria' => $dato['nombre_sub_cat_comun'],
                'numero_subcategoria' => $dato['num_sub_cat_comun'],
                'id_categoria' => $categoria,
                'descripcion' => 'N/A',
            ));
          }
          else if (!$this->Subcategoria_Model->existeSubCategoria($dato['num_sub_cat_comun'], $dato['nombre_sub_cat_comun'])) {
            $dato['id_sub_cat_comun'] = $this->Subcategoria_Model->insertarSubcategoria(array(
                'nombre_subcategoria' => $dato['nombre_sub_cat_comun'],
                'numero_subcategoria' => $dato['num_sub_cat_comun'],
                'id_categoria' => $categoria,
                'descripcion' => 'N/A',
            ));
          }

          /*Insertar documento ampara*/
          if(!$this->Doc_Ampara_Model->obtenerDocumentoAmpara($dato['id_ampara_comun'])) {
            $dato['id_ampara_comun'] = $this->Doc_Ampara_Model->insertarDocumento(array(
              'nombre_doc_ampara' => $dato['nombre_ampara_comun']
            ));
          }

          /*Insertar proveedor*/
          $proveedor = $this->Proveedor->buscarProveedores($dato['proveedor_comun']);
          $id_proveerdor;
          if (!$proveedor) {
              $id_proveerdor = $this->Proveedor->insertarProveedor(array(
              'id_categoria_proveedor' => 67,
              'nombre_proveedor' => $dato['proveedor_comun'],
              'nombre_contacto' => '',
              'nit' => '',
              'correo' => '',
              'telefono' => '',
              'fax' => '',
              'direccion' => ''
             ));
          } else {
            $id_proveerdor = $proveedor[0]->id_proveedores;
          }

          /*Insertar fuente de fondo*/
          if ($dato['id_fuente_comun'] != 1) {
            $dato['id_fuente_comun'] = $this->Fuentefondos_model->insertarFuente(array(
              'nombre_fuente' => $dato['fuente_comun'],
              'codigo' => '',
              'descripcion' => '',
            ));
          } else {
            if (!$this->Fuentefondos_model->buscarFuentes($dato['fuente_comun'])) {
              $dato['id_fuente_comun'] = $this->Fuentefondos_model->insertarFuente(array(
                'nombre_fuente' => $dato['fuente_comun'],
                'codigo' => '',
                'descripcion' => '',
              ));
            }
          }

          /*Insertar marca*/
          if (!$this->Marcas_model->buscarMarcas($dato['marca_comun'])) {
            $dato['id_marca_comun'] = $this->Marcas_model->insertarMarcas(array(
              'nombre_marca' => $dato['marca_comun'], 
              ));
          }

          /*Insertar data comun*/
          if(!is_array($this->Datos_Comunes_Model->obtenerDatoComunArray($dato['id_dato_comun']))){
            $this->Datos_Comunes_Model->insertarDatosComunes(array(
                'id_dato_comun' => $dato['id_dato_comun'],
                'id_subcategoria' => $dato['id_sub_cat_comun'],
                'id_tipo_movimiento' => 1,
                'id_marca' => $dato['id_marca_comun'],
                'descripcion' => $dato['descripcion_comun'],
                'modelo' => $dato['modelo_comun'],
                'color' => $dato['color_comun'],
                'id_doc_ampara' => $dato['id_ampara_comun'],
                'nombre_doc_ampara' => $dato['num_ampara_comun'],
                'fecha_adquisicion' => $dato['fecha_comun'],
                'precio_unitario' => $dato['precio_comun'],
                'id_proveedores' => $id_proveerdor,
                'id_fuentes' => $dato['id_fuente_comun'],
                'garantia_mes' => 0,
                'observacion' => '',
                'id_cuenta_contable' => $dato['id_cuenta_comun']
            ));
          }

          /*Insertar condicion bien*/
          $condicion_bien = $this->Condicion_bien_model->buscarCondiciones($dato['condicion_bien']);
          $id_condicion_bien;
          if (!$condicion_bien) {
            $id_condicion_bien = $this->Condicion_bien_model->insertarCondicion(array(
              'nombre_condicion_bien' => $dato['condicion_bien'],
            ));
          } else {
            $id_condicion_bien = $condicion_bien[0]->id_condicion_bien;
          }

          /*Insertar bien*/
          $id_movimento = 0;
          $id_bien = 0;
          if (!$this->Bienes_Muebles_Model->buscarBienes_muebles($dato['codigo_bien'])) {
            $id_bien = $this->Bienes_Muebles_Model->insertarBienesCarga(array(
              'id_dato_comun' => $dato['id_dato_comun'],
              'codigo_anterior' => $dato['codigo_ant_bien'],
              'serie' => $dato['serie_comun'],
              'numero_motor' => $dato['motor_comun'],
              'numero_placa' => $dato['placa_comun'],
              'matricula' => $dato['matricula_comun'],
              'id_condicion_bien' => $id_condicion_bien,
              'observacion' => '',
              'correlativo' => $this->Bienes_inmuebles_model->obtenerCorrelativo(),
              'codigo' => $dato['codigo_bien'],
              'id_oficina' => $dato['id_oficina_bien'],
              'id_empleado' => $dato['id_empleado_bien']
            ));

            /*Insertar movimiento*/
            $movimento = $this->Movimiento_Model->obtenerMovimientoPorEmpleado($dato['id_empleado_bien']);
            if (!$movimento) {
              $id_movimento = $this->Movimiento_Model->insertarMovimiento(array(
                'id_oficina_entrega' => 3,
                'id_oficina_recibe' => $dato['id_oficina_bien'],
                'id_seccion' => $this->Bienes_Muebles_Model->obtenerSeccionOficina($dato['id_oficina_bien'])->id_seccion,
                'id_empleado' => $dato['id_empleado_bien'],
                'id_tipo_movimiento' => 2,
                'usuario_externo' => "",
                'entregado_por' => "",
                'recibido_por' => $dato['id_empleado_bien'],
                'autorizado_por' => $dato['id_empleado_bien'],
                'visto_bueno_por' => $dato['id_empleado_bien'],
                'fecha_guarda' => date('Y-m-d'),
                'observacion' => "INGRESADO POR CARGA MASIVA."
              ));
            } else {
              $id_movimento = $movimento->id_movimiento;
            }

            /*Insertar detalle movimiento*/
            $this->Detalle_movimiento_model->insertarDetalleMovimiento(array(
              'id_movimiento' => $id_movimento,
              'id_bien' => $id_bien
            ));

          }

          $i++;

        }

        $this->Movimiento_Model->cerrarTodosMovimiento();
        $tiempo_fin = microtime(true);

        $array_data = array(
          'tiempo' => $tiempo_fin - $tiempo_inicio,
          'cantidad' => $i,
        );

        echo json_encode($array_data, JSON_PRETTY_PRINT);

      }
    }
  }

  public function ArrayIsEmpty($array) {
    if(is_array($array)) {
      if (empty($array)) {
        return TRUE;
      }
    } else {
      return TRUE;
    }

    return FALSE;
  }

}
?>
