<?php
	class Voto_model extends CI_Model {
		public function __construct ()
		{
			parent::__construct ();
			$this->load->database();
		}

		// Lista los datos de las votaciones
		public function _listar ($id_user)
		{
			$sql = "select votacion.Id, votacion.Titulo, votacion.Descripcion,
							votacion.FechaInicio, votacion.FechaFinal,
							votacion.VotoModificable, votacion.NumOpciones,
							votacion.Finalizada, votacion.Invalida
						from votacion, censo
						where votacion.Id = censo.Id_Votacion
							AND censo.Id_Usuario = ".$id_user."
							AND votacion.isDeleted = 0
							AND votacion.esBorrador = 0
						order by votacion.FechaFinal ASC;";

			$query = $this -> db -> query($sql);
			if ( $query->num_rows() == 0 )
			{
				return null;
			} else {
				return $query->result();
			}
		}

		public function _userId($Nombre) {
			//print_r($Nombre);
			$sql = $this->db->get_where('usuario', array('NombreUsuario' => $Nombre));
			//print_r($sql->row()->Id);
			return $sql->row()->Id;
		}

		public function _userName($id_usuario) {
			//print_r($Nombre);
			$sql = $this->db->get_where('usuario', array('Id' => $id_usuario));
			//print_r($sql->row()->Id);
			return $sql->row()->NombreUsuario;
		}

		// Votar
		public function _votar ( $id_usuario, $id_votacion, $voto, $modif )
		{
			if(gettype($voto) == "string") { 			//votacion simple

				$sql = $sql = $this->db->get_where('votacion', array('Id' => $id_votacion, 'isDeleted' => FALSE, 'esBorrador' => FALSE, 'Finalizada' => FALSE));
				//echo $sql->num_rows();
				//echo var_dump($sql->row()->Id);

				if(($sql->num_rows() != 0) and ($sql->row()->FechaInicio <= date('Y-m-d H:i:s')) and ($sql->row()->FechaFinal >= date('Y-m-d H:i:s'))) {	//comprobar votacion valida
					if($modif == TRUE) {

						// Decrementar el numero de abstenidos de recuento si aun no se había votado
						if(!$this->_haVotado($id_votacion)) {
							$sql = $this->db->get_where('recuento', array('Id_Votacion' => $id_votacion, 'Id_voto' => '1'));
							//$sql = $sql->result();
							$numVotos = $sql->row()->Num_Votos;
							$numVotos--;

							$sql = "update recuento set Num_Votos = '".$numVotos."' where Id_Votacion = '".$id_votacion."' AND Id_Voto = '1';";
							$query = $this -> db -> query($sql);
						}

						$sql = $this->db->get_where('voto', array('Nombre' => $voto));
						$id_voto = $sql->row()->Id;

						$sql = "update usuario_votacion set Id_voto = '".password_hash($id_voto, PASSWORD_DEFAULT)."' where Id_Usuario = '".$id_usuario."' and Id_Votacion = '".$id_votacion."';";
						$query = $this -> db -> query($sql);

						return TRUE;	// has votado/rectificado correctamente
					}
					else {
						// Eliminamos el registro de usuario_votacion
						$sql = $this->db->delete('usuario_votacion', array('Id_Usuario' => $id_usuario, 'Id_Votacion' => $id_votacion));	//quitar de la cesta


						// Sumamos el voto del elector
							$sql = $this->db->get_where('voto', array('Nombre' => $voto));
							$id_voto = $sql->row()->Id;

							$sql = $this->db->get_where('recuento', array('Id_Votacion' => $id_votacion, 'Id_voto' => $id_voto));
							//$sql = $sql->result();
							$numVotos = $sql->row()->Num_Votos;
							$numVotos++;

							$sql = "update recuento set Num_Votos = '".$numVotos."' where Id_Votacion = '".$id_votacion."' AND Id_Voto = '".$id_voto."';";
							$query = $this -> db -> query($sql);


						// Decrementar el numero de abstenidos
							$sql = $this->db->get_where('recuento', array('Id_Votacion' => $id_votacion, 'Id_voto' => '1'));
							//$sql = $sql->result();
							$numVotos = $sql->row()->Num_Votos;
							$numVotos--;

							$sql = "update recuento set Num_Votos = '".$numVotos."' where Id_Votacion = '".$id_votacion."' AND Id_Voto = '1';";
							$query = $this -> db -> query($sql);

						return TRUE;
					}
				} else
					return FALSE;	// else -> no se guarda el voto porque o bien 1. se ha eliminado, 2. no existe tal votacion
					//echo var_dump($sql->result());
			}

			if(gettype($voto) == "array") {				//votacion compleja
				$sql = $sql = $this->db->get_where('votacion', array('Id' => $id_votacion, 'isDeleted' => FALSE, 'esBorrador' => FALSE, 'Finalizada' => FALSE));

				if(($sql->num_rows() != 0) and ($sql->row()->FechaInicio <= date('Y-m-d H:i:s')) and ($sql->row()->FechaFinal >= date('Y-m-d H:i:s'))) {
					if($modif == TRUE) {

						// Decrementar el numero de abstenidos de recuento si aun no se había votado
						if(!$this->_haVotado($id_votacion)) {
							$sql = $this->db->get_where('recuento', array('Id_Votacion' => $id_votacion, 'Id_voto' => '1'));
							//$sql = $sql->result();
							$numVotos = $sql->row()->Num_Votos;
							$numVotos--;

							$sql = "update recuento set Num_Votos = '".$numVotos."' where Id_Votacion = '".$id_votacion."' AND Id_Voto = '1';";
							$query = $this -> db -> query($sql);
						}

						$sql = $this->db->delete('usuario_votacion', array('Id_Usuario' => $id_usuario, 'Id_Votacion' => $id_votacion));
						foreach($voto as $nuevoVoto) {
							//echo $nuevoVoto->Id_Voto;
							$sql = $this->db->get_where('voto', array('Nombre' => $nuevoVoto));
							$id_voto = $sql->row()->Id;

							$datos = array(
								'Id_Usuario' => $id_usuario,
								'Id_Votacion' => $id_votacion,
								'Id_Voto' => password_hash($id_voto, PASSWORD_DEFAULT)
							);
							$sql = $this->db->insert('usuario_votacion', $datos);
						}

						return TRUE;	// has votado correctamente
					}
					else {
						// Eliminamos el registro de usuario_votacion
						$sql = $this->db->delete('usuario_votacion', array('Id_Usuario' => $id_usuario, 'Id_Votacion' => $id_votacion));	//quitar de la cesta


						// Sumamos el voto del elector
						foreach($voto as $unico) {

							$sql = $this->db->get_where('voto', array('Nombre' => $unico));
							$id_voto = $sql->row()->Id;

							$sql = $this->db->get_where('recuento', array('Id_Votacion' => $id_votacion, 'Id_voto' => $id_voto));
							//$sql = $sql->result();
							$numVotos = $sql->row()->Num_Votos;
							$numVotos++;

							$sql = "update recuento set Num_Votos = '".$numVotos."' where Id_Votacion = '".$id_votacion."' AND Id_Voto = '".$id_voto."';";
							$query = $this -> db -> query($sql);

						}


						// Decrementar el numero de abstenidos
							$sql = $this->db->get_where('recuento', array('Id_Votacion' => $id_votacion, 'Id_voto' => '1'));
							//$sql = $sql->result();
							$numVotos = $sql->row()->Num_Votos;
							$numVotos--;

							$sql = "update recuento set Num_Votos = '".$numVotos."' where Id_Votacion = '".$id_votacion."' AND Id_Voto = '1';";
							$query = $this -> db -> query($sql);

						return TRUE;
					}
				} else
					return FALSE;
			}

			else return FALSE;

		}

		public function _votosDisponibles ($id_votacion) {
			//1 -> obtener los votos de la votacion
			//2 -> obtener los nombres de esos votos
			// resumen -> 2 llamadas SQL

			$sql = "select Id_Voto from votacion_voto where Id_Votacion = '".$id_votacion."';";
			$query = $this -> db -> query($sql);
			$query = $query->result();
			// echo var_dump($query[$i]->Id_Voto);

			$votos = array();
			foreach($query as $voto) {
				$sql = "select Nombre from voto where Id = '".$voto->Id_Voto."';";
				$query = $this -> db -> query($sql);
				//echo $query->row()->Nombre;
				array_push($votos, $query->row()->Nombre);
			}
			//print_r($votos);
			return $votos;
		}

		// Indica si un usuario ya ha votado
		public function _haVotado ( $id_votacion )
		{
			$id_user = $this->_userId($_SESSION['usuario']);
			$sql = "select Id_usuario from usuario_votacion where Id_Usuario = '".$id_user."' and Id_Votacion = '".$id_votacion."' and Id_Voto = '1';";
			$query = $this -> db -> query($sql);
			if( $query->num_rows() == 0 )
				return true;
			else
				return false;
		}

		public function _usuarioVotacionToRecuento( $id_votacion ) {	// pasar tabla de usuario_votacion a recuento

			$sql = $this->db->get_where('usuario_votacion', array('Id_Votacion' => $id_votacion, 'Id_Voto !=' => '1') );
			$sql = $sql->result();

			foreach ($sql as $voto_E) {

				$rec = $this->db->get_where('recuento', array('Id_Votacion' => $id_votacion, 'Id_Voto !=' => '1'));
				$rec = $rec->result();

				foreach($rec as $voto) {
					if(password_verify($voto->Id_Voto, $voto_E->Id_Voto)) {

						$numVotos = $voto->Num_Votos;
						$numVotos++;
						$sql = "update recuento set Num_Votos = '".$numVotos."' where Id_Votacion = '".$id_votacion."' and Id_Voto = '".$voto->Id_Voto."';";
						$query = $this -> db -> query($sql);
					}
				}

			}

			$sql = $this->db->delete('usuario_votacion', array('Id_Votacion' => $id_votacion));
		}

		public function _actualizarFechasVotaciones() {
			$sql = $this->db->get_where('votacion', array());
			$sql = $sql->result();
			foreach($sql as $votacion) {
				if($votacion->FechaFinal < date('Y-m-d H:i:s')) {
					$this->_usuarioVotacionToRecuento($votacion->Id);
				}
			}
		}


// --------------------------------------------------------------------------------------------------------------------------------------------------------------

		/********************************/
		/******* RECUENTO DE VOTOS ******/
		/********************************/
		public function recuentoVotos($id_votacion)	// Obtengo los ids de los votos y el numero de votos asignado a tal votacion
		{
			$sql = $sql = $this->db->get_where('votacion', array('Id' => $id_votacion, 'isDeleted' => FALSE, 'esBorrador' => FALSE, 'Finalizada' => TRUE));

			if(($sql->num_rows() != 0) and ($sql->row()->FechaFinal < date('Y-m-d H:i:s'))) {
				//$query = $this->db->query("SELECT Id_voto from recuento WHERE Id_Votacion = '$id_votacion';");
				$sql = $this->db->get_where('recuento', array('Id_Votacion' => $id_votacion));
				return $sql->result();
			} else return FALSE;
		}

		public function censoAsignado($id_votacion)
		{
			$query = $this->db->query('select count(Id_Usuario) as total from censo where Id_votacion = "'.$id_votacion.'"');
			return $query->row()->total;
		}

		public function nombreVotos($datos)	// Nombre de los votos de $datos
		{
			$votos = array();
			foreach($datos as $voto)
			{
				$sql = $this->db->get_where('voto', array('Id' => $voto->Id_Voto));
				array_push($votos, $sql->row()->Nombre);
			}
			return $votos;
		}

		public function recuentoVotosElectoral($id_votacion)	//votos totales de la votacion $id_votacion
		{
			$query = $this->db->query("SELECT Id_voto from usuario_votacion WHERE Id_Votacion = '$id_votacion';");
			return $query->num_rows();
			//return $query->result();
		}

		/********************************************/
		/******* FUNCIONES INMA *********************/
		/********************************************/

		public function votoDefecto($usuarios, $nuevoId, $sinVoto) {
			for($i = 0; $i < sizeof($usuarios); $i++)
	    	{
				//password_hash($sinVoto, PASSWORD_DEFAULT)
				$id = (int)$usuarios[$i];
				$datos = array(
					'Id_Usuario' => $id,
					'Id_Votacion' => $nuevoId,
					'Id_Voto' => $sinVoto
				);
				$this->db->insert('usuario_votacion',$datos);
			}
		}

		public function borrarVoto($usuarios,$idVotacion)
		{
			foreach($usuarios as $usuario)
				$this->db->delete('usuario_votacion', array(
														'Id_Votacion' => $idVotacion,
														'Id_Usuario' => $usuario
														));
		}

		public function votoExists($nombreVoto)
		{
			$consulta = $this->db->get_where('voto', array('Nombre' => $nombreVoto));
			return ($consulta->num_rows() == 1);
		}

		public function nuevoTipoVoto($nombreVoto)
		{
			// COMPROBAR QUE NO EXISTE YA
			if(!$this->votoExists($nombreVoto))
			{
				$nuevoTipo =array(
					'Nombre' => $nombreVoto
				);
				$this->db->insert('voto',$nuevoTipo);
			}
		}

		public function insertarOpciones($idVotacion,$idsOpciones)
		{
			foreach($idsOpciones as $opcion)
			{
				$datos = array(
					'Id_Votacion' => $idVotacion,
					'Id_Voto' => $opcion
				);
				$this->db->insert('votacion_voto',$datos);
			}
		}

		public function getVotosFromVotacion($idVotacion)
		{
			$query = $this->db->query("SELECT Id_Voto from votacion_voto WHERE Id_Votacion = '$idVotacion';");
			return $query->result();
		}

		public function getIdFromNombreVoto($nombreVoto)
		{
			$consulta = $this->db->get_where('voto', array('Nombre' => $nombreVoto));
			return $consulta->row()->Id;
		}

		public function getNombreFromIdVoto($id)
		{
			$consulta = $this->db->get_where('voto', array('Id' => $id));
			return $consulta->row()->Nombre;
		}


		public function recuentoPorDefecto($idVotacion,$opciones,$totalUsuarios)
		{
			$valor = 0;
			$usuariosTotales = $totalUsuarios[0]->total;
			foreach($opciones as $opcion)
			{
				$valor = 0;
				$datos = array(
					'Id_Votacion' => $idVotacion,
					'Id_Voto' => $opcion->Id_Voto,
					'Num_Votos' => $valor
				);
				$this->db->insert('recuento',$datos);
			}
			$this->db->query("INSERT INTO recuento (Id_Votacion,Id_Voto,Num_Votos) VALUES ('.$idVotacion.',1,'.$usuariosTotales.')");
			}
}
?>
