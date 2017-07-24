<?php
  class Equipo_informatico_model extends CI_Model{

    public $id_procesador;
    public $id_disco_duro;
    public $id_memoria;
    public $id_sistema_operativo;
    public $id_office;
    public $velocidad_procesador;
    public $velocidad_disco_duro;
    public $velocidad_memoria;
    public $clave_sistema_operativo;
    public $clave_office;
    public $direccion_ip;
    public $numero_de_punto;
    public $id_bien;
    public $tipo_computadora;
    public $id_equipo_informatico;


    function __construct() {
        parent::__construct();
    }

    public function insertarEquipoInformatico($data){
        $this->id_procesador = $data['id_procesador'];
        $this->id_disco_duro = $data['id_disco_duro'];
        $this->id_memoria = $data['id_memoria'];
        $this->id_sistema_operativo = $data['id_sistema_operativo'];
        $this->id_office = $data['id_office'];
        $this->velocidad_procesador = $data['velocidad_procesador'];
        $this->velocidad_disco_duro = $data['velocidad_disco_duro'];
        $this->velocidad_memoria = $data['velocidad_memoria'];
        $this->clave_sistema_operativo = $data['clave_sistema_operativo'];
        $this->clave_office = $data['clave_office'];
        $this->direccion_ip = $data['direccion_ip'];
        $this->numero_de_punto = $data['numero_de_punto'];
        $this->id_equipo_informatico = $data['id_equipo_informatico'];
        $this->id_bien = $data['id_bien'];
        $this->tipo_computadora = $data['tipo_computadora'];
        $this->db->insert('sic_equipo_informatico', $this);
        return $this->db->insert_id();
    }

    public function obtenerEquipoInformatico($id_bien){
      $this->db->select('d.modelo,ma.nombre_marca,d.descripcion,e.id_procesador,e.id_disco_duro,e.id_memoria,e.id_sistema_operativo,
      e.id_office,e.velocidad_procesador,e.velocidad_disco_duro,e.velocidad_memoria,e.clave_office,e.clave_sistema_operativo,e.numero_de_punto,
      p.nombre_procesador,h.capacidad,m.tipo_memoria,s.version_sistema_operativo,o.version_office,b.id_bien,e.id_equipo_informatico,
      e.direccion_ip,e.tipo_computadora,d.color,d.fecha_adquisicion')
               ->from('sic_bien b')
               ->join('sic_datos_comunes d','d.id_dato_comun=b.id_dato_comun')
               ->join('sic_marcas ma','ma.id_marca=d.id_marca')
               ->join('sic_equipo_informatico e','b.id_bien=e.id_bien')
               ->join('sic_procesador p','p.id_procesador=e.id_procesador')
               ->join('sic_disco_duro h','h.id_disco_duro=e.id_disco_duro')
               ->join('sic_memoria m','m.id_memoria=e.id_memoria')
               ->join('sic_sistema_operativo s','s.id_sistema_operativo=e.id_sistema_operativo')
               ->join('sic_office o','o.id_office=e.id_office')
               ->where('b.id_bien',$id_bien);
      $query=$this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function buscarEquipoInformatico($id_bien,$busca){
      $this->db->select('d.modelo,ma.nombre_marca,d.descripcion,e.id_procesador,e.id_disco_duro,e.id_memoria,e.id_sistema_operativo,
      e.id_office,e.velocidad_procesador,e.velocidad_disco_duro,e.velocidad_memoria,e.clave_office,e.clave_sistema_operativo,e.numero_de_punto,
      p.nombre_procesador,d.capacidad,m.tipo_memoria,s.version_sistema_operativo,o.version_office,b.codigo,b.id_bien')
               ->from('sic_bien b')
               ->join('sic_datos_comunes d','d.id_dato_comun=b.id_dato_comun')
               ->join('sic_marcas ma','ma.id_marca=d.id_marca')
               ->join('sic_equipo_informatico e','b.id_bien=e.id_bien')
               ->join('sic_procesador p','p.id_procesador=e.id_procesador')
               ->join('sic_disco_duro d','d.id_disco_duro=e.id_disco_duro')
               ->join('sic_id_memoria m','m.id_memoria=e.id_memoria')
               ->join('sic_sistema_operativo s','s.id_sistema_operativo=e.id_sistema_operativo')
               ->join('sic_office o','o.id_office=e.id_office')
               ->where('b.id_bien',$id_bien)
               ->like('b.codigo',$busca);
      $query=$this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result();
      }
      else {
          return FALSE;
      }
    }

    public function totalEquipoInformatico($id_bien){
      $this->db->select('count(*) as total')
               ->from('sic_bien b')
               ->join('sic_datos_comunes d','d.id_dato_comun=b.id_dato_comun')
               ->join('sic_marcas ma','ma.id_marca=d.id_marca')
               ->join('sic_equipo_informatico e','b.id_bien=e.id_bien')
               ->join('sic_procesador p','p.id_procesador=e.id_procesador')
               ->join('sic_disco_duro d','d.id_disco_duro=e.id_disco_duro')
               ->join('sic_id_memoria m','m.id_memoria=e.id_memoria')
               ->join('sic_sistema_operativo s','s.id_sistema_operativo=e.id_sistema_operativo')
               ->join('sic_office o','o.id_office=e.id_office')
               ->where('b.id_bien',$id_bien);
      $query=$this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->row();
      }
      else {
          return FALSE;
      }
    }


    public function actualizarEquipoInformatico($id, $data){
      $this->db->where('id_equipo_informatico',$id);
      $this->db->update('sic_equipo_informatico', $data);
    }

    public function eliminarEquipoInformatico($id){
      $this->db->delete('sic_equipo_informatico', array('id_equipo_informatico' => $id));
    }

    public function obtenerCategoria($id_subcategoria){
      $this->db->select('*')
               ->from('sic_subcategoria s')
               ->join('sic_categoria c','s.id_categoria=c.id_categoria')
               ->where('s.id_subcategoria',$id_subcategoria);
      $query=$this->db->get();
      return $query->row();
    }

    public function obtenerDatos($id_dato_comun){
      $this->db->select('*')
               ->from('sic_subcategoria s')
               ->join('sic_categoria c','s.id_categoria=c.id_categoria')
               ->join('sic_datos_comunes dc','dc.id_subcategoria=s.id_subcategoria')
               ->where('dc.id_dato_comun',$id_dato_comun);
      $query=$this->db->get();
      return $query->row();
    }

    public function totalEquipoPorTipoComputadoraLimit($tipo, $minFecha, $maxFecha){
      $this->db->select('d.modelo,ma.nombre_marca,d.descripcion,e.id_procesador,e.id_disco_duro,e.id_memoria,e.id_sistema_operativo,
      e.id_office,e.velocidad_procesador,e.velocidad_disco_duro,e.velocidad_memoria,e.clave_office,e.clave_sistema_operativo,e.numero_de_punto,
      p.nombre_procesador,h.capacidad,m.tipo_memoria,s.version_sistema_operativo,o.version_office,b.id_bien,e.id_equipo_informatico,
      e.direccion_ip,e.tipo_computadora,d.color,d.fecha_adquisicion')
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
               switch ($tipo) {
                 case 'DESKTOP':
                   $this->db->where('su.nombre_subcategoria','CPU');
                   break;
                 case 'LAPTOP':
                   $this->db->where('su.nombre_subcategoria',$tipo);
                   break;
                 case 'SERVIDOR':
                   $this->db->where('su.nombre_subcategoria',$tipo);
                   break;
                 case 'default':
                   $names = array('SERVIDOR','CPU','LAPTOP');
                   $this->db->where_in('su.nombre_subcategoria',$names);
                  break;
             }
      $query=$this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->num_rows();
      }
      else {
          return FALSE;
      }
    }

    public function obtenerEquipoPorTipoComputadoraLimit($tipo, $minFecha, $maxFecha, $porpagina, $segmento){
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
                 switch ($tipo) {
                   case 'DESKTOP':
                     $this->db->where('su.nombre_subcategoria','CPU');
                     break;
                   case 'LAPTOP':
                     $this->db->where('su.nombre_subcategoria',$tipo);
                     break;
                   case 'SERVIDOR':
                     $this->db->where('su.nombre_subcategoria',$tipo);
                     break;
                   case 'default':
                     $names = array('SERVIDOR','CPU','LAPTOP');
                     $this->db->where_in('su.nombre_subcategoria',$names);
                     break;
               }
      $query=$this->db->get();
      if ($query->num_rows() > 0) {
          return  $query->result_array();
      }
      else {
          return FALSE;
      }
    }


  public function obtenerDetalleBienes($id_bien){
    $this->db->select('b.id_bien,b.codigo,d.descripcion,ma.nombre_marca,d.modelo,d.color,b.serie, b.codigo,b.codigo_anterior,
    d.fecha_adquisicion,CONCAT(em.primer_nombre," ", em.segundo_nombre," ",em.primer_apellido," ",em.segundo_apellido) as nombre_empleado')
             ->from("(select max(id_detalle_movimiento) as id_detalle_movimiento,max(id_movimiento) as id_movimiento,
              id_bien from sic_detalle_movimiento group by id_bien order by id_detalle_movimiento) as dm")
             ->join('sic_movimiento m','dm.id_movimiento=m.id_movimiento')
             ->join('sir_empleado em','em.id_empleado=m.id_empleado')
             ->join('sic_bien b','b.id_bien=dm.id_bien')
             ->join('sic_datos_comunes d','d.id_dato_comun=b.id_dato_comun')
             ->join('sic_marcas ma','ma.id_marca=d.id_marca')
             ->where('m.estado_movimiento','CERRADO')
             ->where('m.id_tipo_movimiento != 12')
             ->where('b.id_bien',$id_bien);
   $query=$this->db->get();
   if ($query->num_rows()>0) {
     return $query->result();
   }
  }
}
?>
