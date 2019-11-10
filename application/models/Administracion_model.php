<?php

class Administracion_model extends CI_Model{

// COMO COMPROBAR QUE UNA VOTACION NO EXISTE YA
  public function guardarVotacion($datos){$this->db->insert('votacion',$datos);}

  public function recuperarVotacion()
  {
    //$hoy = date('Y-m-d');
    $query = $this->db->query("SELECT * from votacion WHERE isDelected = '0';");
    return $query->result_array();

  }
  public function eliminarVotacion($id)
  {
    $query = $this->db->query("UPDATE votacion SET isDelected = '1' WHERE Id = '$id'");
    return $query;

  }
}



?>
