<?php

class SecretariosDelegados_model extends CI_Model{

  public function restriccionDelegacion($idVotacion)
  {
    $query = $this->db->query("SELECT Id_Usuario from secretario_delegado WHERE Id_votacion = '$idVotacion';");
    $numeroSecretarios = $query->num_rows();
    return $numeroSecretarios;
  }

  public function guardarSecretarioDelegado($idSecretario,$idVotacion)
  {
    $totales = $this->restriccionDelegacion($idVotacion);
    if($totales >= 1){return false;}
    else
    {
      $datos = array(
        'Id_Usuario' => $idSecretario,
        'Id_Votacion' => $idVotacion
      );
      $realizada = $this->db->insert('secretario_delegado',$datos);
      return $realizada;
    }

  }

  public function getVotacionesSecretario($idSecretario)
  {
    $query = $this->db->query("SELECT Id_Votacion from secretarios_delegados WHERE Id_Secretario = '$idSecretario';");
    return $query->result();
  }
  
  //Añade una nueva votación al secretario
  public function setVotacion($idSecretario, $idVotacion)
  {
	  $data = array(
		'Id_Secretario' => $idSecretario,
		'Id_Votacion' => $idVotacion
	  );
	  
	  $this->db->insert('secretarios_delegados', $data);
  }

}



?>
