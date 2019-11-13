<?php

class Administracion_model extends CI_Model{

// COMO COMPROBAR QUE UNA VOTACION NO EXISTE YA
  public function guardarVotacion($datos){$this->db->insert('votacion',$datos);}

  public function totalVotaciones()
  {
    $consulta = $this->db->get('votacion');
    return  $consulta->num_rows() ;
  }

  public function getVotacion($id)
	{
		$this->db->from('votacion');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function updateVotacion($votacion)
  {
		$encontrado = $this->db->where('id', $votacion->getId());
    $realizado = false;
    if($encontrado){$realizado = $this->db->update('votacion', $votacion);}
		return $realizado;
	}

  public function recuperarVotaciones()
  {
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
