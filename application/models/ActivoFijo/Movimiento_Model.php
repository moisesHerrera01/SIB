<?php
  class Movimiento_model extends CI_Model{

    public $id_movimiento;
    public $id_oficina_entrega;
    public $id_oficina_recibe;
    public $id_empleado;
    public $id_tipo_movimiento;
    public $estado_movimiento;
    public $usuario_externo;
    public $entregado_por;
    public $recibido_por;
    public $visto_bueno_por;
    public $observacion;
    public $id_guarda;
    public $fecha_guarda;
    public $id_actualiza;
    public $id_seccion;



    function __construct() {
        parent::__construct();
    }

    public function insertarMovimiento($data){
        $anyo=20;
        date_default_timezone_set('America/El_Salvador');
        $fecha_actual=date($anyo."y-m-d");
        $USER = $this->session->userdata('logged_in');
        if (array_key_exists('id_movimiento', $data)) {
            $this->id_movimiento = $data['id_movimiento'];
        }
        $this->id_oficina_entrega = $data['id_oficina_entrega'];
        $this->id_oficina_recibe = $data['id_oficina_recibe'];
        $this->id_empleado = $data['id_empleado'];
        $this->id_tipo_movimiento = $data['id_tipo_movimiento'];
        $this->usuario_externo = $data['usuario_externo'];
        $this->entregado_por = $data['entregado_por'];
        $this->recibido_por = $data['recibido_por'];
        $this->autorizado_por = $data['autorizado_por'];
        $this->visto_bueno_por = $data['visto_bueno_por'];
        $this->observacion = $data['observacion'];
        $this->fecha_guarda = $data['fecha_guarda'];
        if (array_key_exists('id_actualiza', $data)) {
            $this->id_actualiza = $data['id_actualiza'];
        }
        $this->id_seccion = $data['id_seccion'];
        $this->estado_movimiento="ABIERTO";
        $this->id_guarda=$USER['id'];
        $this->fecha_guarda=$fecha_actual;
        $this->db->insert('sic_movimiento', $this);
        return $this->db->insert_id();
    }

    public function insertarSolicitud($data){
        $USER = $this->session->userdata('logged_in');
        $this->id_movimiento = $data['id_movimiento'];
        $this->id_oficina_entrega = $data['id_oficina_entrega'];
        $this->id_oficina_recibe = $data['id_oficina_recibe'];
        $this->id_empleado = $data['id_empleado'];
        $this->id_tipo_movimiento = $data['id_tipo_movimiento'];
        $this->usuario_externo = $data['usuario_externo'];
        $this->entregado_por = $data['entregado_por'];
        $this->recibido_por = $data['recibido_por'];
        $this->autorizado_por = $data['autorizado_por'];
        $this->visto_bueno_por = $data['visto_bueno_por'];
        $this->observacion = $data['observacion'];
        $this->nivel_solicitud = $data['nivel_solicitud'];
        $this->estado_solicitud = $data['estado_solicitud'];
        $this->fecha_guarda = $data['fecha_guarda'];
        $this->estado_movimiento = $data['estado_movimiento'];
        $this->id_seccion = $data['id_seccion'];
        $this->id_guarda=$USER['id_empleado'];
        $this->db->insert('sic_movimiento', $this);
        return $this->db->insert_id();
    }

    public function obtenerMovimientos(){
      $this->db->select('m.id_movimiento,m.id_oficina_entrega,m.id_oficina_recibe,o.nombre_oficina,
                        m.id_empleado,e.primer_nombre,e.primer_apellido,m.id_tipo_movimiento,
                        t.nombre_movimiento,m.estado_movimiento,m.usuario_externo,m.entregado_por,
                        m.recibido_por,m.autorizado_por,m.visto_bueno_por,m.observacion,m.id_guarda,m.fecha_guarda,
                        m.id_actualiza')
              ->from('sic_movimiento m')
              ->join('sic_tipo_movimiento t','t.id_tipo_movimiento = m.id_tipo_movimiento')
              ->join('org_oficina o','o.id_oficina = m.id_oficina_entrega')
              ->join('sir_empleado e','e.id_empleado = m.id_empleado')
              ->order_by('m.id_movimiento');
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function buscarMovimientos($busca,$seccion){
      $this->db->select('m.estado_solicitud,m.numero_solicitud,m.nivel_solicitud,m.nivel_anterior,m.id_movimiento,m.id_oficina_entrega,m.id_oficina_recibe,o.nombre_oficina,
                        m.id_empleado,e.primer_nombre,e.primer_apellido,m.id_tipo_movimiento,
                        t.nombre_movimiento,m.estado_movimiento,m.usuario_externo,m.entregado_por,
                        m.recibido_por,m.autorizado_por,m.visto_bueno_por,m.observacion,m.id_guarda,m.fecha_guarda,
                        m.id_actualiza')
              ->from('sic_movimiento m')
              ->join('sic_tipo_movimiento t','t.id_tipo_movimiento = m.id_tipo_movimiento')
              ->join('org_oficina o','o.id_oficina = m.id_oficina_entrega')
              ->join('sir_empleado e','e.id_empleado = m.id_empleado')
              ->where('m.id_seccion',$seccion)
              ->order_by('m.id_movimiento')
              ->like('id_movimiento', $busca)
              ->or_like('observacion', $busca);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function buscarMovimientosAuto($busca){
      $this->db->select('m.estado_solicitud,m.numero_solicitud,m.nivel_solicitud,m.nivel_anterior,m.id_movimiento,m.id_oficina_entrega,m.id_oficina_recibe,o.nombre_oficina,
                        m.id_empleado,e.primer_nombre,e.primer_apellido,m.id_tipo_movimiento,
                        t.nombre_movimiento,m.estado_movimiento,m.usuario_externo,m.entregado_por,
                        m.recibido_por,m.autorizado_por,m.visto_bueno_por,m.observacion,m.id_guarda,m.fecha_guarda,
                        m.id_actualiza')
              ->from('sic_movimiento m')
              ->join('sic_tipo_movimiento t','t.id_tipo_movimiento = m.id_tipo_movimiento')
              ->join('org_oficina o','o.id_oficina = m.id_oficina_entrega')
              ->join('sir_empleado e','e.id_empleado = m.id_empleado')
              ->order_by('m.id_movimiento')
              ->like('id_movimiento', $busca)
              ->or_like('observacion', $busca);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function obtenerMovimiento($id){
        $this->db->where('id_movimiento',$id);
        $query = $this->db->get('sic_movimiento');
        if ($query->num_rows() > 0) {
          $nombre;
          foreach ($query->result() as $mov) {
            $nombre = $mov->observacion;
          }
          return  $nombre;
        }
        else {
            return FALSE;
        }
    }

    public function obtenerId(){
     $this->db->select('DATABASE() as nombre');
     $query=$this->db->get();
     $base=$query->row()->nombre;
     $this->db->select('AUTO_INCREMENT as var');
     $this->db->where('TABLE_SCHEMA',$base);
     $this->db->where('TABLE_NAME','sic_movimiento');
     $query = $this->db->get('information_schema.TABLES');
     if ($query->num_rows() > 0) {
       $nombre;
       foreach ($query->result() as $fact) {
         $nombre = $fact->var;
       }
       return  $nombre;
     }
     else {
         return FALSE;
     }
   }

    public function actualizarMovimiento($id, $data){
      $this->db->where('id_movimiento',$id);
      $this->db->update('sic_movimiento', $data);
    }

    public function cerrar($id){
    $data = array('estado_movimiento' =>"CERRADO",
                  'estado_solicitud'=>"CERRADO");
    $this->db->where('id_movimiento',$id);
    $this->db->update('sic_movimiento',$data);
    }

    public function enviarSolicitud($id) {
      $data = array('estado_solicitud' => 'ENVIADA', 'nivel_solicitud' => 1);
      $this->db->where('id_movimiento', $id);
      $this->db->update('sic_movimiento', $data);
    }

    public function eliminarMovimiento($id){
      $this->db->delete('sic_movimiento', array('id_movimiento' => $id));
    }

    function totalMovimientos($seccion){
      $this->db->select('count(id_movimiento) as total from sic_movimiento
      where id_tipo_movimiento!=7 and (nivel_solicitud=1 or nivel_solicitud=2 or nivel_anterior=1)
       and id_seccion='."$seccion");
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->row();
      }
      else {
          return FALSE;
      }
    }

    function totalMovimientosAuto(){
      $this->db->select('count(id_movimiento) as total from sic_movimiento
      where id_tipo_movimiento=7 and (nivel_solicitud=1 or nivel_solicitud=2 or nivel_anterior=1)');
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->row();
      }
      else {
          return FALSE;
      }
    }

    function totalMovimientosAF(){
      $this->db->select('count(id_movimiento) as total from sic_movimiento
      where nivel_solicitud=2 or nivel_solicitud=3 or nivel_anterior=2');
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->row();
      }
      else {
          return FALSE;
      }
    }

    public function obtenerMovimientosLimit($porpagina, $segmento){
      $this->db->select('m.numero_solicitud,m.estado_solicitud,m.nivel_solicitud,m.id_movimiento,
                        m.id_oficina_entrega,m.id_oficina_recibe,o.nombre_oficina,
                        m.id_empleado,e.primer_nombre,e.primer_apellido,m.id_tipo_movimiento,
                        t.nombre_movimiento,m.estado_movimiento,m.usuario_externo,m.entregado_por,
                        m.recibido_por,m.autorizado_por,m.visto_bueno_por,m.observacion,m.id_guarda,m.fecha_guarda,
                        m.id_actualiza,e.nr,u.nombre_completo,al.nombre_almacen')
              ->from('sic_movimiento m')
              ->join('sic_tipo_movimiento t','t.id_tipo_movimiento = m.id_tipo_movimiento')
              ->join('org_oficina o','o.id_oficina = m.id_oficina_entrega')
              ->join('org_seccion_has_almacen sha','sha.id_seccion_has_almacen=o.id_seccion_has_almacen')
              ->join('org_almacen al','al.id_almacen=sha.id_almacen')
              ->join('sir_empleado e','e.id_empleado = m.id_empleado')
              ->join('org_usuario u','u.id_usuario=m.id_guarda')
              ->order_by('m.id_movimiento', "DESC")
              ->limit($porpagina,$segmento);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    function totalMovimiento(){
      return $this->db->count_all('sic_movimiento');
    }


    public function obtenerSolMovimientosLimit($porpagina, $segmento,$seccion){
      $this->db->select('m.numero_solicitud,m.estado_solicitud,m.nivel_solicitud,m.nivel_anterior,m.id_movimiento,
                        m.id_oficina_entrega,m.id_oficina_recibe,o.nombre_oficina,
                        m.id_empleado,e.primer_nombre,e.primer_apellido,m.id_tipo_movimiento,
                        t.nombre_movimiento,m.estado_movimiento,m.usuario_externo,m.observacion,
                        m.fecha_guarda,m.entregado_por,m.recibido_por,m.autorizado_por,m.visto_bueno_por')
              ->from('sic_movimiento m')
              ->join('sic_tipo_movimiento t','t.id_tipo_movimiento = m.id_tipo_movimiento')
              ->join('org_oficina o','o.id_oficina = m.id_oficina_entrega')
              ->join('sir_empleado e','e.id_empleado = m.id_empleado')
              ->where('m.id_seccion',$seccion)
              ->order_by('m.id_movimiento','desc')
              ->limit($porpagina,$segmento);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function obtenerSolMovimientosAutoLimit($porpagina, $segmento){
      $this->db->select('m.numero_solicitud,m.estado_solicitud,m.nivel_solicitud,m.nivel_anterior,m.id_movimiento,
                        m.id_oficina_entrega,m.id_oficina_recibe,o.nombre_oficina,
                        m.id_empleado,e.primer_nombre,e.primer_apellido,m.id_tipo_movimiento,
                        t.nombre_movimiento,m.estado_movimiento,m.usuario_externo,m.observacion,
                        m.fecha_guarda,m.entregado_por,m.recibido_por,m.autorizado_por,m.visto_bueno_por')
              ->from('sic_movimiento m')
              ->join('sic_tipo_movimiento t','t.id_tipo_movimiento = m.id_tipo_movimiento')
              ->join('org_oficina o','o.id_oficina = m.id_oficina_entrega')
              ->join('sir_empleado e','e.id_empleado = m.id_empleado')
              ->order_by('m.id_movimiento','desc')
              ->where('m.id_tipo_movimiento','7')
              ->limit($porpagina,$segmento);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function obtenerSolMovimientosTotalLimit($porpagina, $segmento){
      $this->db->select('m.numero_solicitud,m.estado_solicitud,m.nivel_solicitud,m.nivel_anterior,m.id_movimiento,
                        m.id_oficina_entrega,m.id_oficina_recibe,o.nombre_oficina,
                        m.id_empleado,e.primer_nombre,e.primer_apellido,m.id_tipo_movimiento,
                        t.nombre_movimiento,m.estado_movimiento,m.usuario_externo,m.observacion,
                        m.fecha_guarda,m.entregado_por,m.recibido_por,m.autorizado_por,m.visto_bueno_por')
              ->from('sic_movimiento m')
              ->join('sic_tipo_movimiento t','t.id_tipo_movimiento = m.id_tipo_movimiento')
              ->join('org_oficina o','o.id_oficina = m.id_oficina_entrega')
              ->join('sir_empleado e','e.id_empleado = m.id_empleado')
              ->order_by('m.id_movimiento','desc')
              ->limit($porpagina,$segmento);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function obtenerTodoMovimiento($id) {
      $this->db->select('*')
               ->from('sic_movimiento a')
               ->join('sic_tipo_movimiento b', 'a.id_tipo_movimiento = b.id_tipo_movimiento')
               ->where('id_movimiento',$id);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return  $query->row_array();
      }
      else {
        return FALSE;
      }
    }

    public function obtenerMovimientosLimitId($porpagina, $segmento,$id){
      $this->db->select('m.id_movimiento,m.id_oficina_entrega,m.id_oficina_recibe,o.nombre_oficina,
                        m.id_empleado,e.primer_nombre,e.segundo_nombre,e.primer_apellido,e.segundo_apellido,m.id_tipo_movimiento,
                        t.nombre_movimiento,m.estado_movimiento,m.usuario_externo,m.entregado_por,
                        m.recibido_por,m.autorizado_por,m.visto_bueno_por,m.observacion,m.id_guarda,m.fecha_guarda,
                        m.id_actualiza,e.nr,u.nombre_completo,al.nombre_almacen,sec.nombre_seccion')
              ->from('sic_movimiento m')
              ->join('sic_detalle_movimiento dm','dm.id_movimiento=m.id_movimiento')
              ->join('sic_tipo_movimiento t','t.id_tipo_movimiento = m.id_tipo_movimiento')
              ->join('org_oficina o','o.id_oficina = m.id_oficina_entrega')
              ->join('org_seccion_has_almacen sha','sha.id_seccion_has_almacen=o.id_seccion_has_almacen')
              ->join('org_seccion sec','sec.id_seccion=sha.id_seccion')
              ->join('org_almacen al','al.id_almacen=sha.id_almacen')
              ->join('sir_empleado e','e.id_empleado = m.id_empleado')
              ->join('org_usuario u','u.id_usuario=m.id_guarda')
              ->order_by('m.id_movimiento')
              ->where('dm.id_bien',$id)
              ->limit($porpagina,$segmento);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function totalMovimientosDetalle($id){
      $this->db->select('m.id_movimiento,m.id_oficina_entrega,m.id_oficina_recibe,o.nombre_oficina,
                        m.id_empleado,e.primer_nombre,e.segundo_nombre,e.primer_apellido,e.segundo_apellido,m.id_tipo_movimiento,
                        t.nombre_movimiento,m.estado_movimiento,m.usuario_externo,m.entregado_por,
                        m.recibido_por,m.autorizado_por,m.visto_bueno_por,m.observacion,m.id_guarda,m.fecha_guarda,
                        m.id_actualiza,e.nr,u.nombre_completo,al.nombre_almacen,sec.nombre_seccion')
              ->from('sic_movimiento m')
              ->join('sic_detalle_movimiento dm','dm.id_movimiento=m.id_movimiento')
              ->join('sic_tipo_movimiento t','t.id_tipo_movimiento = m.id_tipo_movimiento')
              ->join('org_oficina o','o.id_oficina = m.id_oficina_entrega')
              ->join('org_seccion_has_almacen sha','sha.id_seccion_has_almacen=o.id_seccion_has_almacen')
              ->join('org_seccion sec','sec.id_seccion=sha.id_seccion')
              ->join('org_almacen al','al.id_almacen=sha.id_almacen')
              ->join('sir_empleado e','e.id_empleado = m.id_empleado')
              ->join('org_usuario u','u.id_usuario=m.id_guarda')
              ->order_by('m.id_movimiento')
              ->where('dm.id_bien',$id);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->num_rows();
      }
      else {
          return FALSE;
      }
    }

    public function contieneDetalleMovimiento($id){
      $this->db->select('count(id_detalle_movimiento) as asociados')
               ->from('sic_detalle_movimiento')
               ->where('id_movimiento',$id);
      $query=$this->db->get();
      if ($query->num_rows()>0) {
        return $query->row();
      }else {
        return FALSE;
      }
    }

    public function obtenerMovimientosOficina($seccion, $fecha_inicio, $fecha_fin, $porpagina = 0, $segmento = 0) {
      $this->db->select("e.nombre_movimiento")
               ->from("sic_movimiento a")
               ->join("org_oficina b", "(a.id_oficina_entrega = b.id_oficina OR a.id_oficina_recibe = b.id_oficina)")
               ->join("org_seccion_has_almacen c", "c.id_seccion_has_almacen = b.id_seccion_has_almacen")
               ->join("org_seccion d", "d.id_seccion = c.id_seccion")
               ->join("sic_tipo_movimiento e", "a.id_tipo_movimiento = e.id_tipo_movimiento")
               ->where("d.id_seccion", $seccion)
               ->where('a.estado_movimiento','CERRADO')
               ->where("a.fecha_guarda BETWEEN '$fecha_inicio' AND '$fecha_fin'")
               ->group_by("a.id_movimiento");

      if (0 != $porpagina && 0 != $segmento) {
        $this->db->limit($porpagina,$segmento);
      }

      $query = $this->db->get();
      if ($query->num_rows() > 0) {

        $data = array();
        foreach ($query->result() as $mov) {
          $data[] = $mov->nombre_movimiento;
        }

        return array_count_values($data);

      } else {
          return FALSE;
      }

    }

    public function obtenerNombreOficinas($id){
      $this->db->select('o.id_oficina,o.nombre_oficina,s.nombre_seccion,a.nombre_almacen')
               ->from('org_oficina o')
               ->join('org_seccion_has_almacen sha','o.id_seccion_has_almacen=sha.id_seccion_has_almacen')
               ->join('org_seccion s','s.id_seccion=sha.id_seccion')
               ->join('org_almacen a','a.id_almacen=sha.id_almacen')
               ->where('o.id_oficina',$id);
      $query=$this->db->get();
      if ($query->num_rows()>0) {
        return $query->row();
      }else{
        return FALSE;
      }
    }

    public function obtenerNombreEmpleado($id){
      $this->db->select('e.id_empleado,u.nombre_completo')
               ->from('sir_empleado e')
               ->join('org_usuario u','e.nr=u.nr')
               ->order_by('e.id_empleado','asc')
               ->where('e.id_empleado',$id)
               ->where('e.id_estado',1);
      $query=$this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->row();
      }
      else {
          return FALSE;
      }
    }

    public function totalMovimientosOficina($seccion, $fecha_inicio, $fecha_fin) {
      $this->db->select("e.nombre_movimiento")
               ->from("sic_movimiento a")
               ->join("org_oficina b", "(a.id_oficina_entrega = b.id_oficina OR a.id_oficina_recibe = b.id_oficina)")
               ->join("org_seccion_has_almacen c", "c.id_seccion_has_almacen = b.id_seccion_has_almacen")
               ->join("org_seccion d", "d.id_seccion = c.id_seccion")
               ->join("sic_tipo_movimiento e", "a.id_tipo_movimiento = e.id_tipo_movimiento")
               ->where("d.id_seccion", $seccion)
               //->where("a.fecha_guarda BETWEEN '$fecha_inicio' AND '$fecha_fin'")
               ->group_by("a.id_movimiento");

       $query = $this->db->get();
       if ($query->num_rows() > 0) {
           return $query->num_rows();

       } else {
           return FALSE;
       }
    }
    public function obtenerCondicionBien($nombre){
      $this->db->select('id_condicion_bien')
               ->from('sic_condicion_bien')
               ->where('nombre_condicion_bien',$nombre);
      $query=$this->db->get();
      return $query->row_array();
    }
    public function obtenerBienesMov($id_movimiento){
      $this->db->select('dm.id_bien')
               ->from('sic_movimiento m')
               ->join('sic_detalle_movimiento dm','dm.id_movimiento=m.id_movimiento')
               ->where('m.id_movimiento',$id_movimiento);
       $query = $this->db->get();
       if ($query->num_rows() > 0) {
           return $query->result();
       } else {
           return FALSE;
       }

    }

    public function obternerSeccionEmpleado($id_empleado){
      $this->db->select('ei.id_empleado_informacion_laboral,ei.id_seccion,s.nombre_seccion')
               ->from('sir_empleado_informacion_laboral ei')
               ->join('sir_empleado e','ei.id_empleado=e.id_empleado')
               ->join('org_seccion s','ei.id_seccion=s.id_seccion')
               ->where('e.id_empleado',$id_empleado)
               ->order_by('ei.id_empleado_informacion_laboral','desc');
       $query = $this->db->get();
       if ($query->num_rows() > 0) {
           return $query->row();
       } else {
           return FALSE;
       }

    }

    public function retornarNivel($id){
      $this->db->select('nivel_solicitud')
                ->from('sic_movimiento')
                ->where('id_movimiento',$id);
                $query = $this->db->get();
                if ($query->num_rows() > 0) {
                    return $query->row();
                } else {
                    return FALSE;
                }
    }

    public function obtenerMovimientoPorEmpleado($id_empleado) {
        $this->db->where('id_empleado',$id_empleado);
        $query = $this->db->get('sic_movimiento');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function cerrarTodosMovimiento() {
        $this->db->where('estado_movimiento', 'ABIERTO');
        $this->db->set('estado_movimiento', 'CERRADO');
        $this->db->update('sic_movimiento');
    }
}
?>