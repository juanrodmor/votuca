<?php

class Ponderaciones_model extends CI_Model
{
  public function insertarPonderacion($idVotacion,$idGrupo,$valor)
  {
    $datos = array(
      'Id_Votacion' => $idVotacion,
      'Id_Grupo' => $idGrupo,
      'Valor' => $valor
    );

    $this->db->insert('ponderaciones',$datos);
  }
}

?>
