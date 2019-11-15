<?php

class SecretariosDelegados_model extends CI_Model{
  public function restriccionDelegacion($idVotacion)
  {
    $query = $this->db->query("SELECT Id_Secretario from secretariosDelegados WHERE Id_votacion = '$idVotacion';");
    $numeroSecretarios = $query->num_rows();
    return $numeroSecretarios;
  }
  
  public function guardarSecretarioDelegado($idSecretario,$idVotacion)
  {
    $totales = $this->restriccionDelegacion($idVotacion);
    if($totales >= 2){return false;}
    else
    {
      $datos = array(
        'Id_Secretario' => $idSecretario,
        'Id_Votacion' => $idVotacion
      );
      $realizada = $this->db->insert('secretariosDelegados',$datos);
      return $realizada;
    }

  }

}



?>
