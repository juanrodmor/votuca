<?php
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
			$sql = "select votacion.Id, votacion.Titulo, votacion.Descripcion, voto.Nombre, votacion.FechaInicio, votacion.FechaFinal
						from votacion, usuario_votacion, voto
						where votacion.Id = usuario_votacion.Id_Votacion
							AND usuario_votacion.Id_Usuario = ".$id_user."
							AND usuario_votacion.Id_Voto = voto.Id
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

		// Votar
		public function _votar ( $id_usuario, $id_votacion, $voto )
		{
			$sql = $this->db->get_where('voto', array('Nombre' => $voto));
			$id_voto = $sql->row()->Id;
			//print_r($id_voto);

			$sql = "update usuario_votacion set Id_voto = '".$id_voto."' where Id_Usuario = '".$id_usuario."' and Id_Votacion = '".$id_votacion."';";
			$query = $this -> db -> query($sql);
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

		/*
		// Realizar votacion desde 0 (insert)
		public function _votar ( $id_usuario, $id_votacion, $voto )
		{
			$sql = "select Id from voto where Nombre = '".$voto."'";
			$query = $this -> db -> query($sql);
			$id_voto = mysql_fetch_array($query) or die(mysqli_error());

			$sql = "insert into 'usuario_votacion' (Id_Usuario, Id_Votacion, Id_voto) values ('".$id_usuario."','".$id_votacion."','".$id_voto['Id']."');";
			$query = $this -> db -> query($sql);
			if($query) {
			    echo "Voto insertado correctamente.";
			} else {
			    echo "ERROR: Could not able to execute $sql. ";
			}
		}
		*/

		// Indica si un usuario ya ha votado
		public function _haVotado ( $id_usuario, $id_votacion )
		{
			$sql = "select Id_usuario from usuario_votacion where Id_Usuario = '".$id_usuario."' and Id_Votacion = '".$id_votacion."' and Id_Voto = 'No votado';";
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
			$query = $this->db->query("SELECT Id_voto from usuario_votacion WHERE Id_Votacion = '$id_votacion';");
			// return $query->num_rows();
			return $query->result();
		}

		public function recuentoVotosElectoral($id_votacion)	//votos totales de la votacion $id_votacion
		{
			$query = $this->db->query("SELECT Id_voto from usuario_votacion WHERE Id_Votacion = '$id_votacion';");
			return $query->num_rows();
			//return $query->result();
		}


		public function tiposVotos($datos)	//votos totales de la votacion $id_votacion
		{
			$Si = 0;
			$No = 0;
			$Bl = 0;
			//echo var_dump($datos);
			//echo $datos[0]->Id_voto;
			$sql = $this->db->get_where('voto', array('Id' => $datos[0]->Id_voto));
			for($i = 0; $i < sizeof($datos); ++$i) {
				switch($datos[$i]->Id_voto) {
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
					'Id_Voto' => $sinVoto
				);
				$this->db->insert('usuario_votacion',$datos);
			}
		}
		

	}
?>
