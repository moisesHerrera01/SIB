<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_total_solicitudes extends CI_Controller {

  public function __construct() {
    parent::__construct();
    if($this->session->userdata('logged_in') == FALSE){
      redirect('login/index/error_no_autenticado');
    }
    $this->load->helper(array('form', 'paginacion'));
    $this->load->library('table');
    $this->load->model(array('Compras/Solicitud_Compra_Model'));
  }

  public function Recibirfechas() {
    date_default_timezone_set('America/El_Salvador');
    $anyo=20;
    $fecha_actual=date($anyo."y-m-d");
    if ($this->input->post('minFecha')) {
      if($this->input->post('maxFecha')==NULL){
        redirect('Compras/Reportes/Reporte_total_solicitudes/reporte/'.$this->input->post('minFecha').'/'.$fecha_actual);
      }else{
        redirect('Compras/Reportes/Reporte_total_solicitudes/reporte/'.$this->input->post('minFecha').'/'.$this->input->post('maxFecha'));
      }} else {
        redirect('Compras/Reportes/Reporte_total_solicitudes/reporte/');
    }
  }

  public function reporte(){
    $USER = $this->session->userdata('logged_in');
    if($USER){
      $data['title'] = "Total de solicitudes por nivel";
      $data['menu'] = $this->menu_dinamico->menus($this->session->userdata('logged_in'),$this->uri->segment(1));
      $table = '';
      if ($this->uri->segment(5) != NULL) {
        $template = array(
          'table_open' => '<table class="table table-striped table-bordered">'
        );
        $this->table->set_template($template);
        $this->table->set_heading('#','Nivel de Solicitud','Cantidad');

        //$fecha1='2017-04-02';
        //$fecha2='2017-06-06';
      //  var_dump($this->uri->segment(5),$this->uri->segment(6));
        $registros = $this->Solicitud_Compra_Model->totalSolicitudes($this->uri->segment(5),$this->uri->segment(6));
        if (!($registros == FALSE)) {
            $this->table->add_row(1,'<strong>Ingresadas',$registros->nivel0);
            $this->table->add_row(2,'<strong>Enviadas',$registros->nivel1);
            $this->table->add_row(3,'<strong>Aprobadas por jefatura',$registros->nivel2);
            $this->table->add_row(4,'<strong>Aprobadas por autorizante',$registros->nivel3);
            $this->table->add_row(5,'<strong>Aprobadas por compras',$registros->nivel4);
            $this->table->add_row(6,'<strong>Aprobadas solicitudes de disponibilidad',$registros->nivel5);
            $this->table->add_row(7,'<strong>Aprobadas ordenes de compras',$registros->nivel6);
            $this->table->add_row(8,'<strong>Aprobadas compromisos presupuestarios',$registros->nivel7);
            $this->table->add_row(8,'<strong>Solicitudes denegadas',$registros->nivel9);
            $this->table->add_row(9,'<strong>Total de solicitudes',$registros->total);
        } else {
          $msg = array('data' => "No se encontraron resultados", 'colspan' => "3");
          $this->table->add_row($msg);
        }
        $table = "<div class='content_table'>".
                "<div class='limit-content-title'><span class='icono icon-table icon-title'> ". 'Total Solicitudes'."</span></div>".
                "<div class='table-responsive'>" . $this->table->generate() . "</div><div>";
      }
      $data['body'] = $this->load->view('Compras/Reportes/Reporte_total_solicitudes_view', '',TRUE) . "<br>" . $table;
      $this->load->view('base', $data);
    } else {
      redirect('login/index/forbidden');
    }
  }
}
?>
