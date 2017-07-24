<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipo_informatico extends CI_Controller {

  public function __construct() {
    parent::__construct();
    if($this->session->userdata('logged_in') == FALSE){
      redirect('login/index/error_no_autenticado');
    }
    $this->load->helper(array('url', 'form', 'paginacion'));
    $this->load->library('table');
    $this->load->model(array('ActivoFijo/Equipo_informatico_model','ActivoFijo/Categoria_model',
    'ActivoFijo/Subcategoria_Model','ActivoFijo/Procesador_model','ActivoFijo/Disco_Duro_Model',
    'ActivoFijo/Memoria_model','ActivoFijo/Sistema_operativo_model','ActivoFijo/Office_model'));
  }

  public function index(){
    $data['title'] = "Equipo Informático";
    $data['js'] = "assets/js/validate/equipo_informatico.js";
    $msg = array('alert' => $this->uri->segment(5),'id_bien'=>$this->uri->segment(4));
		$data['body'] = $this->load->view('mensajes', $msg, TRUE) . $this->load->view('ActivoFijo/equipo_informatico_view',$msg, TRUE) .
                    "<br><div class='content_table table-responsive'>" .
                    "<div class='limit-content-title'><span class='icono icon-table icon-title'> Caracteristicas</span></div>".
                    "<div class='limit-content'>" . $this->mostrarTabla() . "</div></div>";
    $data['menu'] = $this->menu_dinamico->menus($this->session->userdata('logged_in'),$this->uri->segment(1));
    $this->load->view('base', $data);
	}

  public function mostrarTabla(){
    /*
    * Configuracion de la tabla
    */

    $USER = $this->session->userdata('logged_in');
    $modulo=$this->User_model->obtenerModulo('ActivoFijo/Equipo_informatico');
    if($USER){
      if ($this->User_model->validarAccesoCrud($modulo, $USER['id'], 'select')) {
        $template = array(
            'table_open' => '<table class="table table-striped table-bordered">'
        );
        $this->table->set_template($template);
        $this->table->set_heading('Bien','Equipo', 'Descripción','Modelo','Marca','Tipo','Procesador','Memoria','HDD','SO','Office','Aquirido','Editar','Eliminar');

        /*
        * Filtro a la BD
        */

        /*Obtiene el numero de registros a mostrar por pagina */
        $registros = $this->Equipo_informatico_model->obtenerEquipoInformatico($this->uri->segment(4));

        /*
        * llena la tabla con los datos consultados
        */
        $i=1;
        if (!($registros == FALSE)) {
          foreach($registros as $eq) {
              $eliminar='<a class="icono icon-eliminar" uri='.base_url('index.php/ActivoFijo/Equipo_informatico/EliminarDato/'.$eq->id_equipo_informatico.'/'.$eq->id_bien).'></a>';

                  $onClick = "llenarFormulario('equipo', ['id_equipo_informatico','hdd','autocomplete3','v_hdd','procesador','autocomplete2',
                  'v_procesador','memoria','autocomplete4','v_memoria','so','autocomplete5','clave_so','office','autocomplete6','clave_office',
                  'ip','punto'],
                  [$eq->id_equipo_informatico,'$eq->id_disco_duro','$eq->capacidad','$eq->velocidad_disco_duro','$eq->id_procesador','$eq->nombre_procesador',
                  '$eq->velocidad_procesador','$eq->id_memoria','$eq->tipo_memoria','$eq->velocidad_memoria','$eq->id_sistema_operativo','$eq->version_sistema_operativo',
                  '$eq->clave_sistema_operativo','$eq->id_office','$eq->version_office','$eq->clave_office','$eq->direccion_ip','$eq->numero_de_punto'],
                  ['tipo_computadora'],['$eq->tipo_computadora'])";
                  $actualizar='<a class="icono icon-actualizar" onClick="'.$onClick.'"></a>';
                  $this->table->add_row($eq->id_bien,$eq->id_equipo_informatico,$eq->descripcion,$eq->modelo,$eq->nombre_marca,
                  $eq->tipo_computadora,$eq->nombre_procesador.'/'.$eq->velocidad_procesador,$eq->tipo_memoria.'/'.$eq->velocidad_memoria,
                  $eq->capacidad.'/'.$eq->velocidad_disco_duro,$eq->version_sistema_operativo,$eq->version_office,$eq->fecha_adquisicion,$actualizar,$eliminar);
                $i++;
          }
        } else {
          $msg = array('data' => "Texto no encontrado", 'colspan' => "14");
          $this->table->add_row($msg);
        }

        /*
        * vuelve a verificar para mostrar los datos
        */
        if ($this->input->is_ajax_request()) {
          echo $this->table->generate();
        } else {
          return $this->table->generate();
        }
      } else {
        redirect('/ActivoFijo/Equipo_informatico/index/forbidden');
      }
    } else {
      redirect('login/index/error_no_autenticado');
    }
  }

  /*
  * Actualiza o Registra al sistema
  */
  public function RecibirDatos(){
    $modulo=$this->User_model->obtenerModulo('ActivoFijo/Equipo_informatico');
    $USER = $this->session->userdata('logged_in');
    if($USER){
      $data = array(
          'id_equipo_informatico' => $this->input->post('id_equipo_informatico'),
          'tipo_computadora' => $this->input->post('tipo_computadora'),
          'id_procesador' => $this->input->post('procesador'),
          'id_disco_duro' => $this->input->post('hdd'),
          'id_memoria' => $this->input->post('memoria'),
          'id_sistema_operativo' => $this->input->post('so'),
          'id_office' => $this->input->post('office'),
          'velocidad_procesador' => $this->input->post('v_procesador'),
          'velocidad_disco_duro' => $this->input->post('v_hdd'),
          'velocidad_memoria' => $this->input->post('v_memoria'),
          'clave_sistema_operativo' => $this->input->post('clave_so'),
          'clave_office' => $this->input->post('clave_office'),
          'direccion_ip' => $this->input->post('ip'),
          'numero_de_punto' => $this->input->post('punto'),
          'id_bien' => $this->input->post('id_bien')
      );

      if (!($this->input->post('id_equipo_informatico') == '')){
        if ($this->User_model->validarAccesoCrud($modulo, $USER['id'], 'update')) {
          $this->Equipo_informatico_model->actualizarEquipoInformatico($this->input->post('id_equipo_informatico'),$data);
          redirect('/ActivoFijo/Equipo_informatico/index/'.$data['id_bien'].'/update');
        } else {
          redirect('/ActivoFijo/Equipo_informatico/index/forbidden');
        }
      }

      if ($this->User_model->validarAccesoCrud($modulo, $USER['id'], 'insert')) {
        $this->Equipo_informatico_model->insertarEquipoInformatico($data);
        redirect('/ActivoFijo/Equipo_informatico/index/'.$data['id_bien'].'/new');
      } else {
        redirect('/ActivoFijo/Equipo_informatico/index/forbidden');
      }
    } else {
      redirect('login/index/error_no_autenticado');
    }
  }

  /*
  * elimina un registro cuando se le pasa por la url el id
  */
  public function EliminarDato(){
    $modulo=$this->User_model->obtenerModulo('ActivoFijo/Equipo_informatico');
    $USER = $this->session->userdata('logged_in');
    if($USER){
      if ($this->User_model->validarAccesoCrud($modulo, $USER['id'], 'delete')) {
        $this->Equipo_informatico_model->eliminarEquipoInformatico($this->uri->segment(4));
        redirect('/ActivoFijo/Equipo_informatico/index/'.$this->uri->segment(5).'/delete');
      } else {
        redirect('/ActivoFijo/Equipo_informatico/index/forbidden');
      }
    } else {
      redirect('login/index/error_no_autenticado');
    }
  }

  public function AutocompleteProcesador(){
    $registros = '';
    if ($this->input->is_ajax_request()) {
      if (!($this->input->post('autocomplete') == "")) {
          $registros = $this->Procesador_model->buscarProcesadores($this->input->post('autocomplete'));
      } else {
          $registros = $this->Procesador_model->obtenerProcesadores();
      }
    } else {
          $registros = $this->Procesador_model->obtenerProcesadores();
    }

    if ($registros == '') {
      echo '<div id="1" class="suggest-element"><a id="conteo">No se encontraron coincidencias</a></div>';
    } else {
      $i = 1;
      foreach ($registros as $cat) {
        echo '<div id="'.$i.'" class="suggest-element" ida="procesador'.$cat->id_procesador.'"><a id="procesador'.
        $cat->id_procesador.'" data="'.$cat->id_procesador.'"  data1="'.$cat->nombre_procesador.'" >'
        .$cat->id_procesador.' - '.$cat->nombre_procesador.'</a></div>';
        $i++;
      }
    }
  }

  public function AutocompleteDiscoDuro(){
    $registros = '';
    if ($this->input->is_ajax_request()) {
      if (!($this->input->post('autocomplete') == "")) {
          $registros = $this->Disco_Duro_Model->buscarDiscos($this->input->post('autocomplete'));
      } else {
          $registros = $this->Disco_Duro_Model->obtenerDiscosDuros();
      }
    } else {
          $registros = $this->Disco_Duro_Model->obtenerDiscosDuros();
    }

    if ($registros == '') {
      echo '<div id="1" class="suggest-element"><a id="conteo">No se encontraron coincidencias</a></div>';
    } else {
      $i = 1;
      foreach ($registros as $cat) {
        echo '<div id="'.$i.'" class="suggest-element" ida="disco'.$cat->id_disco_duro.'"><a id="disco'.
        $cat->id_disco_duro.'" data="'.$cat->id_disco_duro.'"  data1="'.$cat->capacidad.'" >'
        .$cat->capacidad.'</a></div>';
        $i++;
      }
    }
  }

  public function AutocompleteMemoria(){
    $registros = '';
    if ($this->input->is_ajax_request()) {
      if (!($this->input->post('autocomplete') == "")) {
          $registros = $this->Memoria_model->buscarMemorias($this->input->post('autocomplete'));
      } else {
          $registros = $this->Memoria_model->obtenerMemorias();
      }
    } else {
          $registros = $this->Memoria_model->obtenerMemorias();
    }

    if ($registros == '') {
      echo '<div id="1" class="suggest-element"><a id="conteo">No se encontraron coincidencias</a></div>';
    } else {
      $i = 1;
      foreach ($registros as $cat) {
        echo '<div id="'.$i.'" class="suggest-element" ida="memoria'.$cat->id_memoria.'"><a id="memoria'.
        $cat->id_memoria.'" data="'.$cat->id_memoria.'"  data1="'.$cat->tipo_memoria.'" >'
        .$cat->tipo_memoria.'</a></div>';
      }
    }
  }

  public function AutocompleteSistemaOperativo(){
    $registros = '';
    if ($this->input->is_ajax_request()) {
      if (!($this->input->post('autocomplete') == "")) {
          $registros = $this->Sistema_operativo_model->buscarSistemas_operativos($this->input->post('autocomplete'));
      } else {
          $registros = $this->Sistema_operativo_model->obtenerSistemas_operativos();
      }
    } else {
          $registros = $this->Sistema_operativo_model->obtenerSistemas_operativos();
    }

    if ($registros == '') {
      echo '<div id="1" class="suggest-element"><a id="conteo">No se encontraron coincidencias</a></div>';
    } else {
      $i = 1;
      foreach ($registros as $cat) {
        echo '<div id="'.$i.'" class="suggest-element" ida="so'.$cat->id_sistema_operativo.'"><a id="so'.
        $cat->id_sistema_operativo.'" data="'.$cat->id_sistema_operativo.'"  data1="'.$cat->version_sistema_operativo.'" >'
        .$cat->version_sistema_operativo.'</a></div>';
        $i++;
      }
    }
  }

  public function AutocompleteOffice(){
    $registros = '';
    if ($this->input->is_ajax_request()) {
      if (!($this->input->post('autocomplete') == "")) {
          $registros = $this->Office_model->buscarOffices($this->input->post('autocomplete'));
      } else {
          $registros = $this->Office_model->obtenerOffices();
      }
    } else {
          $registros = $this->Office_model->obtenerOffices();
    }

    if ($registros == '') {
      echo '<div id="1" class="suggest-element"><a id="conteo">No se encontraron coincidencias</a></div>';
    } else {
      $i = 1;
      foreach ($registros as $cat) {
        echo '<div id="'.$i.'" class="suggest-element" ida="office'.$cat->id_office.'"><a id="office'.
        $cat->id_office.'" data="'.$cat->id_office.'"  data1="'.$cat->version_office.'" >'
        .$cat->version_office.'</a></div>';
        $i++;
      }
    }
  }
}
?>
