<?php
class Mesa_model extends CI_Model {


  public function insertar($usuarios,$idVotacion)
  {
    $sinProblemas = true;
    echo var_dump($usuarios);
    for($i = 0; $i < sizeof($usuarios);$i++)
    {
      $datos = array(
        'Id_Usuario' => $usuarios[$i],
        'Id_Votacion' => $idVotacion
      );
      $noGuardado = $this->db->insert('mesa_electoral',$datos);
      if($noGuardado){$sinProblemas = false;}
    }
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
	
	//Comprueba si existe algún recuento para la votación.
	public function checkVotos($idVotacion) {
		$consulta = $this->db->get_where('votacion_voto', array('Id_Votacion' => $idVotacion));
		$rows = $consulta->result();
		$consulta2 = $this->db->get_where('recuento', array('Id_Voto' => $rows[0]->Id_Voto));
		return ($consulta2->num_rows()>=1);
	}
	
	//Devuelve las opciones de voto de una votacion.
	public function getOptions($idVotacion) {
		$consulta = $this->db->get_where('votacion_voto', array('Id_Votacion' => $idVotacion));
		$result = array('Id' => array(), 'Nombre' => array());
		foreach($consulta->result() as $row) {
			array_push($result['Id'], $row()->Id_Voto);
		}
		foreach($result['Id'] as $id) {
			$consulta = $this->db->get_where('voto', array('Id' => $id));
			array_push($result['Nombre'], $consulta->result()[0]->Nombre);
		}
		return $result;
	}
	
	//Devuelve un recuento de un voto en concreto en una votación concreta, eliminando dichos votos del registro.
	public function volcadoVotos($idVotacion, $idVoto) {
		$usuario_votacion = $this->db->get('usuario_votacion');
		$cont = 0;
		foreach ($usuario_votacion->result() as $row) {
			if (password_verify($idVotacion, $row->Id_Votacion) == true && password_verify($idVoto, $row->Id_Voto) == true) {
				$cont++;
				$this->db->delete('usuario_votacion', array('Id_Votacion' => $row->Id_Votacion, 'Id_Voto' => $row->Id_Voto));
			}
		}
		return $cont;
	}
	
	//Inserta los resultados de una votación en la tabla recuento.
	public function insertVotos($idVotacion, $arrayIdVoto, $arrayNumVotos) {
		for($it=0; $it<count($arrayIdVoto); $it++) {
			$this->db->insert('recuento', array('Id_Votacion' => $idVotacion, 'Id_Voto' => $arrayIdVoto[$it], 'Num_Votos' => $arrayNumVotos[$id]));
		}
	}
	
	//Devuelve la cantidad de un voto concreto para una votacion.
	public function getNVotos($idVotacion, $idVoto) {
		$consulta = $this->db->get_where('recuento', array('Id_Votacion' => $idVotacion, 'Id_Voto' => $idVoto));
		return $consulta->result()[0]->Num_Votos;
	}
	
	//Devuelve el quorum (%) requerido en una votacion.
	public function getQuorum($idVotacion) {
		$consulta = $this->db->get_where('votacion', array('Id' => $idVotacion));
		$consulta2 = $this->db->get_where('tipoVotacion' array('Id' => $consulta->result()[0]->Id_TipoVotacion));
		return $consulta2->result()[0]->Quorum;
	}
	
	//Devuelve el tamaño del censo de la votacion indicada.
	public function getCenso($idVotacion) {
		$consulta = $this->db->get_where('censo', array('Id_Votacion' => $idVotacion));
		return $consulta->num_rows();
	}
	
	//Devuelve toda la información necesaria para que se muestre el recuento.
	public function getFullVotoData($idVotacion) {
		$votos = $this->getOptions($idVotacion);
		$contVotos = array();
		foreach($votos['Id'] as $idVoto) {
			array_push($contVotos, $this->getNVotos($idVotacion, $idVoto));
		}
		$result = array('opciones' => $votos['Nombre'],
						'cantidad' => $contVotos,
						'quorum' => $this->getQuorum($idVotacion),
						'censo' => $this->getCenso($idVotacion),
						'votacion' => $idVotacion);
		return $result;
	}
}


?>
