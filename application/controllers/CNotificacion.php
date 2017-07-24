<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CNotificacion extends CI_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->helper(array('url'));
    $this->load->library(array('notificacion'));
  }

  public function ConsultarNotificaciones(){
    $USER = $this->session->userdata('logged_in');
    $id_compromiso = $this->input->post('id');
    $data = array();

    $notificaciones = $this->notificacion->obtenerNotificaciones($USER['id']);
    if ($notificaciones) {
      foreach ($notificaciones as $not) {
        $data[] = $not;
      }

      print json_encode($data);
    }
  }

  public function TotalNotificaciones() {
    $USER = $this->session->userdata('logged_in');
    print $this->notificacion->totalNotificacion($USER['id']);
  }

  public function RecibirDatos($data = '') {
    if (is_array($data)) {
      $this->notificacion->insertarNotificacion($data);
    }
  }

  public function EliminarDato() {
    $id = $this->input->post('id');
    $this->notificacion->eliminarNotificacion($id);
    print $this->TotalNotificaciones();
  }

}
?>
