<?php
  class Seccion_model extends CI_Model{

    function __construct() {
        parent::__construct();
    }

    public function obtenerPorIdSeccion($id){
      $this->db->where('id_seccion', $id);
      $query = $this->db->get('org_seccion')->row();
      $seccion = '';
      if (!is_null($query)) {
          $seccion = $query->nombre_seccion;
      }
      return $seccion;
    }

    public function nombreEmpleado($id_empleado) {
      $this->db->select('primer_nombre, segundo_nombre, primer_apellido, segundo_apellido')
               ->from('sir_empleado')
               ->where('id_empleado', $id_empleado);

       $query = $this->db->get();
       if ($query->num_rows()>0) {
         $empleado = $query->row();
         return $empleado->primer_nombre . " " . $empleado->segundo_nombre . " " . $empleado->primer_apellido . " " . $empleado->segundo_apellido;
       }
    }
  }
?>
