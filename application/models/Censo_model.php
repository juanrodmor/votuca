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

  public function getCensosFromUsuarios($usuario)
  {
    $this->db->get('usuario_censo');
    $this->db->from('usuario_censo');
    $this->db->where('Id_Usuario',$usuario);
    $query = $this->db->get();
    return $query->result();

  }

  public function getUsuariosfromVotacion($idVotacion)
  {
    $query = $this->db->query("SELECT Id_Usuario from censo WHERE Id_Votacion = '$idVotacion'");
    return $query->result();
  }

  public function getCensosfromVotacion($idVotacion)
  {
      $query = $this->db->query("SELECT Id_Censo from votacion_censo WHERE Id_Votacion = '$idVotacion'");
      return $query->result();
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

  public function eliminarUsuarios($idUsuario,$idVotacion)
  {
    $query = $this->db->query("DELETE FROM censo WHERE Id_Votacion = '$idVotacion' AND Id_Usuario = '$idUsuario'");
    //return $query->result();
  }

  public function eliminarCenso($idVotacion,$idFichero)
  {
    $idFichero = $idFichero[0]->Id;
   $query = $this->db->query("DELETE FROM votacion_censo WHERE Id_Votacion = '$idVotacion' AND Id_Censo = '$idFichero'");
  }

  public function setUsuarioCenso($idUsuario,$idCenso)
  {
    $datos = array(
      'Id_Usuario' => $idUsuario,
      'Id_Censo' => $idCenso[0]->Id
    );
    $this->db->insert('usuario_censo',$datos);
  }

  public function getUsuariosFromCenso($idCenso)
  {
    $this->db->select('Id_Usuario');
    $this->db->where('Id_Censo',$idCenso[0]->Id);
    $this->db->from('usuario_censo');
    $query = $this->db->get();
    return $query->result();
  }


}


?>
