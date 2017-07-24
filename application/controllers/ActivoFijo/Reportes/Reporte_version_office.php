<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_version_office extends CI_Controller {

  public function __construct() {
    parent::__construct();
    if($this->session->userdata('logged_in') == FALSE){
      redirect('login/index/error_no_autenticado');
    }
    $this->load->helper(array('url', 'paginacion', 'form'));
    $this->load->library('table');
    $this->load->model(array('ActivoFijo/Equipo_informatico_model','ActivoFijo/Office_model'));
  }

  public function RecibirDatos() {
    $USER = $this->session->userdata('logged_in');
    if($USER){
      if ($this->input->post('office')!=NULL && $this->input->post('fechaMin')!=NULL && $this->input->post('fechaMax')!=NULL) {
          redirect('ActivoFijo/Reportes/Reporte_version_office/reporte/'.$this->input->post('office') . '/' . $this->input->post('fechaMin') . '/' .$this->input->post('fechaMax'));
        } elseif ($this->input->post('office')==NULL && $this->input->post('fechaMin')!=NULL && $this->input->post('fechaMax')!=NULL) {
          redirect('ActivoFijo/Reportes/Reporte_version_office/reporte/todo'.'/'.$this->input->post('fechaMin') . '/' .$this->input->post('fechaMax'));
        } else{
          redirect('ActivoFijo/Reportes/Reporte_version_office/reporte/');
      }
    } else {
      redirect('login');
    }
  }

  public function Reporte() {
    $USER = $this->session->userdata('logged_in');
    if($USER){
      $data['title'] = "12- Reporte por versión de office";
      $data['menu'] = $this->menu_dinamico->menus($this->session->userdata('logged_in'),$this->uri->segment(1));
      $data['js'] = 'assets/js/validate/reporte/activofijo/office.js';
      $table = '';

      if ($this->uri->segment(5) != '' && $this->uri->segment(6) != '' && $this->uri->segment(7) != '') {
        $template = array(
            'table_open' => '<table class="table table-striped table-bordered">'
        );

        $this->table->set_template($template);
        $this->table->set_heading('Id bien','Equipo','Descripción', 'Tipo', 'Procesador', 'HDD', 'Memoria', 'SO',
                                    'Office', 'Direccion IP', 'Número de Punto','Detalle');

        $num = '25';
        $registros = $this->Office_model->obtenerEquipoOfficeLimit($this->uri->segment(5), $this->uri->segment(6), $this->uri->segment(7), $num, $this->uri->segment(8));
        $total = $this->Office_model->totalEquipoOffice($this->uri->segment(5), $this->uri->segment(6), $this->uri->segment(7));
        $pagination = paginacion('index.php/ActivoFijo/Reportes/Reporte_version_office/reporte/'.$this->uri->segment(5) . '/' . $this->uri->segment(6) . '/' .$this->uri->segment(7),
                      $total, $num, '8');
                      $office='';
        if (!($registros == FALSE)) {
          foreach($registros as $bien) {
            $this->table->add_row($bien['id_bien'],$bien['id_equipo_informatico'],$bien['descripcion'], $bien['tipo_computadora'],
                          $bien['nombre_procesador'].' '.$bien['velocidad_procesador'], $bien['capacidad'].' '.$bien['velocidad_disco_duro'],
                          $bien['tipo_memoria'].' '.$bien['velocidad_memoria'], $bien['version_sistema_operativo'], $bien['version_office'],
                          $bien['direccion_ip'], $bien['numero_de_punto'],
             '<a class="icono icon-detalle" href="'.base_url('index.php/ActivoFijo/Reportes/Detalle_bienes_informatico/index/'.$bien['id_bien'].'/').'"></a>');
          }
          $office=$bien['version_office'];
        } else {
          $msg = array('data' => "No se encontraron resultados", 'colspan' => 10);
          $office=$this->uri->segment(5);
          $this->table->add_row($msg);
        }
        error_reporting(0);
        $table =  "<div class='content_table '>" .
                  "<div class='limit-content-title'><span class='icono icon-table icon-title'> ". $office . " - " . $this->uri->segment(6) . " - " . $this->uri->segment(7) ."</span></div>".
                  "<div class='limit-content'>".
                  "<div class='exportar icono'>
                  <a href='".base_url('/index.php/ActivoFijo/Reportes/Reporte_version_office/ReporteExcel/'.$this->uri->segment(5).'/'.
                        $this->uri->segment(6).'/'.$this->uri->segment(7))."' class='icono icon-file-excel'>
                  Exportar Excel</a></div>" .
                  "<div class='table-responsive'>" . $this->table->generate() . "</div>" . $pagination . "</div></div>";

      }
      $data['body'] = $this->load->view('ActivoFijo/Reportes/reporte_version_office_view', '',TRUE) . "<br>" . $table;
      $this->load->view('base', $data);
    } else {
      redirect('login/index/forbidden');
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

    $objPHPExcel->getProperties()->setCreator("SICBAF")
    						 ->setLastModifiedBy("SICBAF")
    						 ->setTitle("Reporte por version de ofice.")
    						 ->setSubject("Reporte por version de ofice.")
    						 ->setDescription("Reporte por version de ofice.")
    						 ->setKeywords("office PHPExcel php")
    						 ->setCategory("Reporte por version de ofice.");

                 $objPHPExcel->setActiveSheetIndex(0)
                             ->setCellValue('A1', 'Id bien')
                             ->setCellValue('B1', 'Equipo')
                             ->setCellValue('C1', 'Descripción')
                             ->setCellValue('D1', 'Tipo Computadora')
                             ->setCellValue('E1', 'Procesador')
                             ->setCellValue('F1', 'HDD')
                             ->setCellValue('G1', 'Memoria')
                             ->setCellValue('H1', 'SO')
                             ->setCellValue('I1', 'Office')
                             ->setCellValue('J1', 'Direccion IP')
                             ->setCellValue('K1', 'Numero de Punto')
                             ->setCellValue('L1', 'Marca')
                             ->setCellValue('M1', 'Modelo')
                             ->setCellValue('N1', 'Color')
                             ->setCellValue('O1', 'Serie')
                             ->setCellValue('P1', 'Código')
                             ->setCellValue('Q1', 'Código anterior')
                             ->setCellValue('R1', 'Adquirido')
                             ->setCellValue('S1', 'Asignado a');
                 $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray($estilo_titulo);

    $total = $this->Office_model->totalEquipoOffice($this->uri->segment(5), $this->uri->segment(6), $this->uri->segment(7));
    $registros = $this->Office_model->obtenerEquipoOfficeLimit($this->uri->segment(5), $this->uri->segment(6), $this->uri->segment(7), $total, 0);

    if (!($registros == FALSE)) {
      $i = 2;
      foreach($registros as $bien) {
        $detalle = $this->Equipo_informatico_model->obtenerDetalleBienes($bien['id_bien']);
        foreach ($detalle as $det) {
        $objPHPExcel->setActiveSheetIndex(0)
                     ->setCellValue('A'.$i, $bien['id_bien'])
                     ->setCellValue('B'.$i, $bien['id_equipo_informatico'])
                     ->setCellValue('C'.$i, $bien['descripcion'])
                     ->setCellValue('D'.$i, $bien['tipo_computadora'])
                     ->setCellValue('E'.$i, $bien['nombre_procesador'].' '.$bien['velocidad_procesador'])
                     ->setCellValue('F'.$i, $bien['capacidad'].' '.$bien['velocidad_disco_duro'])
                     ->setCellValue('G'.$i, $bien['tipo_memoria'].' '.$bien['velocidad_memoria'])
                     ->setCellValue('H'.$i, $bien['version_sistema_operativo'])
                     ->setCellValue('I'.$i, $bien['version_office'])
                     ->setCellValue('J'.$i, $bien['direccion_ip'])
                     ->setCellValue('K'.$i, $bien['numero_de_punto'])
                     ->setCellValue('L'.$i, $det->nombre_marca)
                     ->setCellValue('M'.$i, $det->modelo)
                     ->setCellValue('N'.$i, $det->color)
                     ->setCellValue('O'.$i, $det->serie)
                     ->setCellValue('P'.$i, $det->codigo)
                     ->setCellValue('Q'.$i, $det->codigo_anterior)
                     ->setCellValue('R'.$i, $det->fecha_adquisicion)
                     ->setCellValue('S'.$i, $det->nombre_empleado);

        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':S'.$i)->applyFromArray($estilo_contenido);
        $i++;
      }
    }
    } else {
      $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:S2');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "No se encontraron resultados");
      $objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray($estilo_contenido);
    }

    foreach(range('A','S') as $columnID){
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }

    $objPHPExcel->setActiveSheetIndex(0);

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename='Reporte_version_office_.xlsx'");
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
  }

}

?>
