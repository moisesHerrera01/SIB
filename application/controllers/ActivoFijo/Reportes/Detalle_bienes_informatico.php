<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detalle_bienes_informatico extends CI_Controller {

  public function __construct() {
    parent::__construct();
    if($this->session->userdata('logged_in') == FALSE){
      redirect('login/index/error_no_autenticado');
    }
    $this->load->helper(array('form', 'paginacion'));
    $this->load->library('table');
    $this->load->model(array('ActivoFijo/Equipo_informatico_model','ActivoFijo/Bienes_inmuebles_model'));
  }

  public function index(){
    $data['title'] = "Detalle Movimiento";
    $msg = array('alert' => $this->uri->segment(6),'controller'=>'Detalle_bienes_informatico');
		$data['body'] = $this->load->view('mensajes', $msg, TRUE) . $this->load->view('ActivoFijo/Reportes/detalle_bienes_informatico_view',$msg,TRUE) .
                    "<br><div class='content_table table-responsive'>" .
                    "<div class='limit-content-title'><span class='icono icon-table icon-title'> Detalle Bienes informáticos</span></div>".
                    "<div class='limit-content'>" . $this->mostrarTabla()."</div>";
    $data['menu'] = $this->menu_dinamico->menus($this->session->userdata('logged_in'),$this->uri->segment(1));
    $this->load->view('base', $data);
	}

  public function mostrarTabla(){
    $template = array(
        'table_open' => '<table class="table table-striped table-bordered">'
    );
    $this->table->set_template($template);
    $this->table->set_heading('Id','Marca', 'Modelo','Color','Serie','Código','Código anterior','Adquirido','Asignado a');

    $registros = $this->Equipo_informatico_model->obtenerDetalleBienes($this->uri->segment(5));
    if (!($registros == FALSE)) {
        foreach ($registros as $det) {
          $this->table->add_row($det->id_bien,$det->nombre_marca,$det->modelo,$det->color,
          $det->serie,$det->codigo,$det->codigo_anterior,$det->fecha_adquisicion,$det->nombre_empleado);
      }
    } else {
      $msg = array('data' => "Texto no encontrado", 'colspan' => "8");
      $this->table->add_row($msg);
    }
    return $this->table->generate();
  }
}
?>
