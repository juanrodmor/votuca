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
			$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $Nombre));
			//print_r($consulta->row()->Id);
			return $consulta->row()->Id;
		}

		// Votar
		public function _votar ( $id_usuario, $id_votacion, $voto )
		{
			$sql = "select Id from voto where Nombre = '".$voto."'";
			$query = $this -> db -> query($sql);
			$id_voto = mysql_fetch_array($query) or die(mysqli_error());

			$sql = "update usuario_votacion set Id_voto = '".$id_voto."', where Id_Usuario = '".$id_usuario."' and Id_Votacion = '".$id_votacion."';";
			$query = $this -> db -> query($sql);
			if($query) {  
			    echo "Voto actualizado correctamente."; 
			} else { 
			    echo "ERROR: Could not able to execute $sql. "; 
			} 
		}

		public function _votosDisponibles () {
			$sql = "select Nombre from voto where id != '1';";
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
		public function recuentoVotos($idVotacion)
		{
			$query = $this->db->query("SELECT Id_voto from usuario_votacion WHERE Id_Votacion = '$idVotacion';");
			return $query->num_rows();
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