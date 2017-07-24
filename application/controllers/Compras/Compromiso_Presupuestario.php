<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Compromiso_Presupuestario extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->helper(array('url', 'form', 'paginacion'));
    $this->load->library(array('table','notificacion'));
    $this->load->model(array('Compras/Compromiso_Presupuestario_Model','Compras/Solicitud_Compra_Model'));
  }
  public function index(){
    if($this->session->userdata('logged_in')){
        $data['title'] = "Compromisos Presupuestarios";
        $data['js'] = "assets/js/validate/compromiso.js";
        $msg = array('alert' => $this->uri->segment(4), );
        $data['body'] = $this->load->view('mensajes', $msg, TRUE) . $this->load->view('Compras/compromiso_presupuestario_view', '', TRUE) .
                        "<br><div class='content_table'>" .
                        "<div class='limit-content-title'><span class='icono icon-table icon-title'> Historial de Compromisos</span></div>".
                        "<div class='limit-content'>" . $this->mostrarTabla() . "</div></div>";
        $data['menu'] = $this->menu_dinamico->menus($this->session->userdata('logged_in'),$this->uri->segment(1));
        $this->load->view('base', $data);
      } else {
        redirect('login/index/error_no_autenticado');
      }
    }
  public function mostrarTabla(){
    date_default_timezone_set('America/El_Salvador');
    $anyo=20;
    $anyo_en_curso=date($anyo."y");
    /*
    * Configuracion de la tabla
    */
    $modulo=$this->User_model->obtenerModulo('Compras/Compromiso_Presupuestario');
    $USER = $this->session->userdata('logged_in');
    if($USER){
      if ($this->User_model->validarAccesoCrud($modulo, $USER['id'], 'update')) {
        $template = array(
            'table_open' => '<table class="table table-striped table-bordered">'
        );
        $this->table->set_template($template);
        $this->table->set_heading('Id','Número','Id disp. financiera','Número Orden','Número compromiso','Confirmar',
        'Detener','Modificar','Eliminar');
        /*
        * Filtro a la BD
        */
        /*Obtiene el numero de registros a mostrar por pagina */
        $num = '10';
        $pagination = '';
        $registros;
        if ($this->input->is_ajax_request()) {
          if (!($this->input->post('busca') == "")) {
              $registros = $this->Compromiso_Presupuestario_Model->buscarCompromisos($this->input->post('busca'),date("Y"),$USER['rol'],$USER['id_empleado']);
          } else {
              $registros = $this->Compromiso_Presupuestario_Model->obtenerCompromisosLimit($num, $this->uri->segment(4),date("Y"),$USER['rol'],$USER['id_empleado']);
              $pagination = paginacion('index.php/Compras/Compromiso_Presupuestario/index/', $this->Compromiso_Presupuestario_Model->totalCompromisos(date("Y"),$USER['rol'],$USER['id_empleado']),
                            $num, '4');
          }
        } else {
              $registros = $this->Compromiso_Presupuestario_Model->obtenerCompromisosLimit($num, $this->uri->segment(4),date("Y"),$USER['rol'],$USER['id_empleado']);
              $pagination = paginacion('index.php/Compras/Compromiso_Presupuestario/index/', $this->Compromiso_Presupuestario_Model->totalCompromisos(date("Y"),$USER['rol'],$USER['id_empleado']),
                            $num, '4');
        }
        /*
        * llena la tabla con los datos consultados
        */
        if (!($registros == FALSE)) {
          foreach($registros as $dat) {
            $numero;
            if ($dat->nivel_solicitud<4 || ($dat->nivel_solicitud==9 && $dat->nivel_anterior<4)) {
              $numero='S/E';
            }else {
              $numero=$dat->nombre_fuente.'-'.$dat->numero_solicitud_compra.'/'.substr($dat->fecha_solicitud_compra,0,-6);
            }
              $onClick = "llenarFormulario('compromiso_presupuestario',['numero','id', 'numero_sol','orden_compra','autocomplete4'],
              [$dat->numero_compromiso,$dat->id_compromiso,'$dat->numero_solicitud_compra','$dat->id_orden_compra','$dat->id_orden_compra-$dat->fecha'])";
              $aprobar = '<a class="icono icon-liquidar" href="'.base_url('index.php/Compras/Compromiso_Presupuestario/Aprobar/'.$dat->id_solicitud_compra.'/').'"></a>';
              $denegar = '<a class="icono icon-cross" href="'.base_url('index.php/Compras/Compromiso_Presupuestario/Denegar/'.$dat->id_solicitud_compra.'/').'"></a>';
              if ($USER['rol'] == 'JEFE COMPRAS' || $USER['rol'] == 'JEFE UACI' || $USER['rol'] == 'ADMINISTRADOR SICBAF'){
                if($dat->estado_solicitud_compra=='APROBADA ORDEN DE COMPRA' || $dat->nivel_solicitud==6){
                   $actualizar = '<a class="icono icon-actualizar" onClick="'.$onClick.'"></a>';
                   $aprobar = '<a class="icono icon-liquidar" href="'.base_url('index.php/Compras/Compromiso_Presupuestario/Aprobar/'.$dat->id_solicitud_compra.'/').'"></a>';
                   $denegar = '<a class="icono icon-cross" href="'.base_url('index.php/Compras/Compromiso_Presupuestario/Denegar/'.$dat->id_solicitud_compra.'/').'"></a>';
                   $eliminar =   '<a class="icono icon-eliminar" uri='.base_url('index.php/Compras/Compromiso_Presupuestario/EliminarDatos/'.$dat->id_compromiso).'></a>';
                }elseif ($dat->estado_solicitud_compra=='APROBADA COMPROMISO' || $dat->nivel_solicitud==7) {
                  $actualizar = '<a class="icono icon-denegar"></a>';;
                  $aprobar = '<a class="icono icon-denegar"></a>';
                  $denegar = '<a class="icono icon-denegar"></a>';
                  $eliminar =   '<a class="icono icon-denegar"></a>';
                }
              }
              if ($USER['rol'] == 'COLABORADOR COMPRAS' || $USER['rol'] == 'COLABORADOR UACI'){
                if($dat->estado_solicitud_compra=='APROBADA ORDEN DE COMPRA' || $dat->nivel_solicitud==6){
                   $actualizar = '<a class="icono icon-actualizar" onClick="'.$onClick.'"></a>';
                   $aprobar = '<a class="icono icon-denegar"></a>';
                   $denegar = '<a class="icono icon-denegar"></a>';
                   $eliminar =   '<a class="icono icon-eliminar" uri='.base_url('index.php/Compras/Compromiso_Presupuestario/EliminarDatos/'.$dat->id_compromiso).'></a>';
                }elseif ($dat->estado_solicitud_compra=='APROBADA COMPROMISO' || $dat->nivel_solicitud==7) {
                  $actualizar = '<a class="icono icon-denegar"></a>';;
                  $aprobar = '<a class="icono icon-denegar"></a>';
                  $denegar = '<a class="icono icon-denegar"></a>';
                  $eliminar =   '<a class="icono icon-denegar"></a>';
                }
              }
              $this->table->add_row($dat->id_solicitud_compra,$numero, $dat->id_solicitud_disponibilidad,$dat->numero_orden_compra.'/'.$anyo_en_curso,
              $dat->numero_compromiso,$aprobar,$denegar,$actualizar,$eliminar);
          }
        } else {
          $msg = array('data' => "No hay compromisos presupuestarios ingresados", 'colspan' => "9");
          $this->table->add_row($msg);
        }
        /*
        * vuelve a verificar para mostrar los datos
        */
        if ($this->input->is_ajax_request()) {
          echo "<div class='table-responsive'>" . $this->table->generate() . "</div>" . $pagination;
        } else {
          return  "<div class='table-responsive'>" . $this->table->generate() . "</div>" . $pagination;
        }
      } else {
        redirect('/Compras/Compromiso_Presupuestario/index/forbidden');
      }
    } else {
      redirect('login/index/error_no_autenticado');
    }
  }
  /*
  * Actualiza o Registra al sistema
  */
  public function RecibirDatos(){
    $modulo=$this->User_model->obtenerModulo('Compras/Compromiso_Presupuestario');
    $USER = $this->session->userdata('logged_in');
    if($USER){
        $data = array(
            'numero_compromiso' => $this->input->post('numero'),
            'id_orden_compra' => $this->input->post('orden_compra'),
        );
        $id_solicitud_compra=$this->Compromiso_Presupuestario_Model->obtenerSolicitudCompraPorOrden($data['id_orden_compra']);
        date_default_timezone_set('America/El_Salvador');
        $anyo=20;
        $fecha_actual=date($anyo."y-m-d");
        $hora=date("H:i:s");
        $rastrea = array(
          'id_usuario' =>$USER['id'],
          'id_modulo' =>$modulo,
          'fecha' =>$fecha_actual,
          'hora' =>$hora,
        );
        if (!($this->input->post('id') == '')){
            if ($this->User_model->validarAccesoCrud($modulo, $USER['id'], 'update')) {
                $this->Compromiso_Presupuestario_Model->actualizarCompromiso($this->input->post('id'),$data);
                $rastrea['operacion']='ACTUALIZA';
                $rastrea['id_registro']=$this->input->post('id');
                $this->User_model->insertarRastreabilidad($rastrea);
                redirect('/Compras/Compromiso_Presupuestario/index/update');
              } else {
                redirect('/Compras/Compromiso_Presupuestario/index/forbidden');
              }
        }
      if ($this->User_model->validarAccesoCrud($modulo, $USER['id'], 'insert')) {
        $this->Compromiso_Presupuestario_Model->insertarCompromiso($data);
        $rastrea['operacion']='INSERTA';
        $rastrea['id_registro']=$this->User_model->obtenerSiguienteIdModuloIncrement('sic_compromiso_presupuestario')-1;
        $this->User_model->insertarRastreabilidad($rastrea);
        redirect('/Compras/Compromiso_Presupuestario/index/new');
      } else {
        redirect('/Compras/Compromiso_Presupuestario/index/forbidden');
      }
      } else {
        redirect('login/index/error_no_autenticado');
      }
  }
  /*
  * elimina un registro cuando se le pasa por la url el id
  */
  public function eliminarDatos(){
    $modulo=$this->User_model->obtenerModulo('Compras/Compromiso_Presupuestario');
    $USER = $this->session->userdata('logged_in');
    date_default_timezone_set('America/El_Salvador');
    $anyo=20;
    $fecha_actual=date($anyo."y-m-d");
    $hora=date("H:i:s");
    $rastrea = array(
      'id_usuario' =>$USER['id'],
      'id_modulo' =>$modulo,
      'fecha' =>$fecha_actual,
      'hora' =>$hora,
      'operacion' =>'ELIMINA',
      'id_registro' =>$this->uri->segment(4),
    );
    if($USER){
      if ($this->User_model->validarAccesoCrud($modulo, $USER['id'], 'delete')) {
        $id = $this->uri->segment(4);
        $this->Compromiso_Presupuestario_Model->eliminarCompromiso($id);
        $this->User_model->insertarRastreabilidad($rastrea);
        redirect('/Compras/Compromiso_Presupuestario/index/delete');
      } else {
        redirect('/Compras/Compromiso_Presupuestario/index/forbidden');
      }
    } else {
      redirect('login/index/error_no_autenticado');
    }
  }
  public function Aprobar() {
    $USER = $this->session->userdata('logged_in');
    if($USER){
      $id = $this->uri->segment(4);
      $estado = $this->Solicitud_Compra_Model->obtenerEstadoSolicitud($id);
      $nivel = $this->Solicitud_Compra_Model->obtenerNivelSolicitud($id);
      if ($estado == 'APROBADA ORDEN DE COMPRA' || $nivel==6){
        $data = array(
            'estado_solicitud_compra' => 'APROBADA COMPROMISO',
            'nivel_solicitud' => $nivel + 1
        );
      }
      $this->Solicitud_Compra_Model->actualizarSolicitudCompra($id,$data);
      if ($this->Compromiso_Presupuestario_Model->esCompromisoBodega($id)) {
        $this->notificacion->NotificacionSolicitudCompra($id, $USER, 7);
      }
      redirect('/Compras/Compromiso_Presupuestario/index/update');
    } else {
      redirect('login/index/error_no_autenticado');
    }
  }

  public function Denegar() {
    $USER = $this->session->userdata('logged_in');
    if($USER){
      $id = $this->uri->segment(4);
      $nivel = $this->Solicitud_Compra_Model->obtenerNivelSolicitud($id);
      $data = array(
          'estado_solicitud_compra' => 'DENEGADA',
          'nivel_anterior' => $nivel,
          'nivel_solicitud' => 10
      );
      $this->Solicitud_Compra_Model->actualizarSolicitudCompra($id,$data);
      redirect('/Compras/Compromiso_Presupuestario/index/update');
    } else {
      redirect('login/index/error_no_autenticado');
    }
  }

  /*Este autocompletar se usa en el modulo de factura, muestra el listado de compromisos que contienen ordenes de compra
  con proveedores de rubro BIENES*/
  public function autocomplete_factura(){
    $registros = '';
    if ($this->input->is_ajax_request()) {
      if (!($this->input->post('autocomplete') == "")) {
          $registros = $this->Compromiso_Presupuestario_Model->buscarCompromisosAutocomplete($this->input->post('autocomplete'));
      } else {
          $registros = $this->Compromiso_Presupuestario_Model->obtenerCompromisosAutocomplete();
      }
    } else {
          $registros = $this->Compromiso_Presupuestario_Model->obtenerCompromisosAutocomplete();
    }
    if ($registros == '') {
      echo '<div id="1" class="suggest-element"><a id="conteo">No se encontraron coincidencias</a></div>';
    } else {
      foreach ($registros as $comp) {
        $i = 1;
        if($this->Compromiso_Presupuestario_Model->existeFactura($comp->id_compromiso)){
        } else {
          echo '<div id="'.$i.'" class="suggest-element" ida="compromiso'.$comp->id_compromiso.'"><a id="compromiso'.
          $comp->id_compromiso.'" data="'.$comp->id_compromiso.'"  data1="Compromiso número:'.$comp->numero_compromiso.'" >'
          .'COMPROMISO NÚMERO: '.$comp->numero_compromiso.'</a></div>';
          $i++;
        }
      }
    }
  }
  public function generarJsonCompromiso(){
    $id_compromiso = $this->input->post('id');
    $data;
    $compromiso = $this->Compromiso_Presupuestario_Model->obtenerCompromisoId($id_compromiso);
    $detalle_orden = $this->Compromiso_Presupuestario_Model->obtenerDetalleOrden($id_compromiso);
    $compromiso['detalle_orden'] = $detalle_orden;
    $data[] = $compromiso;
    print json_encode($data);
  }
}
?>
