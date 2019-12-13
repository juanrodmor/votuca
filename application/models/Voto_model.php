f<?php
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
							votacion.VotoModificable, votacion.NumOpciones
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

				$sql = $sql = $this->db->get_where('votacion', array('Id' => $id_votacion, 'isDeleted' => FALSE, 'esBorrador' => FALSE, 'Finalizada' => FALSE, 'Invalida' => FALSE));
				//echo $sql->num_rows();
				//echo var_dump($sql->row()->Id);

				if(($sql->num_rows() != 0) and ($sql->row()->FechaInicio <= date('Y-m-d H:i:s')) and ($sql->row()->FechaFinal >= date('Y-m-d H:i:s'))) {	//comprobar votacion valida
					if($modif == TRUE) {

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
				$sql = $sql = $this->db->get_where('votacion', array('Id' => $id_votacion, 'isDeleted' => FALSE, 'esBorrador' => FALSE, 'Finalizada' => FALSE, 'Invalida' => FALSE));

				if(($sql->num_rows() != 0) and ($sql->row()->FechaInicio <= date('Y-m-d H:i:s')) and ($sql->row()->FechaFinal >= date('Y-m-d H:i:s'))) {
					if($modif == TRUE) {

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


// --------------------------------------------------------------------------------------------------------------------------------------------------------------

		/********************************/
		/******* RECUENTO DE VOTOS ******/
		/********************************/
		public function recuentoVotos($id_votacion)
		{
			$sql = $sql = $this->db->get_where('votacion', array('Id' => $id_votacion, 'isDeleted' => FALSE));

			if(($sql->num_rows() != 0) and ($sql->row()->FechaFinal < date('Y-m-d H:i:s'))) {
				$query = $this->db->query("SELECT Id_voto from usuario_votacion WHERE Id_Votacion = '$id_votacion';");
				// return $query->num_rows();
				return $query->result();
			} else return FALSE;
		}

		public function recuentoVotosElectoral($id_votacion)	//votos totales de la votacion $id_votacion
		{
			$query = $this->db->query("SELECT Id_voto from usuario_votacion WHERE Id_Votacion = '$id_votacion';");
			return $query->num_rows();
			//return $query->result();
		}


		public function tiposVotos($datos)	//votos totales de la votacion $id_votacion
		{
/*
			$Abs = 0;
			$Si = 0;
			$No = 0;
			$Bl = 0;
			//echo var_dump($datos);
			//echo $datos[0]->Id_voto;
			$sql = $this->db->get_where('voto', array('Id' => $datos[0]->Id_voto));
			for($i = 0; $i < sizeof($datos); ++$i) {
				switch($datos[$i]->Id_voto) {
					case '1':
						$Abs++;
						break;
					case '2':
						$Si++;
						break;
					case '3':
						$No++;
						break;
					case '4':
						$Bl++;
						break;
				}
			}
			$votos = array (
				'Abs' => $Abs,
				'Si' => $Si,
				'No' => $No,
				'Bl' => $Bl
			);
			return $votos;
			*/

		}

		/********************************************/
		/******* INSERTAR UN USUARIO DEL CENSO ******/
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
	}
?>
