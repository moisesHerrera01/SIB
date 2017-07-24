<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestionar_Solicitud extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper(array('form', 'paginacion'));
    $this->load->library(array('table', 'notificacion'));
    $this->load->model(array('Compras/Solicitud_Compra_Model','Compras/Detalle_solicitud_compra_model',
    'Bodega/Solicitud_Model'));
  }

  public function index(){
    if($this->session->userdata('logged_in')){
      $data['title'] = "Gestionar Solicitudes";
      $data['js'] = "assets/js/modal_sol.js";
      $pri=$this->Solicitud_Compra_Model->obtenerIdSolicitudCompra();
      $USER = $this->session->userdata('logged_in');
      $solicitante=$USER['nombre_completo'];
      $id_seccion=$USER['id_seccion'];
      date_default_timezone_set('America/El_Salvador');
      $anyo=20;
      $fecha_actual=date($anyo."y-m-d");
      $msg = array('alert' => $this->uri->segment(4),'fecha'=>$fecha_actual,'id'=>$pri,'controller'=>'Gestionar_Solicitud',
      'solicitante'=>$solicitante);
      $hola ['com']=$this->Solicitud_Compra_Model->obtenerDatosSolicitud($this->uri->segment(4));
      $data['body'] =  $this->load->view('mensajes', $msg, TRUE) . $this->load->view('Compras/Gestionar_solicitud_view',$msg,TRUE) .
                      $this->load->view('modals/Comentarios',$hola,TRUE) . $this->load->view('modals/asignacion_solicitud', "",TRUE) .
                      "<br><div class='content_table '>" .
                      "<div class='limit-content-title'><span class='icono icon-table icon-title'> Solicitudes de Compra</span></div>".
                      "<div class='limit-content'>" . $this->mostrarTabla() . "</div></div>";
      $data['menu'] = $this->menu_dinamico->menus($this->session->userdata('logged_in'),$this->uri->segment(1));
      $this->load->view('base', $data);

    } else {
      redirect('login/index/error_no_autenticado');
    }
  }

  public function mostrarTabla() {
    $USER = $this->session->userdata('logged_in');
    if($USER){

      /*
      * Configuracion de la tabla
      */
      $seccion;
      $template = array(
          'table_open' => '<table class="table table-striped table-bordered">'
      );
      $this->table->set_template($template);
      $this->table->set_heading('Id','Número','Fecha','Estado','Asignado a','Aprobar','Denegar','Detalle', 'Editar', 'Imprimir Solicitud','Adjuntos','Comentario');

      $nivel = array();
      if ($USER['rol'] == 'JEFE COMPRAS' || $USER['rol'] == 'COLABORADOR COMPRAS' || $USER['rol'] == 'JEFE UACI' || $USER['rol'] == 'COLABORADOR UACI') {
        $nivel[] = 3;
        $nivel[] = 4;
        $nivel[] = 5;
        $nivel[] = 6;
        $nivel[] = 7;
        $nivel[] = 8;
        $nivel[] = 9;
        $seccion = 0;
      }
      elseif ($USER['rol'] == 'ADMINISTRADOR SICBAF') {
        $nivel[] = 0;
        $nivel[] = 1;
        $nivel[] = 2;
        $nivel[] = 3;
        $nivel[] = 4;
        $nivel[] = 5;
        $nivel[] = 6;
        $nivel[] = 7;
        $nivel[] = 8;
        $nivel[] = 9;
        $seccion = 0;
      }

      $num = '10';
      $pagination = '';
      $registros;
      if ($this->input->is_ajax_request()) {
        if (!($this->input->post('busca') == "")) {
            $registros = $this->Solicitud_Compra_Model->buscarSolicitudes($this->input->post('busca'),date("Y"));
        } else {
            $registros = $this->Solicitud_Compra_Model->obtenerSolicitudesEstadoLimit($nivel, $seccion, $num, $this->uri->segment(4),date("Y"));
            $pagination = paginacion('index.php/Compras/Gestionar_Solicitud/index/', $this->Solicitud_Compra_Model->totalSolicitudesCompra($seccion,date("Y"))->cantidad,
                          $num, '4');
        }
      } else {
            $registros = $this->Solicitud_Compra_Model->obtenerSolicitudesEstadoLimit($nivel, $seccion, $num, $this->uri->segment(4),date("Y"));
            $pagination = paginacion('index.php/Compras/Gestionar_Solicitud/index/', $this->Solicitud_Compra_Model->totalSolicitudesCompra($seccion,date("Y"))->cantidad,
                          $num, '4');
      }

      /*
      * llena la tabla con los datos consultados
      */
      if (!($registros == FALSE)) {
        foreach($registros as $sol) {
          $numero;
          if ($sol->nivel_solicitud<4 || ($sol->nivel_solicitud==9 && $sol->nivel_anterior<4)) {
            $numero='S/E';
          }else {
            $numero=$sol->nombre_fuente.'-'.$sol->numero_solicitud_compra.'/'.substr($sol->fecha_solicitud_compra,0,-6);
          }
            $modulo=$this->User_model->obtenerModulo('Compras/Gestionar_Solicitud');
            $id_rol = $USER['id_rol'];
            $seccion = $this->Solicitud_Model->obtenerSeccion($USER['id_seccion']);
            $solicitante=$this->Solicitud_Compra_Model->obtenerSolicitante($sol->solicitante);
            $comentario = '<a class="icono icon-detalle modal_open" data-id="'.$sol->id_solicitud_compra.'"></a>';
            $asignacion = '<a class="icono icon-user-plus" data-id="'.$sol->id_solicitud_compra.'" data-empleado="'.$sol->id_empleado.'"> &#32;</a>
                          <span id="asignacion-'.$sol->id_solicitud_compra.'">'. $sol->asignacion_solicitud .'</span>';
            if ($USER['rol'] == 'JEFE COMPRAS' || $USER['rol'] == 'JEFE UACI') {
              if ($sol->nivel_solicitud == 3 || $sol->nivel_solicitud == 4){
                $asignacion = '<a class="icono icon-user-plus modal_open_asignacion" data-id="'.$sol->id_solicitud_compra.'" data-empleado="'.$sol->id_empleado.'"> &#32;</a>
                              <span id="asignacion-'.$sol->id_solicitud_compra.'">'. $sol->asignacion_solicitud .'</span>';

                $onClick = "llenarFormulario('solicitud', ['id','solicitante','justificacion',
                'valor','numero_sol','autocompletecrud','asignado'],
                [$sol->id_solicitud_compra, '$solicitante', '$sol->justificacion','$sol->precio_estimado','$sol->numero_solicitud_compra',
                  '$sol->asignacion_solicitud','$sol->id_empleado'], false, false, false, 'comentario_compras', '$sol->comentario_compras')";
                if($sol->nivel_solicitud == 3){
                  $botones='<a class="icono icon-detalle" href="'.base_url('index.php/Compras/Detalle_Solicitud_Compra/index/'.$sol->id_solicitud_compra.'/'.$modulo.'/'.$id_rol.'/').'"></a>';
                  //$eliminar='<a class="icono icon-eliminar" uri='.base_url('index.php/Compras/Gestionar_Solicitud/EliminarDato/'.$sol->id_solicitud_compra).'></a>';
                  $actualizar = '<a class="icono icon-pencil" title="Actualizar" onClick="'.$onClick.'"></a>';
                  $numero_sol = $this->Solicitud_Compra_Model->obtenerSolicitudCompra($sol->id_solicitud_compra);
                  if ($numero_sol==0) {
                    $aprobar= '<a class="icono icon-liquidar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/Aprobar/'.$sol->id_solicitud_compra.'/').'"></a>';
                  }else {
                    $aprobar = '<a class="icono icon-liquidar aprobar_compra" data-url="index.php/Compras/Gestionar_Solicitud/Aprobar/'.$sol->id_solicitud_compra.'/" data-url-table="index.php/Compras/Gestionar_Solicitud/mostrarTabla"></a>';
                  }
                  $denegar = '<a class="icono icon-cross denegar_compra" data-url="index.php/Compras/Gestionar_Solicitud/Denegar/'.$sol->id_solicitud_compra.'/" data-url-table="index.php/Compras/Gestionar_Solicitud/mostrarTabla"></a>';
                  $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';
                  $solicitud_imp = '<a class="icono icon-acta" href="'.base_url('index.php/Compras/Solicitud/index/'.$sol->id_solicitud_compra.'/').'" target="_blank"></a>';
                  $estado = 'POR APROBAR';
                }

                if($sol->nivel_solicitud == 4){
                  $botones='<a class="icono icon-detalle" href="'.base_url('index.php/Compras/Detalle_Solicitud_Compra/index/'.$sol->id_solicitud_compra.'/'.$modulo.'/'.$id_rol.'/').'"></a>';
                  //$eliminar='<a class="icono icon-denegar"></a>';
                  $actualizar = '<a class="icono icon-pencil" title="Actualizar" onClick="'.$onClick.'"></a>';
                  $aprobar = '<a class="icono icon-denegar"></a>';
                  //$denegar = '<a class="icono icon-denegar"></a>';
                  $denegar = '<a class="icono icon-cross denegar_compra" data-url="index.php/Compras/Gestionar_Solicitud/Denegar/'.$sol->id_solicitud_compra.'/" data-url-table="index.php/Compras/Gestionar_Solicitud/mostrarTabla"></a>';
                  $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';
                  $solicitud_imp = '<a class="icono icon-acta" href="'.base_url('index.php/Compras/Solicitud/index/'.$sol->id_solicitud_compra.'/').'" target="_blank"></a>';
                  $estado = 'APROBADA COMPRAS';
                }

                $this->table->add_row($sol->id_solicitud_compra,$numero,$sol->fecha_solicitud_compra,$estado,$asignacion,$aprobar,
                $denegar,$botones,$actualizar, $solicitud_imp,$descargar_archivo,$comentario);

              } elseif ($sol->nivel_solicitud == 5 || $sol->nivel_solicitud == 6 || $sol->nivel_solicitud == 7 || $sol->nivel_solicitud == 8) {

                $botones='<a class="icono icon-detalle" href="'.base_url('index.php/Compras/Detalle_Solicitud_Compra/index/'.$sol->id_solicitud_compra.'/'.$modulo.'/'.$id_rol.'/').'"></a>';
                //$eliminar= '<a class="icono icon-denegar"></a>';
                $actualizar = '<a class="icono icon-denegar"></a>';
                $aprobar = '<a class="icono icon-denegar"></a>';
                $denegar = '<a class="icono icon-denegar"></a>';
                $solicitud_imp = '<a class="icono icon-acta" href="'.base_url('index.php/Compras/Solicitud/index/'.$sol->id_solicitud_compra.'/').'" target="_blank"></a>';
                $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';
                $estado = 'APROBADA';

                $this->table->add_row($sol->id_solicitud_compra,$numero,$sol->fecha_solicitud_compra,$estado,$asignacion,$aprobar,
                $denegar,$botones,$actualizar, $solicitud_imp,$descargar_archivo,$comentario);

              } elseif ($sol->nivel_solicitud == 9 && $sol->nivel_anterior == 3){

                $botones='<a class="icono icon-detalle" href="'.base_url('index.php/Compras/Detalle_Solicitud_Compra/index/'.$sol->id_solicitud_compra.'/'.$modulo.'/'.$id_rol.'/').'"></a>';
                //$eliminar= '<a class="icono icon-denegar"></a>';
                $actualizar = '<a class="icono icon-denegar"></a>';
                $aprobar = '<a class="icono icon-denegar"></a>';
                $denegar = '<a class="icono icon-denegar"></a>';
                $solicitud_imp = '<a class="icono icon-acta" href="'.base_url('index.php/Compras/Solicitud/index/'.$sol->id_solicitud_compra.'/').'" target="_blank"></a>';
                $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';+
                $estado = $sol->estado_solicitud_compra;

                //$estado = 'puta vida';

                $this->table->add_row($sol->id_solicitud_compra,$numero,$sol->fecha_solicitud_compra,$estado,$asignacion,$aprobar,
                $denegar,$botones,$actualizar, $solicitud_imp,$descargar_archivo,$comentario);

              }
            }

            if ($USER['rol'] == 'COLABORADOR COMPRAS' || $USER['rol'] == 'COLABORADOR UACI') {
              if ($sol->nivel_solicitud == 3 || $sol->nivel_solicitud == 4){
                $onClick = "llenarFormulario('solicitud', ['id','solicitante','justificacion',
                'valor','numero_sol','autocompletecrud','asignado'],
                [$sol->id_solicitud_compra, '$solicitante', '$sol->justificacion','$sol->precio_estimado','$sol->numero_solicitud_compra',
                  '$sol->asignacion_solicitud','$sol->id_empleado'], false, false, false, 'comentario_compras', '$sol->comentario_compras')";
                if($sol->nivel_solicitud == 3){
                $botones='<a class="icono icon-detalle" href="'.base_url('index.php/Compras/Detalle_Solicitud_Compra/index/'.$sol->id_solicitud_compra.'/'.$modulo.'/'.$id_rol.'/').'"></a>';
                //$eliminar='<a class="icono icon-eliminar" uri='.base_url('index.php/Compras/Gestionar_Solicitud/EliminarDato/'.$sol->id_solicitud_compra).'></a>';
                $actualizar = '<a class="icono icon-pencil" title="Actualizar" onClick="'.$onClick.'"></a>';
                $aprobar = '<a class="icono icon-denegar"></a>';
                $denegar = '<a class="icono icon-denegar"></a>';
                $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';
                $solicitud_imp = '<a class="icono icon-acta" href="'.base_url('index.php/Compras/Solicitud/index/'.$sol->id_solicitud_compra.'/').'" target="_blank"></a>';
                $estado = 'POR APROBAR';}

                if($sol->nivel_solicitud == 4){
                $botones='<a class="icono icon-detalle" href="'.base_url('index.php/Compras/Detalle_Solicitud_Compra/index/'.$sol->id_solicitud_compra.'/'.$modulo.'/'.$id_rol.'/').'"></a>';
                //$eliminar='<a class="icono icon-denegar"></a>';
                $actualizar = '<a class="icono icon-pencil" title="Actualizar" onClick="'.$onClick.'"></a>';
                $aprobar = '<a class="icono icon-denegar"></a>';
                $denegar = '<a class="icono icon-denegar"></a>';
                //$denegar = '<a class="icono icon-cross" href="'.base_url('index.php/Compras/Gestionar_Solicitud/Denegar/'.$sol->id_solicitud_compra.'/').'"></a>';
                $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';
                $solicitud_imp = '<a class="icono icon-acta" href="'.base_url('index.php/Compras/Solicitud/index/'.$sol->id_solicitud_compra.'/').'" target="_blank"></a>';
                $estado = 'APROBADA COMPRAS';}


                $this->table->add_row($sol->id_solicitud_compra,$numero,$sol->fecha_solicitud_compra,$estado,$asignacion,$aprobar,
                $denegar,$botones,$actualizar, $solicitud_imp,$descargar_archivo,$comentario);

              } elseif ($sol->nivel_solicitud == 5 || $sol->nivel_solicitud == 6 || $sol->nivel_solicitud == 7 || $sol->nivel_solicitud == 8) {

                $botones='<a class="icono icon-detalle" href="'.base_url('index.php/Compras/Detalle_Solicitud_Compra/index/'.$sol->id_solicitud_compra.'/'.$modulo.'/'.$id_rol.'/').'"></a>';
                //$eliminar= '<a class="icono icon-denegar"></a>';
                $actualizar = '<a class="icono icon-denegar"></a>';
                $aprobar = '<a class="icono icon-denegar"></a>';
                $denegar = '<a class="icono icon-denegar"></a>';
                $solicitud_imp = '<a class="icono icon-acta" href="'.base_url('index.php/Compras/Solicitud/index/'.$sol->id_solicitud_compra.'/').'" target="_blank"></a>';
                $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';
                $estado = 'APROBADA';

                $this->table->add_row($sol->id_solicitud_compra,$numero,$sol->fecha_solicitud_compra,$estado,$asignacion,$aprobar,
                $denegar,$botones,$actualizar, $solicitud_imp,$descargar_archivo,$comentario);

              } elseif ($sol->nivel_solicitud == 9 && $sol->nivel_anterior == 3){


                $botones='<a class="icono icon-detalle" href="'.base_url('index.php/Compras/Detalle_Solicitud_Compra/index/'.$sol->id_solicitud_compra.'/'.$modulo.'/'.$id_rol.'/').'"></a>';
                //$eliminar= '<a class="icono icon-denegar"></a>';
                $actualizar = '<a class="icono icon-denegar"></a>';
                $aprobar = '<a class="icono icon-denegar"></a>';
                $denegar = '<a class="icono icon-denegar"></a>';
                $solicitud_imp = '<a class="icono icon-acta" href="'.base_url('index.php/Compras/Solicitud/index/'.$sol->id_solicitud_compra.'/').'" target="_blank"></a>';
                $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';+
                $estado = $sol->estado_solicitud_compra;


                $this->table->add_row($sol->id_solicitud_compra,$numero,$sol->fecha_solicitud_compra,$estado,$asignacion,$aprobar,
                $denegar,$botones,$actualizar, $solicitud_imp,$descargar_archivo,$comentario);

              }
            }

            if ($USER['rol'] == 'ADMINISTRADOR SICBAF') {
              if ($sol->nivel_solicitud == 4 || $sol->nivel_solicitud == 5 || $sol->nivel_solicitud == 6 || $sol->nivel_solicitud == 7 || $sol->nivel_solicitud == 8 || $sol->nivel_solicitud == 9){

                $botones='<a class="icono icon-detalle" href="'.base_url('index.php/Compras/Detalle_Solicitud_Compra/index/'.$sol->id_solicitud_compra.'/'.$modulo.'/'.$id_rol.'/').'"></a>';
                //$eliminar= '<a class="icono icon-denegar"></a>';
                $actualizar = '<a class="icono icon-denegar"></a>';
                $aprobar = '<a class="icono icon-denegar"></a>';
                $denegar = '<a class="icono icon-denegar"></a>';
                $solicitud_imp = '<a class="icono icon-acta" href="'.base_url('index.php/Compras/Solicitud/index/'.$sol->id_solicitud_compra.'/').'" target="_blank"></a>';
                $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';+
                $estado = $sol->estado_solicitud_compra;

                $this->table->add_row($sol->id_solicitud_compra,$numero,$sol->fecha_solicitud_compra,$estado,$asignacion,$aprobar,
                $denegar,$botones,$actualizar, $solicitud_imp,$descargar_archivo,$comentario);
            } elseif ($sol->nivel_solicitud == 3){
              $asignacion = '<a class="icono icon-user-plus modal_open_asignacion" data-id="'.$sol->id_solicitud_compra.'" data-empleado="'.$sol->id_empleado.'"> &#32;</a>
                            <span id="asignacion-'.$sol->id_solicitud_compra.'">'. $sol->asignacion_solicitud .'</span>';

              $onClick = "llenarFormulario('solicitud', ['id','solicitante','justificacion',
              'valor','numero_sol','autocompletecrud','asignado'],
              [$sol->id_solicitud_compra, '$solicitante', '$sol->justificacion','$sol->precio_estimado','$sol->numero_solicitud_compra',
                '$sol->asignacion_solicitud','$sol->id_empleado'], false, false, false, 'comentario_compras', '$sol->comentario_compras')";

              $botones='<a class="icono icon-detalle" href="'.base_url('index.php/Compras/Detalle_Solicitud_Compra/index/'.$sol->id_solicitud_compra.'/'.$modulo.'/'.$id_rol.'/').'"></a>';
              //$eliminar='<a class="icono icon-eliminar" uri='.base_url('index.php/Compras/Gestionar_Solicitud/EliminarDato/'.$sol->id_solicitud_compra).'></a>';
              $actualizar = '<a class="icono icon-pencil" title="Actualizar" onClick="'.$onClick.'"></a>';
              $numero_sol = $this->Solicitud_Compra_Model->obtenerSolicitudCompra($sol->id_solicitud_compra);
              if ($numero_sol==0) {
                $aprobar= '<a class="icono icon-liquidar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/Aprobar/'.$sol->id_solicitud_compra.'/').'"></a>';
              }else {
                $aprobar = '<a class="icono icon-liquidar aprobar_compra" data-url="index.php/Compras/Gestionar_Solicitud/Aprobar/'.$sol->id_solicitud_compra.'/" data-url-table="index.php/Compras/Gestionar_Solicitud/mostrarTabla"></a>';
              }
              $denegar = '<a class="icono icon-cross denegar_compra" data-url="index.php/Compras/Gestionar_Solicitud/Denegar/'.$sol->id_solicitud_compra.'/" data-url-table="index.php/Compras/Gestionar_Solicitud/mostrarTabla"></a>';
              $solicitud_imp = '<a class="icono icon-acta" href="'.base_url('index.php/Compras/Solicitud/index/'.$sol->id_solicitud_compra.'/').'" target="_blank"></a>';
              $descargar_archivo= '<a class="icono icon-descargar" href="'.base_url('index.php/Compras/Gestionar_Solicitud/descargarArchivo/'.$sol->id_solicitud_compra.'/').'"></a>';
              $estado = $sol->estado_solicitud_compra;

              $this->table->add_row($sol->id_solicitud_compra,$numero,$sol->fecha_solicitud_compra,$estado,$asignacion,$aprobar,
              $denegar,$botones,$actualizar,$solicitud_imp,$descargar_archivo,$comentario);
            }
          }
        }
        } else {
        $msg = array('data' => "No hay requerimientos de compra ingresados", 'colspan' => "11");
        $this->table->add_row($msg);
      }

      /*
      * vuelve a verificar para mostrar los datos
      */
      if ($this->input->is_ajax_request()) {
        echo "<div class='table-responsive'>" . $this->table->generate() . "</div>" . $pagination;
      } else {
        return "<div class='table-responsive'>" . $this->table->generate() . "</div>" . $pagination;
      }

    } else {
      redirect('login/index/error_no_autenticado');
    }
  }
  public function Aprobar() {
    $id = $this->uri->segment(4);
    $nivel = $this->Solicitud_Compra_Model->obtenerNivelSolicitud($id);
    $numero = $this->Solicitud_Compra_Model->obtenerSolicitudCompra($id);
    $modulo=$this->User_model->obtenerModulo('Compras/Gestionar_Solicitud');
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
    );
    if($USER){
      if ($numero==0) {
      redirect('/Compras/Gestionar_Solicitud/index/nonumero');
      }else {
        if ($nivel == 3){
          $data = array(
              'estado_solicitud_compra' => 'APROBADA COMPRAS',
              'nivel_solicitud' => $nivel + 1,
              'comentario_compras' => strtoupper($this->input->post('comentario'))
          );
        }
        $rastrea['operacion']='ACTUALIZA';
        $rastrea['id_registro']=$id;
        $this->Solicitud_Compra_Model->actualizarSolicitudCompra($id,$data);
        $this->notificacion->NotificacionSolicitudCompra($id, $USER, 4);
        $this->User_model->insertarRastreabilidad($rastrea);
        redirect('/Compras/Gestionar_Solicitud/index/nonumero');
      }
    } else {
      redirect('login/index/error_no_autenticado');
    }

  }


  public function Denegar() {
    $USER = $this->session->userdata('logged_in');
    if($USER){
      $id = $this->uri->segment(4);
      //$estado = $this->Solicitud_Compra_Model->obtenerEstadoSolicitud($id);
      $nivel = $this->Solicitud_Compra_Model->obtenerNivelSolicitud($id);
      $data = array(
          'estado_solicitud_compra' => 'DENEGADA',
          'nivel_anterior' => $nivel,
          'nivel_solicitud' => 9,
          'comentario_compras' => strtoupper($this->input->post('comentario'))
      );
      $this->Solicitud_Compra_Model->actualizarSolicitudCompra($id,$data);
      $this->notificacion->NotificacionSolicitudCompra($id, $USER, 9);
      //redirect('/Compras/Gestionar_Solicitud/index/update');
    } else {
      redirect('login/index/error_no_autenticado');
    }

  }

  public function asignarEmpleadoSolicitud() {
    $modulo=$this->User_model->obtenerModulo('Compras/Gestionar_Solicitud');
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
      'operacion' => 'ACTUALIZA',
      'id_registro' => $this->input->post('id')
    );
    $id_seccion=$USER['id_seccion'];
    $botones;
    if($USER){
      if ($this->User_model->validarAccesoCrud($modulo, $USER['id'], 'update')) {
        $data = array(
            'asignacion_solicitud' => $this->input->post('empleado')
        );
        $this->Solicitud_Compra_Model->actualizarSolicitudCompra($this->input->post('id'),$data);
        $this->User_model->insertarRastreabilidad($rastrea);
        $this->notificacion->NotificacionSolicitudCompra($this->input->post('id'), $USER, 11);
        echo "true";
      } else {
        echo "false";
      }
    }
  }


  public function ActualizarDatos() {
    $modulo=$this->User_model->obtenerModulo('Compras/Gestionar_Solicitud');
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
    );
    $id_seccion=$USER['id_seccion'];
    $botones;
    if($USER){
      $data = array(
          'comentario_compras' => $this->input->post('comentario_compras'),
          'justificacion'=>$this->input->post('justificacion'),
          'numero_solicitud_compra' => $this->input->post('numero_sol'),
          'asignacion_solicitud' => $this->input->post('asignado')
      );

      /*Obtener el numero de requerimiento en base a la fuente de fondos
      $fuente=$this->Compromiso_Presupuestario_Model->obtenerUltimoFuente($data['id_fuentes']);
      $numero_solicitud_compra;
      if($fuente->ultimo!=NULL){
        $numero_solicitud_compra=$fuente->ultimo+1;
      }else{
        $numero_solicitud_compra=1;
      }*/

      if (!($this->input->post('id') == '')){
        if ($this->User_model->validarAccesoCrud($modulo, $USER['id'], 'update')) {
          $this->Solicitud_Compra_Model->actualizarSolicitudCompra($this->input->post('id'),$data);
          $rastrea['operacion']='ACTUALIZA';
          $rastrea['id_registro']=$this->input->post('id');
          $this->User_model->insertarRastreabilidad($rastrea);
          if ($this->input->post('asignado') != '') {
            $this->notificacion->NotificacionSolicitudCompra($this->input->post('id'), $USER, 11);
          }
          redirect('/Compras/Gestionar_Solicitud/index/update');
        } else {
          redirect('/Compras/Gestionar_Solicitud/index/forbidden');
        }
      }
    } else {
      redirect('login/index/error_no_autenticado');
    }
  }

  public function EliminarDato(){
    $modulo=$this->User_model->obtenerModulo('Compras/Gestionar_Solicitud');
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
        if ($this->Solicitud_Compra_Model->existeSolicitudCompra($id)){
          redirect('/Compras/Gestionar_Solicitud/index/existeSol');
        }
        else {
          $this->Solicitud_Compra_Model->eliminarSolicitudCompra($id);
          $this->User_model->insertarRastreabilidad($rastrea);
          redirect('/Compras/Gestionar_Solicitud/index/delete');
        }
      } else {
        redirect('/Compras/Gestionar_Solicitud/index/forbidden');
      }
    } else {
      redirect('login/index/error_no_autenticado');
    }
  }

  public function descargarArchivo($id) {
    $this->load->helper('download');
    $sol=$this->Solicitud_Compra_Model->obtenerSolicitudCompleta($id);
    $name=$sol->documento_especificaciones;
    force_download("uploads/$name", NULL);
    //redirect('/Compras/Gestionar_Solicitud/index/descargado');
  }


  public function autocompleteColaboradores() {
    $registros = '';
    if ($this->input->is_ajax_request()) {
      $roles = $this->User_model->obtenerRolesSistema();
      if (!($this->input->post('autocomplete') == "")) {
          $registros = $this->User_model->obtenerColaboradoesCompra($roles[10]['id_rol'], $this->input->post('autocomplete'));
      } else {
          $registros = $this->User_model->obtenerColaboradoesCompra($roles[10]['id_rol']);
      }
    } else {
          $registros = $this->User_model->obtenerColaboradoesCompra($roles[10]['id_rol']);
    }

    if ($registros == '') {
      echo '<div id="1" class="suggest-element"><a id="conteo">No se encontraron coincidencias</a></div>';
    }else {
      $i = 1;
      foreach ($registros as $colaborador) {
        echo '<div id="'.$i.'" class="suggest-element" ida="colaborador'.$colaborador->id_empleado.'"><a id="colaborador'.
        $colaborador->id_empleado.'" data="'.$colaborador->id_empleado.'"  data1="'.$colaborador->nombre_empleado.'" >'
        .$colaborador->nombre_empleado.'</a></div>';
        $i++;
      }
    }
  }

}
?>
