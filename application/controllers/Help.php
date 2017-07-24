<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends CI_Controller {

	public function __construct() {
    parent::__construct();

    if($this->session->userdata('logged_in') == FALSE){
      redirect('login/index/error_no_autenticado');
    }

  }

	public function sendMail() {

    $USER = $this->session->userdata('logged_in');

    $from = $this->User_model->obtenerUsuario($USER['id']);

    $this->load->library("email");

		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'alb2594@gmail.com',
			'smtp_pass' => '3JRoMIBAKbbR',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);

    $this->email->initialize($configGmail);
    //$from->correo
		$this->email->from("alb2594@gmail.com");
		$this->email->to("alb2594@gmail.com");
    $this->email->cc("valb4991@hotmail.com", "moises.oct@gmail.com", "pablo.tobar711@gmail.com");
		$this->email->subject($this->input->post('asunto'));
		$this->email->message($this->input->post('msj'));
    $this->email->attach(base_url('uploads/'.$this->input->post('image')));
		$this->email->send();
    
    unlink("uploads/".$this->input->post('image'));

    echo $this->email->print_debugger();

	}

  public function seveScreen() {
    $img = $this->input->post('img');
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $im = imagecreatefromstring($data);  //convertir text a imagen

    // generando nombre imagen
    date_default_timezone_set('America/El_Salvador');
    $name = "screenshots-" . date("Y-m-d-H-i");

    if ($im !== false) {
        imagejpeg($im, 'uploads/'.$name.'.jpg'); //guardar a server
        imagedestroy($im); //liberar memoria
        echo $name;
    }else {
        echo '';
    }

  }

  public function eliminarImagen() {
    unlink("uploads/".$this->input->post('image'));
  }

}
