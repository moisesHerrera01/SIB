<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_solicitudes_denegadas extends CI_Controller {

  public function __construct() {
    parent::__construct();

    if($this->session->userdata('logged_in') == FALSE){
      redirect('login/index/error_no_autenticado');
    }

    $this->load->helper(array('form', 'paginacion'));
    $this->load->library(array('table'));
    $this->load->model('Compras/Solicitud_Compra_Model');
  }

  public function Recibirfechas() {
    date_default_timezone_set('America/El_Salvador');
    $anyo=20;
    $fecha_actual=date($anyo."y-m-d");
    if ($this->input->post('minFecha')) {
      if($this->input->post('maxFecha')==NULL){
        redirect('Compras/Reportes/Reporte_solicitudes_denegadas/reporte/'.$this->input->post('minFecha').'/'.$fecha_actual);
      }else{
        redirect('Compras/Reportes/Reporte_solicitudes_denegadas/reporte/'.$this->input->post('minFecha').'/'.$this->input->post('maxFecha'));
      }} else {
        redirect('Compras/Reportes/Reporte_solicitudes_denegadas/reporte/');
    }
  }

  public function reporte(){
    $USER = $this->session->userdata('logged_in');
    if($USER){
      $data['title'] = "4- Reporte Solicitudes Denegadas";
      $data['menu'] = $this->menu_dinamico->menus($this->session->userdata('logged_in'),$this->uri->segment(1));
      $data['js'] = 'assets/js/validate/reporte/compra/solicitud_disponibilidad.js';
      $table = '';
      if ($this->uri->segment(5)!=NULL) {
        $template = array(
            'table_open' => '<table class="table table-striped table-bordered">'
        );
        $this->table->set_template($template);
        $this->table->set_heading('Nº','Id Req','Nº Req','Unidad Solicitante','Fecha Solicitud', 'Especifico','Descripción','Comentario','Memorandum');
        $num = '10';
          $registros = $this->Solicitud_Compra_Model->reporteDenegadas($this->uri->segment(5),
          $this->uri->segment(6),$num, $this->uri->segment(7));
          $total = $this->Solicitud_Compra_Model->reporteDenegadasTotal($this->uri->segment(5),$this->uri->segment(6));
          error_reporting(0);
          $pagination = paginacion('index.php/Compras/Reportes/Reporte_solicitudes_denegadas/reporte/'.$this->uri->segment(5).'/'.$this->uri->segment(6),
            $total->total, $num, '7');
        if (!($registros == FALSE)) {
          $i = 1;
          $descripcion='';
          $comentario='';
          foreach($registros as $sol) {
            $numero;
            if ($sol->nivel_anterior<4) {
              $numero='S/E';
            }else {
              $numero=$sol->nombre_fuente.'-'.$sol->numero_solicitud_compra.'/'.substr($sol->fecha_solicitud_compra,0,-6);
            }
            $descripcion=$this->Solicitud_Compra_Model->obtenerDescripcionProductos($sol->id_solicitud_compra);
            if($sol->comentario_autorizante==NULL && $sol->comentario_compras==NULL){
              $comentario=$sol->comentario_jefe;
            }elseif ($sol->comentario_compras==NULL) {
              $comentario=$sol->comentario_autorizante;
            }elseif ($sol->comentario_compras!=NULL) {
              $comentario=$sol->comentario_compras;
            }
            $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Reportes/Reporte_solicitudes_denegadas/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';
            $this->table->add_row($i,$sol->id_solicitud_compra,$numero,$sol->nombre_seccion,$sol->fecha_solicitud_compra,
                                  $sol->id_especifico,$descripcion.' '.$sol->justificacion,$comentario,$descargar_archivo);
            $i++;
          }
        } else {
          $msg = array('data' => "No se encontraron resultados", 'colspan' => "7");
          $this->table->add_row($msg);
        }
        $table =  "<div class='content_table '>" .
                  "<div class='limit-content-title'><span class='icono icon-table icon-title'> ". $this->uri->segment(5) . " - " . $this->uri->segment(6)."</span></div>".
                  "<div class='limit-content'>" .
                  "<div class='exportar'><a href='".base_url('/index.php/Compras/Reportes/Reporte_solicitudes_denegadas/ReporteExcel/'.$this->uri->segment(5).'/'.
                    $this->uri->segment(6))."' class='icono icon-file-excel'>
                  Exportar Excel</a>&nbsp;
                  <a href='".base_url('/index.php/Compras/Reportes/Reporte_solicitudes_denegadas/ImprimirReporte/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.
                    $this->uri->segment(7))."' class='icono icon-printer' target='_blank'>
                  Imprimir</a></div>" . "<div class='table-responsive'>" . $this->table->generate() . "</div>" . $pagination . "</div></div>";
      }

      $data['body'] = $this->load->view('Compras/Reportes/Reporte_solicitudes_denegadas_view', '',TRUE) . "<br>" . $table;
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
        $this->table->set_heading('Nº','Id Req','Nº Req','Unidad Solicitante','Fecha Solicitud', 'Especifico','Descripción','Comentario');

        $registros = $this->Solicitud_Compra_Model->reporteDenegadasExcel($this->uri->segment(5),$this->uri->segment(6));
        $descripcion='';
        $monto_total=0.0;
        $linea='';
        if (!($registros == FALSE)) {
          $i = 1;
          $descripcion='';
          $comentario='';
          foreach($registros as $sol) {
            $numero;
            if ($sol->nivel_anterior<4) {
              $numero='S/E';
            }else {
              $numero=$sol->nombre_fuente.'-'.$sol->numero_solicitud_compra.'/'.substr($sol->fecha_solicitud_compra,0,-6);
            }
            $descripcion=$this->Solicitud_Compra_Model->obtenerDescripcionProductos($sol->id_solicitud_compra);
            if($sol->comentario_autorizante==NULL && $sol->comentario_compras==NULL){
              $comentario=$sol->comentario_jefe;
            }elseif ($sol->comentario_compras==NULL) {
              $comentario=$sol->comentario_autorizante;
            }elseif ($sol->comentario_compras!=NULL) {
              $comentario=$sol->comentario_compras;
            }
            $this->table->add_row($i,$sol->id_solicitud_compra,$numero,$sol->nombre_seccion,$sol->fecha_solicitud_compra,
                                  $sol->id_especifico,$descripcion.' '.$sol->justificacion,$comentario);
            $i++;
          }
        } else {
          $msg = array('data' => "No se encontraron resultados", 'colspan' => "8");
          $this->table->add_row($msg);
        }
        $fecha_inicio=date("d-m-Y",strtotime($this->uri->segment(5)));
        $fecha_fin=date("d-m-Y",strtotime($this->uri->segment(6)));

        $data = array(
          'table' => $this->table->generate(),
          'title' => '2 - Reporte de solicitudes de disponibilidad financiera.',
          'mtps' => 'MINISTERIO DE TRABAJO Y PREVISIÓN SOCIAL',
          'uaci' => 'UNIDAD DE ADQUISICIONES Y CONTRATACIONES INSTITUCIONAL',
          'param' => "CUADRO DE REPORTE DE SOLICITUDES DENEGADAS".' DEL '.$fecha_inicio.' AL '.$fecha_fin
        );
        $this->load->view('Compras/Reportes/imprimir_reporte_view', $data);
      }
    } else {
      redirect('login');
    }
  }

  public function ReporteExcel() {
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
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $logo = 'assets/image/icono.jpg'; // Provide path to your logo file
    $objDrawing->setPath($logo);  //setOffsetY has no effect
    $objDrawing->setCoordinates('H1');
    $objDrawing->setHeight(100); // logo height
    $objDrawing->setOffsetX(135);    // setOffsetX works properly
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);


    $objPHPExcel->getProperties()->setCreator("SICBAF")
    						 ->setLastModifiedBy("SICBAF")
    						 ->setTitle("Reporte de solicitudes de compras denegadas")
    						 ->setSubject("Reporte de solicitudes de compras denegadas")
    						 ->setDescription("Reporte de solicitudes de compras denegadas.")
    						 ->setKeywords("office PHPExcel php")
    						 ->setCategory("Reporte de solicitudes de compras denegadas");
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A6', 'Nº')
                ->setCellValue('B6', 'Id Req.')
                ->setCellValue('C6', 'Nº Req.')
                ->setCellValue('D6', 'Unidad Solicitante')
                ->setCellValue('E6', 'Fecha Solicitud')
                ->setCellValue('F6', 'Especifico')
                ->setCellValue('G6', 'Descripción')
                ->setCellValue('H6', 'Comentario');
    $objPHPExcel->getActiveSheet()->getStyle('A6:H6')->applyFromArray($estilo_titulo);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:H2');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:H4');
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', "MINISTERIO DE TRABAJO Y PREVISIÓN SOCIAL")
                ->setCellValue('A2', "UNIDAD DE ADQUISICIONES Y CONTRATACIONES INSTITUCIONAL")
                ->setCellValue('A4', "CUADRO DE REPORTE DE SOLICITUDES DE COMPRAS DENEGADAS".' DEL '.$this->uri->segment(5).
                ' AL '.$this->uri->segment(6));
    $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($estilo_contenido);
    $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($estilo_contenido);
    $objPHPExcel->getActiveSheet()->getStyle('A4:H4')->applyFromArray($estilo_titulo);

    $registros = $this->Solicitud_Compra_Model->reporteDenegadasExcel($this->uri->segment(5),
    $this->uri->segment(6));
    if (!($registros == FALSE)) {
      $i = 7;
      $j=1;
      foreach($registros as $sol) {
        $numero;
        if ($sol->nivel_anterior<4) {
          $numero='S/E';
        }else {
          $numero=$sol->nombre_fuente.'-'.$sol->numero_solicitud_compra.'/'.substr($sol->fecha_solicitud_compra,0,-6);
        }
        $descripcion=$this->Solicitud_Compra_Model->obtenerDescripcionProductos($sol->id_solicitud_compra);
        if($sol->comentario_autorizante==NULL && $sol->comentario_compras==NULL){
          $comentario=$sol->comentario_jefe;
        }elseif ($sol->comentario_compras==NULL) {
          $comentario=$sol->comentario_autorizante;
        }elseif ($sol->comentario_compras!=NULL) {
          $comentario=$sol->comentario_compras;
        }

        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $j)
                    ->setCellValue('B'.$i, $sol->id_solicitud_compra)
                    ->setCellValue('C'.$i, $numero)
                    ->setCellValue('D'.$i, $sol->nombre_seccion)
                    ->setCellValue('E'.$i, $sol->fecha_solicitud_compra)
                    ->setCellValue('F'.$i, $sol->id_especifico)
                    ->setCellValue('G'.$i, $descripcion)
                    ->setCellValue('H'.$i, $comentario);

        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->applyFromArray($estilo_contenido);
        $i++;
        $j++;
      }

      foreach(range('A','H') as $columnID){
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
      }

      $objPHPExcel->setActiveSheetIndex(0);

      header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
      header("Content-Disposition: attachment; filename='reporte_denegadas.xlsx'");
      header('Cache-Control: max-age=0');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
    }
  }

  public function descargarArchivo($id) {
    $this->load->helper('download');
    $sol=$this->Solicitud_Compra_Model->obtenerSolicitudCompleta($id);
    $name=$sol->memorandum;
    force_download("uploads/$name", NULL);
    //redirect('/Compras/Reportes/Reporte_solicitudes_denegadas/reporte');
  }
}
?>