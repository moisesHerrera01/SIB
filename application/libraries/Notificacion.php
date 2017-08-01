<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Notificacion.php
 */
class Notificacion {

  public $emisor;
  public $receptor;
  public $mensaje_notificacion;
  public $url_notificacion;
  public $clase_notificacion;

  function __construct() {
    $this->ci =& get_instance();
    $this->ci->load->model(array('User_model', 'Bodega/Solicitud_Model'));
  }

  public function insertarNotificacion($data){

      $this->ci->emisor = $data['emisor'];
      $this->ci->receptor = $data['receptor'];
      $this->ci->mensaje_notificacion = $data['mensaje_notificacion'];
      $this->ci->url_notificacion = $data['url_notificacion'];
      $this->ci->clase_notificacion = $data['clase_notificacion'];

      $this->ci->db->insert('sic_notificacion', $this->ci);
      return $this->ci->db->insert_id();
  }

  public function eliminarNotificacion($id) {
    $this->ci->db->delete('sic_notificacion', array('id_notificacion' => $id));
  }

  public function obtenerNotificaciones($id_usuario) {
    $this->ci->db->from('sic_notificacion')
             ->where('receptor', $id_usuario)
             ->order_by("id_notificacion", "asc");
    $query = $this->ci->db->get();
    if ($query->num_rows() > 0) {
      return $query->result_array();
    } else {
      return FALSE;
    }
  }

  public function totalNotificacion($id_usuario) {
    $this->ci->db->from('sic_notificacion')
             ->where('receptor', $id_usuario);
    return $this->ci->db->count_all_results();
  }

  public function EnviarNotificacion($data) {

    if (is_array($data)) {

      $nombre_emisor = $data['nombre_emisor'];
      $correo_emisor = $data['correo_emisor'];
      $id_emisor = $data['id_emisor'];
      $correo_receptor = $data['correo_receptor'];
      $id_receptor = $data['id_receptor'];
      $asunto = $data['asunto'];
      $mensaje = $data['mensaje'];
      $url = $data['url'];

      if ('' != $id_emisor && '' != $id_receptor && '' != $mensaje && '' != $url) {
        $not = array(
          'emisor' => $id_emisor,
          'receptor' => $id_receptor,
          'mensaje_notificacion' => $mensaje,
          'url_notificacion' => $url,
          'clase_notificacion' => 'success',
        );
        $this->insertarNotificacion($not);
      }

      if ('' != $nombre_emisor && '' != $correo_receptor && '' != $asunto && '' != $mensaje) {
        $this->ci->load->library('email');

        $config = array(
          'protocol' => 'sendmail',
          'mailtype' => 'html'
        );

        $this->ci->email->initialize($config);

        $this->ci->email->from($nombre_emisor);
        $this->ci->email->to($correo_receptor);
        $this->ci->email->subject('SICBAF: ' . $asunto);
        $this->ci->email->message('<h2>' . $mensaje . '</h2>');

        $this->ci->email->send();
      }
    }

  }

  // como emisor recibe a $USER de la sesion
  public function NotificacionSolicitudBodega($id_solicitud, $emisor, $nivel) {
    $emisor = $this->ci->User_model->obtenerUsuario($emisor['id']);
    $data = array();

    $roles = $this->ci->User_model->obtenerRolesSistema();

    switch ($nivel) {
      case 1:
        // enviar a jefe unidad
        $receptor = $this->ci->User_model->obtenerCorreoUsuario($roles[4]['id_rol'], $emisor->id_seccion);
        if ($receptor) {

          $data[0]['nombre_emisor'] = $emisor->nombre_completo;
          $data[0]['correo_emisor'] = $emisor->correo;
          $data[0]['id_emisor'] = $emisor->id_usuario;
          $data[0]['correo_receptor'] = $receptor->correo;
          $data[0]['id_receptor'] = $receptor->id_usuario;
          $data[0]['mensaje'] = "Hay una nueva solicitud que require atención con id " . $id_solicitud;
          $data[0]['asunto'] = 'Solicitud Bodega';
          $data[0]['url'] = base_url("index.php/Bodega/Solicitud_control");
        }

        break;
      case 2:
        // enviar a DA
        $receptor = $this->ci->User_model->obtenerCorreoUsuario($roles[1]['id_rol'], 36);
        if ($receptor) {

          $data[0]['nombre_emisor'] = $emisor->nombre_completo;
          $data[0]['correo_emisor'] = $emisor->correo;
          $data[0]['id_emisor'] = $emisor->id_usuario;
          $data[0]['correo_receptor'] = $receptor->correo;
          $data[0]['id_receptor'] = $receptor->id_usuario;
          $data[0]['mensaje'] = "Hay una nueva solicitud que require atención con id " . $id_solicitud;
          $data[0]['asunto'] = 'Solicitud Bodega';
          $data[0]['url'] = base_url("index.php/Bodega/Solicitud_control");
        }

        // solicitante
        $solicitud = $this->ci->Solicitud_Model->obtenerTodaSolicitud($id_solicitud);
        $receptor = $this->ci->User_model->obtenerUsuario($solicitud[0]->id_usuario);
        if ($receptor) {

          $data[1]['nombre_emisor'] = $emisor->nombre_completo;
          $data[1]['correo_emisor'] = $emisor->correo;
          $data[1]['id_emisor'] = $emisor->id_usuario;
          $data[1]['correo_receptor'] = $receptor->correo;
          $data[1]['id_receptor'] = $receptor->id_usuario;
          $data[1]['mensaje'] = "La solicitud id " . $id_solicitud . " ha sido aprobada por su Jefe.";
          $data[1]['asunto'] = 'Solicitud Bodega';
          $data[1]['url'] = base_url("index.php/Bodega/Solicitud_control");
        }
        break;
      case 3:
        # enviar a Bodega
        $receptor = $this->ci->User_model->obtenerCorreoUsuario($roles[3]['id_rol'], 72);
        if ($receptor) {

          $data[0]['nombre_emisor'] = $emisor->nombre_completo;
          $data[0]['correo_emisor'] = $emisor->correo;
          $data[0]['id_emisor'] = $emisor->id_usuario;
          $data[0]['correo_receptor'] = $receptor->correo;
          $data[0]['id_receptor'] = $receptor->id_usuario;
          $data[0]['asunto'] = "Hay una nueva solicitud que require atención con id " . $id_solicitud;
          $data[0]['mensaje'] = 'Solicitud Bodega';
          $data[0]['url'] = base_url("index.php/Bodega/Solicitud_control");
        }

        // solicitante
        $solicitud = $this->ci->Solicitud_Model->obtenerTodaSolicitud($id_solicitud);
        $receptor = $this->ci->User_model->obtenerUsuario($solicitud[0]->id_usuario);
        if ($receptor) {

          $data[1]['nombre_emisor'] = $emisor->nombre_completo;
          $data[1]['correo_emisor'] = $emisor->correo;
          $data[1]['id_emisor'] = $emisor->id_usuario;
          $data[1]['correo_receptor'] = $receptor->correo;
          $data[1]['id_receptor'] = $receptor->id_usuario;
          $data[1]['mensaje'] = "La solicitud id " . $id_solicitud . " ha sido aprobada por Directora Administrativa.";
          $data[1]['asunto'] = 'Solicitud Bodega';
          $data[1]['url'] = base_url("index.php/Bodega/Solicitud_control");
        }
        break;
      case 4:
        # enviar a solicitante
        $solicitud = $this->ci->Solicitud_Model->obtenerTodaSolicitud($id_solicitud);
        $receptor = $this->ci->User_model->obtenerUsuario($solicitud[0]->id_usuario);
        if ($receptor) {

          $data[0]['nombre_emisor'] = $emisor->nombre_completo;
          $data[0]['correo_emisor'] = $emisor->correo;
          $data[0]['id_emisor'] = $emisor->id_usuario;
          $data[0]['correo_receptor'] = $receptor->correo;
          $data[0]['id_receptor'] = $receptor->id_usuario;
          $data[0]['mensaje'] = "La solicitud id " . $id_solicitud . " ha sido liquidada.";
          $data[0]['asunto'] = 'Solicitud Bodega';
          $data[0]['url'] = base_url("index.php/Bodega/Solicitud_control");
        }

        break;
      case 9:
        # enviar a solicitante
        $solicitud = $this->ci->Solicitud_Model->obtenerTodaSolicitud($id_solicitud);
        $receptor = $this->ci->User_model->obtenerUsuario($solicitud[0]->id_usuario);
        if ($receptor) {

          $data[0]['nombre_emisor'] = $emisor->nombre_completo;
          $data[0]['correo_emisor'] = $emisor->correo;
          $data[0]['id_emisor'] = $emisor->id_usuario;
          $data[0]['correo_receptor'] = $receptor->correo;
          $data[0]['id_receptor'] = $receptor->id_usuario;
          $data[0]['mensaje'] = "La solicitud id " . $id_solicitud . " no ha sido aprobada.";
          $data[0]['asunto'] = 'Solicitud Bodega';
          $data[0]['url'] = base_url("index.php/Bodega/Solicitud_control");
        }
        break;
    }

    foreach ($data as $dato) {
      $this->EnviarNotificacion($dato);
    }
  }

}

?>
