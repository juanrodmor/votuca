<?php

include 'classes/Censos.php';

class Censo_model extends CI_Model{

  public function insertar($usuarios,$idVotacion)
  {
    for($i = 0; $i < sizeof($usuarios); $i++)
    {
      $censo = new Censos($usuarios[$i],$idVotacion);
      $this->db->insert('censo',$censo);
    }

  }

  public function getElectores($idVotacion)
  {
    $query = $this->db->query("SELECT Id_Usuario from censo WHERE Id_Votacion = '$idVotacion';");
    return $query->result();
  }

}


?>
