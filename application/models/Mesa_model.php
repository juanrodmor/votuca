<?php
class Mesa_model extends CI_Model {


  public function insertar($idUsuario,$idVotacion)
  {
    $sinProblemas = true;
    $datos = array(
        'Id_Usuario' => $idUsuario,
        'Id_Votacion' => $idVotacion
      );
      $noGuardado = $this->db->insert('mesa_electoral',$datos);
      if($noGuardado){$sinProblemas = false;}

    if($sinProblemas){return true;}
    else{return false;}
  }

	//Devuelve el listado de votaciones de las que se encarga un miembro de la mesa electoral.
	public function getVotaciones($id) {
		$consulta = $this->db->get_where('mesa_electoral', array('Id_Usuario' => $id));
		return $consulta->result();
	}

	//Establece a true la decisión de abrir la urna de un usuario concreto para una votación concreta.
	public function abreUrna($usuario, $votacion) {
		$this->db->where('Id_Usuario', $usuario);
		$this->db->where('Id_Votacion', $votacion);
		$this->db->update('mesa_electoral', array('seAbre' => 1));
	}

	//Devuelve el número de decisiones de apertura para una votación concreta.
	public function getNApertura($votacion) {
		$consulta = $this->db->get_where('mesa_electoral', array('Id_Votacion' => $votacion, 'seAbre' => 1));
		return $consulta->num_rows();
	}

  public function eliminarMiembroFromVotacion($idMiembro,$idVotacion)
  {
    //echo 'Vamos a eliminar al miembro: '.$idMiembro. ' de la votacion: '.$idVotacion.'<br>';
    $query = $this->db->query("DELETE FROM mesa_electoral WHERE Id_Votacion = '$idVotacion' AND Id_Usuario = '$idMiembro'");
  }
}


?>
