<?php
  class Sistema_operativo_model extends CI_Model{

    public $version_sistema_operativo;

    function __construct() {
        parent::__construct();

    }

    public function insertarSistema_operativo($data){
        $this->version_sistema_operativo = $data['version_sistema_operativo'];
        $this->db->insert('sic_sistema_operativo', $this);
        return $this->db->insert_id();
    }

    public function obtenerSistemas_operativos(){
      $this->db->order_by("id_sistema_operativo", "asc");
      $query = $this->db->get('sic_sistema_operativo');
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function buscarSistemas_operativos($busca){
      $this->db->like('version_sistema_operativo', $busca);
      $query = $this->db->get('sic_sistema_operativo', 10);
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function actualizarSistema_operativo($id, $data){
      $this->db->where('id_sistema_operativo',$id);
      $this->db->update('sic_sistema_operativo', $data);
    }

    public function eliminarSistema_operativo($id){
      $this->db->delete('sic_sistema_operativo', array('id_sistema_operativo' => $id));
    }

    function totalSistemas_operativos(){
      return $this->db->count_all('sic_sistema_operativo');
    }

    public function obtenerSistemas_operativosLimit($porpagina, $segmento){
      $this->db->order_by("id_sistema_operativo", "asc");
      $query = $this->db->get('sic_sistema_operativo', $porpagina, $segmento);
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }


    public function obtenerEquipoPorOSLimit($os, $minFecha, $maxFecha, $porpagina, $segmento) {
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
               if ($os!='todo') {
                  $this->db->where('s.id_sistema_operativo', $os);
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

    public function totalObtenerEquipoPorOSLimit($os, $minFecha, $maxFecha) {
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
               if ($os!='todo') {
                  $this->db->where('s.id_sistema_operativo', $os);
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
