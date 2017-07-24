<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submenu extends CI_Controller {

	public function __construct() {
    parent::__construct();

    if($this->session->userdata('logged_in') == FALSE){
      redirect('login/index/error_no_autenticado');
    }

  }

	public function index() {
    $data['title'] = $this->User_model->obtenerModuloCompleto($this->uri->segment(3))->nombre_modulo;
    $data['menu'] = $this->menu_dinamico->menus($this->session->userdata('logged_in'), $this->uri->segment(1));
    $data['body'] = $this->load->view('submenu_view', array(
			'modulos' => $this->User_model->obtenerDependencias($this->uri->segment(3)),
			'atras' => $this->User_model->obtenerPadreModulo($this->uri->segment(3))),
			TRUE);
    $this->load->view('base', $data);
	}
}
