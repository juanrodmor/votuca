<?php
class Mesa_model extends CI_Model {


  public function insertar($idUsuario,$idVotacion)
  {
    $sinProblemas = true;
    $datos = array(
        'Id_Usuario' => $idUsuario,
        'Id_Votacion' => $idVotacion
      );
      $this->db->insert('mesa_electoral',$datos);
  }

	//Devuelve el listado de votaciones de las que se encarga un miembro de la mesa electoral.
	public function getVotaciones($id) {
		$consulta = $this->db->get_where('mesa_electoral', array('Id_Usuario' => $id));
		$votaciones = $this->noFinalizadas($consulta->result());
		return $votaciones;
	}

	//Devuelve un subarray de votaciones con aquellas que no están finalizadas.
	private function noFinalizadas($votaciones) {
		$votacionesOK = array();
		foreach($votaciones as $votacion) {
			$consulta = $this->db->get_where('votacion', array('Id' => $votacion->Id_Votacion, 'Finalizada' => 0));
			if ($consulta->num_rows() != 0) array_push($votacionesOK, $consulta->result()[0]);
		}
		return $votacionesOK;
	}

	//Establece a true la decisión de abrir la urna de un usuario concreto para una votación concreta.
	public function abreUrna($usuario, $votacion) {
		$this->db->where('Id_Usuario', $usuario);
		$this->db->where('Id_Votacion', $votacion);
		$this->db->update('mesa_electoral', array('seAbre' => 1));
	}

	//Comprueba si una urna se puede cerrar.
	public function cierraUrna($usuario, $idVotacion) {
		$this->db->where('Id_Usuario', $usuario);
		$this->db->where('Id_Votacion', $idVotacion);
		$this->db->update('mesa_electoral', array('seCierra' => 1));
	}

	//Devuelve el número de decisiones de apertura para una votación concreta.
	public function getNApertura($votacion) {
		$consulta = $this->db->get_where('mesa_electoral', array('Id_Votacion' => $votacion, 'seAbre' => 1));
		return $consulta->num_rows();
	}

  //Devuelve un array con los nombres de usuario que quieren abrir una urna.
	public function getNamesApertura($idVotacion) {
		$consulta = $this->db->get_where('mesa_electoral', array('Id_Votacion' => $idVotacion, 'seAbre' => 1));
		$arrayNames = array();
		foreach($consulta->result() as $result) {
			$consulta2 = $this->db->get_where('usuario', array('Id' => $result->Id_Usuario));
			array_push($arrayNames, $consulta2->result()[0]->NombreUsuario);
		}
		return $arrayNames;
	}

	//Devuelve un array con los nombres de usuario que quieren cerrar una urna.
	public function getNamesCierre($idVotacion) {
		$consulta = $this->db->get_where('mesa_electoral', array('Id_Votacion' => $idVotacion, 'seCierra' => 1));
		$arrayNames = array();
		foreach($consulta->result() as $result) {
			$consulta2 = $this->db->get_where('usuario', array('Id' => $result->Id_Usuario));
			array_push($arrayNames, $consulta2->result()[0]->NombreUsuario);
		}
		return $arrayNames;
	}

	//Comprueba si un miembro electoral quiere abrir una votación concreta.
	public function getQuiereAbrir($username, $votacion) {
		$consulta = $this->db->get_where('mesa_electoral', array('Id_Votacion' => $votacion, 'Id_Usuario' => $username, 'seAbre' => 1));
		return ($consulta->num_rows() == 1);
	}

	//Comprueba si un miembro electoral quiere cerrar una votación concreta.
	public function getQuiereCerrar($username, $votacion) {
		$consulta = $this->db->get_where('mesa_electoral', array('Id_Votacion' => $votacion, 'Id_Usuario' => $username, 'seCierra' => 1));
		return ($consulta->num_rows() == 1);
	}

	//Devuelve el número de decisiones de cierre para una votación concreta.
	public function getNCierre($votacion) {
		$consulta = $this->db->get_where('mesa_electoral', array('Id_Votacion' => $votacion, 'seCierra' => 1));
		return $consulta->num_rows();
	}

	//Comprueba si existe algún recuento para la votación.
	public function checkVotos($idVotacion) {
		/*$consulta = $this->db->get_where('votacion_voto', array('Id_Votacion' => $idVotacion));
		$rows = $consulta->result();
		if(!empty($rows))
		{
			$consulta2 = $this->db->get_where('recuento', array('Id_Votacion' => $rows[0]->Id_Voto));
			return ($consulta2->num_rows()>=1);
		}*/
		$consulta = $this->db->get_where('recuento', array('Id_Votacion' => $idVotacion));
		return ($consulta->num_rows()>=1);
	}

	//Devuelve las opciones de voto de una votacion.
	public function getOptions($idVotacion) {
		$consulta = $this->db->get_where('votacion_voto', array('Id_Votacion' => $idVotacion));
		$result = array('Id' => array(), 'Nombre' => array());
		foreach($consulta->result() as $row) {
			if ($row->Id_Voto != 1) array_push($result['Id'], $row->Id_Voto);	//Se consideran todas las opciones a excepción de No votado.
		}
		foreach($result['Id'] as $id) {
			$consulta = $this->db->get_where('voto', array('Id' => $id));
			array_push($result['Nombre'], $consulta->result()[0]->Nombre);
		}
		return $result;
	}

	//Devuelve un recuento de un voto en concreto en una votación concreta, eliminando dichos votos del registro.
	public function volcadoVotos($idVotacion, $idVoto) {	//ACTUALMENTE EN DESUSO.
		$usuario_votacion = $this->db->get_where('usuario_votacion', array('Id_Votacion' => $idVotacion));
		$cont = 0;
		foreach ($usuario_votacion->result() as $row) {
			if (password_verify($idVoto, $row->Id_Voto) == true) {
				$cont++;
				$this->db->delete('usuario_votacion', array('Id_Votacion' => $row->Id_Votacion, 'Id_Usuario' => $row->Id_Usuario));
			}
		}
		return $cont;
	}

	//Inserta los resultados de una votación en la tabla recuento.
	public function insertVotos($idVotacion, $arrayIdVoto, $arrayNumVotos) {	//ACTUALMENTE EN DESUSO.
		for($it=0; $it<count($arrayIdVoto); $it++) {
			$this->db->insert('recuento', array('Id_Votacion' => $idVotacion, 'Id_Voto' => $arrayIdVoto[$it], 'Num_Votos' => $arrayNumVotos[$it]));
			//$sql = "INSERT INTO recuento (Id_Votacion,Id_Voto,Num_Votos) VALUES (" . $idVotacion . "," . $arrayIdVoto[$it] . "," . $arrayNumVotos[$it] . ") ON DUPLICATE KEY UPDATE Id_Votacion=Id_Votacion, Id_Voto=Id_Voto";
			//$this->db->update('recuento', array('Id_Votacion' => $idVotacion, 'Id_Voto' => $arrayIdVoto[$it], 'Num_Votos' => $arrayNumVotos[$it]));
			//$this->db->query($sql);
		}
	}

	//Devuelve la cantidad de un voto concreto para una votacion.
	public function getNVotos($idVotacion, $idVoto, $idGrupo = "") {
		if ($idGrupo == "") {
			$consulta = $this->db->get_where('recuento', array('Id_Votacion' => $idVotacion, 'Id_Voto' => $idVoto));
			$total = 0;
			foreach($consulta->result() as $row)
				$total += $row->Num_Votos;
			return $total;
		} else {
			$consulta = $this->db->get_where('recuento', array('Id_Votacion' => $idVotacion, 'Id_Voto' => $idVoto, 'Id_Grupo' => $idGrupo));
			return $consulta->result()[0]->Num_Votos;
		}
	}

	//Devuelve el quorum (%) requerido en una votacion.
	public function getQuorum($idVotacion) {
		$consulta = $this->db->get_where('votacion', array('Id' => $idVotacion));
		return $consulta->result()[0]->Quorum;
	}

	//Devuelve el tamaño del censo de la votacion indicada.
	public function getCenso($idVotacion) {
		$consulta = $this->db->get_where('censo', array('Id_Votacion' => $idVotacion));
		if ($consulta->num_rows() == 0) return 200;
		else return $consulta->num_rows();
	}

	//Devuelve toda la información necesaria para que se muestre el recuento.
	public function getFullVotoData($idVotacion) {
		$votos = $this->getOptions($idVotacion);
		$aGrupoPonderacion = $this->getGroupData($idVotacion);
		$contVotos = array();
		foreach($votos['Nombre'] as $opcion) 
			array_push($contVotos, array($opcion => array()));
		$totalVotos = 0;
		$abstenciones = $this->getNVotos($idVotacion, 1, 4);
		$opcionVoto = 0;
		foreach($votos['Id'] as $idVoto) {
			foreach($aGrupoPonderacion['Id'] as $idGrupo) {
				$nVotos = $this->getNVotos($idVotacion, $idVoto, $idGrupo);
				array_push($contVotos[$votos['Nombre'][$opcionVoto]], $nVotos);
				$totalVotos = $totalVotos + $nVotos;
			}
			$opcionVoto++;
		}
		$result = array('opciones' => $votos['Nombre'],		//Nombres de los votos.
						'grupos' => $aGrupoPonderacion['Grupo'],		//Nombres de los grupos.
						'matrizVotos' => $contVotos,			//Matriz con el total de votos. El primer [] tiene las opciones de voto en el mismo orden que $opciones. El segundo [] no es nominal, y tiene la cantidad de votos para el grupo i, en el mismo orden que $grupos.
						'totalVotos' => $totalVotos,		//Suma total de votos.
						'abstenciones' => $abstenciones,	//Cantidad de personas del censo que no han votado.
						'quorum' => $this->getQuorum($idVotacion),	//Quorum de la votacion (0-1).
						'censo' => $this->getCenso($idVotacion),	//Tamaño del censo.
						'titulo' => $this->getVotacionTitle($idVotacion),
						'descripcion' => $this->getVotacionDescription($idVotacion),
						'votacion' => $idVotacion);			//Id de la votacion actual.	
		return $result;
	}
	
	//Devuelve el titulo de una votacion.
	private function getVotacionTitle($idVotacion) {
		$consulta = $this->db->get_where('votacion', array('Id' => $idVotacion));
		return $consulta->row()->Titulo;
	}
	
	//Devuelve la descripcion de una votacion.
	private function getVotacionDescription($idVotacion) {
		$consulta = $this->db->get_where('votacion', array('Id' => $idVotacion));
		return $consulta->row()->Descripcion;
	}
	
	//Devuelve un array compuesto de un array de Nombre de grupo y un array de Ponderacion, correspondientes a la votacion dada.
	private function getGroupData($idVotacion) {
		$consulta = $this->db->get_where('ponderaciones', array('Id_Votacion' => $idVotacion));
		$arrayGlobal = array('Id' => array(), 'Grupo' => array(), 'Ponderacion' => array());
		foreach($consulta->result() as $row) {
			$consulta2 = $this->db->get_where('grupo', array('Id' => $row->Id_Grupo));
			array_push($arrayGlobal['Id'], $consulta2->result()[0]->Id);
			array_push($arrayGlobal['Grupo'], $consulta2->result()[0]->Nombre);
			array_push($arrayGlobal['Ponderacion'], $row->Valor);
		}
		return $arrayGlobal;
	}

	//Establece como finalizada una votación.
	public function setFinalizada($idVotacion) {
		$this->db->where('Id', $idVotacion);
		$this->db->update('votacion', array('Finalizada' => 1));
	}

	//Establece como inválida una votación.
	public function setInvalida($idVotacion) {
		$this->db->where('Id', $idVotacion);
		$this->db->update('votacion', array('Finalizada' => 1, 'Invalida' => 1));
	}

	//Comprueba si una votación está finalizada.
	public function isFinished($idVotacion) {
		$consulta = $this->db->get_where('votacion', array('Id' => $idVotacion));
		return ($consulta->result()[0]->Finalizada == 1);
	}

  public function eliminarMiembroFromVotacion($idMiembro,$idVotacion)
  {
    $query = $this->db->query("DELETE FROM mesa_electoral WHERE Id_Votacion = '$idVotacion' AND Id_Usuario = '$idMiembro'");
  }

  public function getMesa($idVotacion)
  {
    $query = $this->db->get_where('mesa_electoral', array('Id_Votacion' => $idVotacion));
    return $query->result();
  }

  public function deleteMesa($idVotacion)
  {
    $query = $this->db->query("DELETE FROM mesa_electoral WHERE Id_Votacion = '$idVotacion'");
    //return $query->result();
  }

}


?>
