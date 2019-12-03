f<?php
	class Voto_model extends CI_Model {
		public function __construct ()
		{
			parent::__construct ();
			$this->load->database();
			/*
			$mysqli = mysqli_connect("localhost", "root", "", "votuca");
			if($mysqli == false) {
			    die("ERROR: Could not connect. ".mysqli_connect_error());
			}
			*/
		}

		// Lista los datos de las votaciones
		public function _listar ($id_user)
		{
			$sql = "select usuario_votacion.Id_Voto, votacion.Id, votacion.Titulo, votacion.Descripcion, votacion.FechaInicio, votacion.FechaFinal
						from votacion, censo, usuario_votacion
						where votacion.Id = censo.Id_Votacion
							AND censo.Id_Usuario = ".$id_user."
							AND usuario_votacion.Id_Usuario = ".$id_user."
							AND usuario_votacion.Id_Votacion = votacion.Id
							AND votacion.isDeleted = 0
						order by votacion.FechaFinal ASC;";

			//$sql = "select Titulo, Descripcion, FechaInicio, FechaFinal from votacion;";
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
		public function _votar ( $id_usuario, $id_votacion, $voto )
		{

			$sql = $sql = $this->db->get_where('votacion', array('Id' => $id_votacion, 'isDeleted' => FALSE));
			//echo $sql->num_rows();
			//echo var_dump($sql->row()->Id);


			if(($sql->num_rows() != 0) and ($sql->row()->FechaInicio <= date('Y-m-d H:i:s')) and ($sql->row()->FechaFinal >= date('Y-m-d H:i:s'))) {
				$sql = $this->db->get_where('voto', array('Nombre' => $voto));
				$id_voto = $sql->row()->Id;

				$sql = "update usuario_votacion set Id_voto = '".password_hash($id_voto, PASSWORD_DEFAULT)."' where Id_Usuario = '".$id_usuario."' and Id_Votacion = '".$id_votacion."';";
				$query = $this -> db -> query($sql);
				return TRUE;	// has votado correctamente
			} else {
				return FALSE;	// else -> no se guarda el voto porque o bien 1. se ha eliminado, 2. no existe tal votacion
			}
				//echo var_dump($sql->result());

		}

		public function _votosDisponibles () {	// habra que cambiarla, esta muestra TODOS los votos disponibles, no solo los de una votacion especifica
			$sql = "select Nombre from voto where id != '1';";		// habra que pasarle el id de la votacion para que muestre sus votos disponibles
			$query = $this -> db -> query($sql);
			if($query) {
			    return $query->result();
			} else {
			    echo "ERROR: Could not able to execute $sql. ";
			}
		}

		// Indica si un usuario ya ha votado
		public function _haVotado ( $id_votacion )
		{
			$id_user = _userId($_SESSION['usuario']);
			$sql = "select Id_usuario from usuario_votacion where Id_Usuario = '".$id_user."' and Id_Votacion = '".$id_votacion."' and Id_Voto = '1';";
			$query = $this -> db -> query($sql);
			if( $query->num_rows() == 0 ) {
			    return false;
			} else {
			    return true;
			}
		}

		/********************************/
		/******* RECUENTO DE VOTOS ******/
		/********************************/
		public function recuentoVotos($id_votacion)	//votos totales de la votacion $id_votacion
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

		}

		/********************************************/
		/******* INSERTAR UN USUARIO DEL CENSO ******/
		/********************************************/
		public function votoDefecto($usuarios, $nuevoId, $sinVoto) {
			for($i = 0; $i < sizeof($usuarios); $i++)
	    {
				$id = (int)$usuarios[$i];
				$datos = array(
					'Id_Usuario' => $id,
					'Id_Votacion' => $nuevoId,
					'Id_Voto' => '1'
				);
				$this->db->insert('usuario_votacion',$datos);
			}
		}

	}
?>
