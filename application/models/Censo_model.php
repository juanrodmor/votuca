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

  public function insertarVotacion($idVotacion,$idCenso)
  {
    //echo var_dump($idVotacion);
    $datos = array(
      'Id_Votacion' => $idVotacion,
      'Id_Censo' => $idCenso
    );
    $this->db->insert('votacion_censo',$datos);
  }


  public function getCensos()
  {
    $query = $this->db->query("SELECT * from ficheros_censo");
    return $query->result();
  }

  public function getId($nombreCenso)
  {
    $query = $this->db->query("SELECT Id from ficheros_censo WHERE Nombre = '$nombreCenso'");
    return $query->result();
  }


}


?>
