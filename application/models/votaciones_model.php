<?php
	class votacion_model extends CI_Model {
		public function __construct ()
		{
			parent::__construct ();
		}

		// Lista los datos de las votaciones
		public function _listar ( $select, $from, $where )
		{
			// select mediante conexion a la BD con mysqli
			$mysqli = mysqli_connect("localhost", "root", "", "NombreBD"); 
			if($mysqli == false) { 
			    die("ERROR: Could not connect. ".mysqli_connect_error()); 
			}  
			$sql = "select ' ".$select."' from '".$from."' where '".$where."'";
			$query = mysqli_query($mysqli, $sql);
			if( mysqli_num_rows($query) == 0 ) {  
			    echo "No rows matched. ".mysqli_error($mysqli); 
			} else { 
			    return $query; 
			} 
			mysqli_close($mysqli);

			// select mediante envio de consulta directa, sin conexion
			$sql = "select ' ".$select."' from '".$from."' where '".$where."'";
				// elegir un metodo de ejecucion de query de los dos
			// $query = mysqli_query ($sql);
			// $query = $this -> db -> query($sql);
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
			// update mediante conexion a la BD con mysqli
			$mysqli = mysqli_connect("localhost", "root", "", "NombreBD"); 
			if($mysqli == false) { 
			    die("ERROR: Could not connect. ".mysqli_connect_error()); 
			}   
			$sql = "update 'votaciones' set '_votos.id_usuario' = '".$id_usuario."', '_votos.voto' = '".$voto."', where id_votacion = '".$id_votacion."'";
			$query = mysqli_query($mysqli, $sql);
			if($query) { 
			    echo "Record was updated successfully."; 
			} else { 
			    echo "ERROR: Could not able to execute $sql. ".mysqli_error($mysqli); 
			}  
			mysqli_close($mysqli);


			// update mediante envio de consulta directa, sin conexion
			$sql = "update 'votaciones' set '_votos.id_usuario' = '".$id_usuario."', '_votos.voto' = '".$voto."', where id_votacion = '".$id_votacion."'";
				// elegir un metodo de ejecucion de query de los dos
			// $query = mysqli_query ($sql);
			// $query = $this -> db -> query($sql);
			if($query) {  
			    echo "Record was updated successfully."; 
			} else { 
			    echo "ERROR: Could not able to execute $sql. ".mysqli_error($mysqli); 
			} 
		}
	}
?>