<?php

class Administracion_model extends CI_Model{

// COMO COMPROBAR QUE UNA VOTACION NO EXISTE YA
  public function guardarVotacion($datos){$this->db->insert('votacion',$datos);}

  public function totalVotaciones() {
  $consulta = $this->db->get('votacion');
   return  $consulta->num_rows() ;
  }

  /*public function obtenerVotacionesLimite($por_pagina, $segmento) {
    $consulta = $this->db->get('votacion',$por_pagina,$segmento);

           if($consulta->num_rows()>0){
               foreach($consulta->result() as $fila){
                 $data[] = $fila;
                }
                return $data;
           }
  }*/

  public function getVotacion($id)
	{
		$this->db->from('votacion');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}


	public function updateVotacion($votacion){
		$encontrado = $this->db->where('id', $votacion->getId());
    echo var_dump($votacion);
    if($encontrado){$this->db->update('votacion', $votacion);}
		else{return false;}
	}

  public function recuperarVotaciones()
  {
    //$hoy = date('Y-m-d');
    $query = $this->db->query("SELECT * from votacion WHERE isDelected = '0';");
    return $query->result();

  }
  public function eliminarVotacion($id)
  {
    $query = $this->db->query("UPDATE votacion SET isDelected = '1' WHERE Id = '$id'");
    return $query;

  }
}



?>
