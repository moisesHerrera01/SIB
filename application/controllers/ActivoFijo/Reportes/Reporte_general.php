<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_general extends CI_Controller {

  public function __construct() {
    parent::__construct();
    if($this->session->userdata('logged_in') == FALSE){
      redirect('login/index/error_no_autenticado');
    }
    $this->load->helper(array('form', 'paginacion'));
    $this->load->library('table');
    $this->load->model(array('ActivoFijo/Datos_Comunes_Model'));
  }

  public function RecibirDatos() {
    $USER = $this->session->userdata('logged_in');
    if($USER){
      if ($this->input->post('criterio')!=NULL) {
          redirect('ActivoFijo/Reportes/Reporte_general/reporte/'.$this->input->post('criterio'));
        } else {
          redirect('ActivoFijo/Reportes/Reporte_general/reporte/'.'ssssxxxx');
      }
    } else {
      redirect('login');
    }
  }

  public function reporte(){
    $USER = $this->session->userdata('logged_in');
    if($USER){
      $data['title'] = "Reporte General";
      $data['menu'] = $this->menu_dinamico->menus($this->session->userdata('logged_in'),$this->uri->segment(1));
      $table = '';
      if ($this->uri->segment(5) != NULL) {
        $template = array(
            'table_open' => '<table class="table table-striped table-bordered">'
        );
        $this->table->set_template($template);
        $this->table->set_heading('Id bien','Descripción','id marca','Marca','Modelo',
          'Serie/Chasis','Código','Cod. ant.','Num. Motor','Placa','Matricula','Color',
          'Id cuenta','Num cat.','Empleado');
        $num = '25';
          if($this->uri->segment(5)=='ssssxxxx'){
            $total=$this->Datos_Comunes_Model->obtenerPorCualquierCampoTotal()->total;
            $titulo_tabla='TODOS LOS BIENES';
          }else{
            $total = $this->Datos_Comunes_Model->totalPorCualquierCampo($this->uri->segment(5))->total;
            $titulo_tabla='CRITERIO DE BÚSQUEDA:' .$this->uri->segment(5);
          }
          $registros = $this->Datos_Comunes_Model->buscarPorCualquierCampo($this->uri->segment(5),$num, $this->uri->segment(6));
          $pagination = paginacion('index.php/ActivoFijo/Reportes/Reporte_general/reporte/'.$this->uri->segment(5),$total,$num, '6');
        if (!($registros == FALSE)) {
          foreach($registros as $pro) {
            $this->table->add_row($pro->id_bien,$pro->descripcion,$pro->id_marca,$pro->nombre_marca,$pro->modelo,
            $pro->serie,$pro->codigo,$pro->codigo_anterior,$pro->numero_motor,$pro->numero_placa,$pro->matricula,
            $pro->color,$pro->id_cuenta_contable,$pro->numero_categoria,$pro->nombre_empleado);
          }
        } else {
          $msg = array('data' => "No se encontraron resultados", 'colspan' => "15");
          $this->table->add_row($msg);
        }
        $table =  "<div class='content_table '>" .
                  "<div class='limit-content-title'><span class='icono icon-table icon-title'> ".$titulo_tabla."</span></div>".
                  "<div class='limit-content'>" .
                  "<div class='exportar'><a href='".base_url('/index.php/ActivoFijo/Reportes/Reporte_general/ReporteExcel/'.$this->uri->segment(5))."' class='icono icon-file-excel'>
                  Exportar Excel</a> &nbsp;
                  <a href='".base_url('/index.php/ActivoFijo/Reportes/Reporte_general/ImprimirReporte/'.$this->uri->segment(5))."' class='icono icon-printer' target='_blank'>
                  Imprimir</a></div>" .
                  "<div class='table-responsive'>" . $this->table->generate() . "</div>" . $pagination . "</div></div>";
      }

      $data['body'] = $this->load->view('ActivoFijo/Reportes/Reporte_general_view', '',TRUE) . "<br>" . $table;
      $this->load->view('base', $data);
    } else {
      redirect('login/index/forbidden');
    }
  }

  public function ImprimirReporte() {
    $USER = $this->session->userdata('logged_in');
    if ($USER) {
      if ($this->uri->segment(5) != NULL) {
        $template = array(
            'table_open' => '<table class="table table-striped table-bordered">'
        );
        $this->table->set_template($template);
        $this->table->set_heading('Id bien','Descripción','id marca','Marca','Modelo',
          'Serie/Chasis','Código','Cod. ant.','Num. Motor','Placa','Matricula','Color',
          'Id cuenta','Num cat.','Empleado');

        $registros = $this->Datos_Comunes_Model->buscarPorCualquierCampoAutocomplete($this->uri->segment(5));

        if (!($registros == FALSE)) {
          $i = 1;
          foreach($registros as $pro) {
            $this->table->add_row($pro->id_bien,$pro->descripcion,$pro->id_marca,$pro->nombre_marca,$pro->modelo,
              $pro->serie,$pro->codigo,$pro->codigo_anterior,$pro->numero_motor,$pro->numero_placa,$pro->matricula,
              $pro->color,$pro->id_cuenta_contable,$pro->numero_categoria,$pro->nombre_empleado);
            $i++;
          }
        } else {
          $msg = array('data' => "No se encontraron resultados", 'colspan' => "14");
          $this->table->add_row($msg);
        }

        $data = array(
          'table' => $this->table->generate(),
          'title' => '5-Reporte General'
        );
        $this->load->view('ActivoFijo/Reportes/imprimir_reporte_view', $data);
      }
    } else {
      redirect('login');
    }
  }

  public function ReporteExcel() {
    ini_set('memory_limit','512M');
    $USER = $this->session->userdata('logged_in');
    if($USER){
      $this->load->library(array('excel'));

      $estilo_titulo = array(
        'font' => array(
          'name' => 'Calibri',
          'bold' => TRUE,
          'size' => 12,
        ),
        'borders' => array(
          'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THICK
          ),
          'color' => array('rgb' => '676767'),
        ),
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'rotation' => 0,
          'wrap' => TRUE,
        ),
      );


      $estilo_contenido = array(
        'font' => array(
          'name' => 'Calibri',
          'bold' => FALSE,
          'size' => 11,
        ),
        'borders' => array(
          'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
          ),
          'color' => array('rgb' => '676767'),
        ),
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'rotation' => 0,
          'wrap' => TRUE,
        ),
      );

      $objPHPExcel = new PHPExcel();
      $objPHPExcel->getProperties()->setCreator("SICBAF")
                   ->setLastModifiedBy("SICBAF")
                   ->setTitle("Reporte general .")
                   ->setSubject("Reporte general .")
                   ->setDescription("Reporte general. ")
                   ->setKeywords("Reporte general")
                   ->setCategory("Reporte general .");

      $objPHPExcel->setActiveSheetIndex(0)
                   ->setCellValue('A1', 'id bien')
                   ->setCellValue('B1', 'Descripcion')
                   ->setCellValue('C1', 'Marca')
                   ->setCellValue('D1', 'id marca')
                   ->setCellValue('E1', 'Modelo')
                   ->setCellValue('F1', 'Serie/chasis')
                   ->setCellValue('G1', 'Número de motor')
                   ->setCellValue('H1', 'Placa')
                   ->setCellValue('I1', 'Matrícula')
                   ->setCellValue('J1', 'Color')
                   ->setCellValue('K1', 'id cuenta contable')
                   ->setCellValue('L1', 'numero categoria')
                   ->setCellValue('M1', 'codigo anterior')
                   ->setCellValue('N1', 'Codigo actual')
                   ->setCellValue('O1', 'codificar si no')
                   ->setCellValue('P1', 'Categoría')
                   ->setCellValue('Q1', 'numero sub categoria')
                   ->setCellValue('R1', 'id sub categoria')
                   ->setCellValue('S1', 'Sub categoría')
                   ->setCellValue('T1', 'nombre almacen')
                   ->setCellValue('U1', 'nombre seccion')
                   ->setCellValue('V1', 'id oficina')
                   ->setCellValue('W1', 'oficina')
                   ->setCellValue('X1', 'id empleado')
                   ->setCellValue('Y1', 'empleado')
                   ->setCellValue('Z1', 'id doc ampara')
                   ->setCellValue('AA1', 'tipo doc ampara')
                   ->setCellValue('AB1', 'número doc ampara')
                   ->setCellValue('AC1', 'fecha adquisición')
                   ->setCellValue('AD1', 'precio unitario')
                   ->setCellValue('AE1', 'id proveedor')
                   ->setCellValue('AF1', 'nombre proveedor')
                   ->setCellValue('AG1', 'id proyecto')
                   ->setCellValue('AH1', 'nombre proyecto')
                   ->setCellValue('AI1', 'condición')
                   ->setCellValue('AJ1', 'id dato comun');
      $objPHPExcel->getActiveSheet()->getStyle('A1:AJ1')->applyFromArray($estilo_titulo);

      $registros = $this->Datos_Comunes_Model->buscarPorCualquierCampoAutocomplete($this->uri->segment(5));
      if (!($registros == FALSE)) {
        $i = 2;
        foreach($registros as $pro) {
          $objPHPExcel->setActiveSheetIndex(0)
                      ->setCellValue('A'.$i, $pro->id_bien)
                      ->setCellValue('B'.$i, $pro->descripcion)
                      ->setCellValue('C'.$i, $pro->nombre_marca)
                      ->setCellValue('D'.$i, $pro->id_marca)
                      ->setCellValue('E'.$i, $pro->modelo)
                      ->setCellValue('F'.$i, $pro->serie)
                      ->setCellValue('G'.$i, $pro->numero_motor)
                      ->setCellValue('H'.$i, $pro->numero_placa)
                      ->setCellValue('I'.$i, $pro->matricula)
                      ->setCellValue('J'.$i, $pro->color)
                      ->setCellValue('K'.$i, $pro->id_cuenta_contable)
                      ->setCellValue('L'.$i, $pro->numero_categoria)
                      ->setCellValue('M'.$i, $pro->codigo_anterior)
                      ->setCellValue('N'.$i, $pro->codigo)
                      ->setCellValue('O'.$i, $pro->codificar)
                      ->setCellValue('P'.$i, $pro->nombre_categoria)
                      ->setCellValue('Q'.$i, $pro->numero_subcategoria)
                      ->setCellValue('R'.$i, $pro->id_subcategoria)
                      ->setCellValue('S'.$i, $pro->nombre_subcategoria)
                      ->setCellValue('T'.$i, $pro->nombre_almacen)
                      ->setCellValue('U'.$i, $pro->nombre_seccion)
                      ->setCellValue('V'.$i, $pro->id_oficina)
                      ->setCellValue('W'.$i, $pro->nombre_oficina)
                      ->setCellValue('X'.$i, $pro->id_empleado)
                      ->setCellValue('Y'.$i, $pro->nombre_empleado)
                      ->setCellValue('Z'.$i, $pro->id_doc_ampara)
                      ->setCellValue('AA'.$i, $pro->nombre_doc_ampara)
                      ->setCellValue('AB'.$i, $pro->numero_doc)
                      ->setCellValue('AC'.$i, $pro->fecha_adquisicion)
                      ->setCellValue('AD'.$i, $pro->precio_unitario)
                      ->setCellValue('AE'.$i, $pro->id_proveedores)
                      ->setCellValue('AF'.$i, $pro->nombre_proveedor)
                      ->setCellValue('AG'.$i, $pro->id_fuentes)
                      ->setCellValue('AH'.$i, $pro->nombre_fuente)
                      ->setCellValue('AI'.$i, $pro->nombre_condicion_bien)
                      ->setCellValue('AJ'.$i, $pro->id_dato_comun);
          $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AJ'.$i)->applyFromArray($estilo_contenido);
          $i++;
          unset($pro);
        }

        foreach(range('A','AJ') as $columnID){
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndex(0);

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename='reporte_general.xlsx'");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
      }
    } else {
      redirect('login');
    }
  }
}
?>
