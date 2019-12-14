<?php

class Votaciones_model extends CI_Model{

// COMO COMPROBAR QUE UNA VOTACION NO EXISTE YA
  public function guardarVotacion($datos)
  {
    //echo var_dump($datos);
    $this->db->insert('votacion',$datos);
  }//$this->db->insert('votacion',$datos);

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
    if($votacion->getBorrador() == true && $encontrado)
    {
        $id = $votacion->getId();
        $query = $this->db->query("UPDATE votacion SET esBorrador = '1' WHERE Id = '$id'");
        $realizado = true;
    }
    if($encontrado && $votacion->getBorrador() == false)
    {
      $id = $votacion->getId();
      $query = $this->db->query("UPDATE votacion SET esBorrador = '0' WHERE Id = '$id'");
      $realizado = true;
    }
  return $realizado;
	}

  public function recuperarVotaciones()
  {
    $query = $this->db->query("SELECT * from votacion WHERE isDeleted = '0';");
    return $query->result();

  }
  public function recuperarVotacionesAcabadas()
  {
    $hoy = date('Y-m-d');
    $query = $this->db->query("SELECT * from votacion WHERE FechaFinal <= '$hoy'");
    return $query->result();
  }
  public function eliminarVotacion($id)
  {
    $query = $this->db->query("UPDATE votacion SET isDeleted = '1' WHERE Id = '$id'");
    return $query;

  }

  public function hasSoloAsistentes($idVotacion)
  {
    $query = $this->db->query("SELECT soloAsistentes from votacion WHERE id = '$idVotacion'");
    return $query->result();
  }

  public function contarUsuarios($nombreTabla, $idVotacion)
  {
    $query = $this->db->query("SELECT COUNT(Id_Usuario) as total FROM $nombreTabla WHERE Id_Votacion = '$idVotacion'");
    return $query->result();
  }

  public function getLastId()
  {
    $query = $this->db->query("SELECT Id FROM votacion ORDER BY Id DESC LIMIT 1");
    if($query->num_rows() > 0) {return $query->first_row()->Id;}
    else{return 1;}
  }

  public function getBorradores()
  {
    $query = $this->db->query("SELECT * from votacion WHERE esBorrador = '1';");
    return $query->result();
  }




}



?>
