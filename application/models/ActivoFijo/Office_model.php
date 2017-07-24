<?php
  class Office_model extends CI_Model{

    public $version_office;

    function __construct() {
        parent::__construct();

    }

    public function insertarOffice($data){
        $this->version_office = $data['version_office'];
        $this->db->insert('sic_office', $this);
        return $this->db->insert_id();
    }

    public function obtenerOffices(){
      $this->db->order_by("id_office", "asc");
      $query = $this->db->get('sic_office');
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function buscarOffices($busca){
      $this->db->like('version_office', $busca);
      $query = $this->db->get('sic_office', 10);
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function actualizarOffice($id, $data){
      $this->db->where('id_office',$id);
      $this->db->update('sic_office', $data);
    }

    public function eliminarOffice($id){
      $this->db->delete('sic_office', array('id_office' => $id));
    }

    function totalOffices(){
      return $this->db->count_all('sic_office');
    }

    public function obtenerOfficesLimit($porpagina, $segmento){
      $this->db->order_by("id_office", "asc");
      $query = $this->db->get('sic_office', $porpagina, $segmento);
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function obtenerEquipoOfficeLimit($office, $minFecha, $maxFecha, $porpagina, $segmento) {
      $this->db->select('d.modelo,ma.nombre_marca,d.descripcion,e.id_procesador,e.id_disco_duro,e.id_memoria,e.id_sistema_operativo,
      e.id_office,COALESCE(e.velocidad_procesador,"S/E") velocidad_procesador,COALESCE(e.velocidad_disco_duro,"S/E") velocidad_disco_duro,
      COALESCE(e.velocidad_memoria,"S/E") velocidad_memoria,e.clave_office,e.clave_sistema_operativo,COALESCE(e.numero_de_punto,"S/E") numero_de_punto,
      p.nombre_procesador,h.capacidad,m.tipo_memoria,COALESCE(s.version_sistema_operativo,"S/E") version_sistema_operativo,
      COALESCE(o.version_office,"S/E") version_office,b.id_bien,COALESCE(e.id_equipo_informatico,"S/E") id_equipo_informatico,
      COALESCE(e.direccion_ip,"S/E") direccion_ip,COALESCE(e.tipo_computadora,"S/E") tipo_computadora,d.color,d.fecha_adquisicion')
               ->from('sic_bien b')
               ->join('sic_datos_comunes d','d.id_dato_comun=b.id_dato_comun')
               ->join('sic_subcategoria su','su.id_subcategoria=d.id_subcategoria')
               ->join('sic_categoria ca','su.id_categoria=ca.id_categoria')
               ->join('sic_marcas ma','d.id_marca=ma.id_marca')
               ->join('sic_equipo_informatico e','e.id_bien=b.id_bien','left')
               ->join('sic_procesador p','e.id_procesador=p.id_procesador','left')
               ->join('sic_disco_duro h','e.id_disco_duro=h.id_disco_duro','left')
               ->join('sic_memoria m','e.id_memoria=m.id_memoria','left')
               ->join('sic_sistema_operativo s','e.id_sistema_operativo=s.id_sistema_operativo','left')
               ->join('sic_office o','e.id_office=o.id_office','left')
               ->where("d.fecha_adquisicion BETWEEN '$minFecha' AND '$maxFecha'")
               ->limit($porpagina, $segmento);
               if ($office!='todo') {
                  $this->db->where('o.id_office', $office);
               }
               $names = array('SERVIDOR','CPU','LAPTOP');
               $this->db->where_in('su.nombre_subcategoria',$names);
      $query=$this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result_array();
      }
      else {
          return FALSE;
      }
    }

    public function totalEquipoOffice($office, $minFecha, $maxFecha) {
      $this->db->select('d.modelo,ma.nombre_marca,d.descripcion,e.id_procesador,e.id_disco_duro,e.id_memoria,e.id_sistema_operativo,
      e.id_office,COALESCE(e.velocidad_procesador,"S/E") velocidad_procesador,COALESCE(e.velocidad_disco_duro,"S/E") velocidad_disco_duro,
      COALESCE(e.velocidad_memoria,"S/E") velocidad_memoria,e.clave_office,e.clave_sistema_operativo,COALESCE(e.numero_de_punto,"S/E") numero_de_punto,
      p.nombre_procesador,h.capacidad,m.tipo_memoria,COALESCE(s.version_sistema_operativo,"S/E") version_sistema_operativo,
      COALESCE(o.version_office,"S/E") version_office,b.id_bien,COALESCE(e.id_equipo_informatico,"S/E") id_equipo_informatico,
      COALESCE(e.direccion_ip,"S/E") direccion_ip,COALESCE(e.tipo_computadora,"S/E") tipo_computadora,d.color,d.fecha_adquisicion')
               ->from('sic_bien b')
               ->join('sic_datos_comunes d','d.id_dato_comun=b.id_dato_comun')
               ->join('sic_subcategoria su','su.id_subcategoria=d.id_subcategoria')
               ->join('sic_categoria ca','su.id_categoria=ca.id_categoria')
               ->join('sic_marcas ma','d.id_marca=ma.id_marca')
               ->join('sic_equipo_informatico e','e.id_bien=b.id_bien','left')
               ->join('sic_procesador p','e.id_procesador=p.id_procesador','left')
               ->join('sic_disco_duro h','e.id_disco_duro=h.id_disco_duro','left')
               ->join('sic_memoria m','e.id_memoria=m.id_memoria','left')
               ->join('sic_sistema_operativo s','e.id_sistema_operativo=s.id_sistema_operativo','left')
               ->join('sic_office o','e.id_office=o.id_office','left')
               ->where("d.fecha_adquisicion BETWEEN '$minFecha' AND '$maxFecha'");
               if ($office!='todo') {
                  $this->db->where('o.id_office', $office);
               }
               $names = array('SERVIDOR','CPU','LAPTOP');
               $this->db->where_in('su.nombre_subcategoria',$names);
      $query=$this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->num_rows();
      }
      else {
          return FALSE;
      }
    }

  }
?>
