<?php
	class votacion_model extends CI_Model {
		public function __construct ()
		{
			parent::__construct ();
			/* CONEXION A LA BD EN CONSTRUCTOR

			$mysqli = mysqli_connect("localhost", "root", "", "votuca"); 
			if($mysqli == false) { 
			    die("ERROR: Could not connect. ".mysqli_connect_error()); 
			}
			*/
		}

		// Lista los datos de las votaciones
		public function _listar ( $select, $from, $where )
		{
			$sql = "select ' ".$select."' from '".$from."' where '".$where."';";
			$query = $this -> db -> query($sql);
			if ( mysqli_num_rows($query) == 0 )
			{
				echo "No rows matched. ".mysqli_error($mysqli); 
			} else {
				return $query;
			}
		}

		// Realizar votacion
		public function _votar ( $id_usuario, $id_votacion, $voto )
		{
			$sql = "select Id from voto where Nombre = '".$voto."'";
			$query = $this -> db -> query($sql);
			$id_voto = mysqli_fetch_array($query) or die(mysqli_error());

			$sql = "insert into 'usuario_votacion' (Id_Usuario, Id_Votacion, Id_voto) values ("$id_usuario",".$id_votacion.",".$id_voto['Id'].");";
			$query = $this -> db -> query($sql);
			if($query) {  
			    echo "Voto insertado correctamente."; 
			} else { 
			    echo "ERROR: Could not able to execute $sql. ".mysqli_error($mysqli); 
			} 
		}

		// Indica si un usuario ya ha votado
		public function _haVotado ( $id_usuario, $id_votacion )
		{
			$sql = "select id_voto from usuario_votacion where Id_Usuario = '".$id_usuario."' and Id_Votacion = '".$id_votacion."';";
			$query = $this -> db -> query($sql);
			if( mysqli_num_rows($query) == 0 ) {  
			    return false;
			} else { 
			    return true;
			} 
		}

		// Rectificar votacion
		public function _rectificarVoto ( $id_usuario, $id_votacion, $voto )
		{
			$sql = "select Id from voto where Nombre = '".$voto."'";
			$query = $this -> db -> query($sql);
			$id_voto = mysqli_fetch_array($query) or die(mysqli_error());

			$sql = "update usuario_votacion set Id_voto = '".$id_voto."', where Id_Usuario = '".$id_usuario."' and Id_Votacion = '".$id_votacion."';";
			$query = $this -> db -> query($sql);
			if($query) {  
			    echo "Voto rectificado correctamente."; 
			} else { 
			    echo "ERROR: Could not able to execute $sql. ".mysqli_error($mysqli); 
			} 


		}

	}
?>