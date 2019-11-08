<?php

class Administracion_model extends CI_Model{

// COMO COMPROBAR QUE UNA VOTACION NO EXISTE YA
  public function guardarVotacion($datos){$this->db->insert('votaciones',$datos);}

  public function recuperarVotacion()
  {
    $hoy = date('Y-m-d');
    $query = $this->db->query("SELECT * from votaciones WHERE fechaFinal >= $hoy ;");
    return $query->result_array();

  }
}



?>
