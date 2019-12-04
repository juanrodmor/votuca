<?php

class Usuario_model extends CI_Model {
	//Nos aseguramos que cargue la base de datos.
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	*	Crea un nuevo usuario en la base de datos.
	*	$username - Identificador del usuario. Ej: u00000000
	*	$password - Contraseña cifrada
	*	$id_rol - Id correspondiente al rol del usuario en el sistema.
	*	$email - Dirección email.
	*/
	public function setUserObject($username, $password, $id_rol, $email)
	{
		$data = array(
			'Id_Rol' => $id_rol,
			'NombreUsuario' => $username,
			'Password' => $password,
			'Email' => $email
		);
		
		$this->db->insert('usuario', $data);
	}

	//Devuelve la contraseña de un usuario específico.
	public function getPass($usuario) {
		$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $usuario));
		return $consulta->row()->Password;
	}

	//Devuelve el Id de un usuario dado.
	public function getId($usuario) {
		$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $usuario));
		return $consulta->row()->Id;
	}

	//Elimina un usuario de la tabla Expiracion.
	public function deleteExpiracion($usuario) {
		$idUsuario = $this->getId($usuario);
		$this->db->delete('expiracion', array('Id_Usuario' => $idUsuario));
	}

	//Elimina un usuario de la BD.
	public function deleteUsuario($usuario) {
		$idUsuario = $this->getId($usuario);
		if($idUsuario[0] == 's' && $this->userExistsTable($idUsuario, 'secretarios_delegados')) {	//Si era secretario delegado
			$this->db->delete('secretarios_delegados', array('Id_Usuario' => $idUsuario));
		} else if ($idUsuario[0] == 'm' && $this->userExistsTable($idUsuario, 'mesa_electoral')) {	//Si era miembro electoral
			$this->db->delete('mesa_electoral', array('Id_Usuario' => $idUsuario));
		}
		$this->db->delete('expiracion', array('Id_Usuario' => $idUsuario));
		$this->db->delete('usuario', array('Id' => $idUsuario));
	}

	//Comprueba si el usuario recibido existe en la base de datos.
	public function userExists($usuario) {
		$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $usuario));
		return ($consulta->num_rows() == 1);
	}
	
	//Comprueba si un usuario (id) existe en una tabla concreta de la BD.
	private function userExistsTable($idUsuario, $tabla) {
		$consulta = $this->db->get_where($tabla, array('Id_Usuario' => $idUsuario));
		return ($consulta->num_rows() >= 1);
	}

	//Devuelve el rol de un usuario específico.
	public function getRol($usuario) {
		$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $usuario));
		$consulta2 = $this->db->get_where('rol', array('Id' => $consulta->row()->Id_Rol));
		return $consulta2->row()->Nombre;
	}
	
	//Devuelve todos los roles para un usuario; aunque disponga de distintos username.
	public function getAllRoles($usuario)
	{
		$usr = substr($usuario, 1, -1);
		$query = "SELECT Id_Rol FROM USUARIO WHERE NombreUsuario LIKE '%".$usr."';";
		$roles = array();
		foreach($this->db->query($query)->result_array() as $rol)
		{
			array_push($roles, $rol['Id_Rol']); 
		}
		$this->db->select('Nombre');
		$this->db->from('rol');
		$this->db->where_in('Id', $roles);
		$resultado = $this->db->get();
		return $resultado->result_array();
	}
	
	//Devuelve el id del rol referenciado por su nombre en la tabla
	public function getRolId($rolname)
	{
		$consulta = $this->db->get_where('rol', array('Nombre' => $rolname));
		return $consulta->row()->Id;
	}

	//Devuelve una lista con los roles existentes.
	public function getRoles() {
		$this->db->select('Nombre');
		$consulta = $this->db->get('rol');
		$result = $consulta->result_array();
		$roles = array();
		foreach ($result as &$rol) {
			array_push($roles, $rol['Nombre']);
		}
		return $roles;
	}
	
	//Devuelve el email asociado al usuario
	public function getEmail($usuario)
	{
		$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $usuario));
		return $consulta->row()->Email;
	}

	//Modifica el rol de un usuario específico.
	public function setRol($usuario, $rol) {

		$consultaId = $this->db->get_where('rol', array('Nombre' => $rol));
		$rol_id = $consultaId->row()->Id;

		$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $usuario));
		$this->db->where('Id', $consulta->row()->Id);
		$this->db->update('usuario', array('Id_Rol' => $rol_id));
	}
	
	public function checkExpira($idUsuario) {
		$consulta = $this->db->get_where('expiracion', array('Id_Usuario' => $idUsuario));
		return ($consulta->num_rows() >= 1);
	}
	
	public function getFecha($idUsuario) {
		$consulta = $this->db->get_where('expiracion', array('Id_Usuario' => $idUsuario));
		return $consulta->row()->Fecha;
	}
	
	public function setPass($usuario, $pass) {
		$idUsuario = $this->getId($usuario);
		$this->db->where('Id', $idUsuario);
		$this->db->update('usuario', array('Password' => $pass));
	}
	
	/**
	*	Establece una caducidad de 24h para $usuario
	*	$usuario - nombre de usuario
	*/
	public function setUserTimeLimit($usuario)
	{
		$timeLimit = date('Y-m-d H:m:s',strtotime('1 day'));
		
		$data = array(
			'Id_Usuario' => $this->getId($usuario),
			'Fecha' => $timeLimit
		);
		
		$this->db->insert('expiracion', $data);
		
	}


	/*****************************/
	/******* FUNCIONES INMA ******/
	/*****************************/
	public function recuperarTodos()
	{
		$query = $this->db->query("SELECT * from usuario;");
    return $query->result();
	}
	public function recuperarUsuariosRol($rol)
  {
    $query = $this->db->query("SELECT * from usuario WHERE Id_rol = '$rol';");
    return $query->result();
  }
	public function getUsuario($id) {
		$query = $this->db->query("SELECT * from usuario WHERE Id = '$id';");
		return $query->result();
	}

	public function getIdFromUserName($nombre)
	{
		$query = $this->db->query("SELECT Id from usuario WHERE NombreUsuario = '$nombre';");
		return $query->result();
	}

	public function insertUserAs($idUser, $idRol)
	{
		//echo '<br>ANALIZANDO USUARIO CON ID: '.$idUser.'<br>';
		$usuario = $this->getUsuario($idUser);
		$nuevo = array(
			'Id_Rol' => 5,
			'NombreUsuario' => $usuario[0]->NombreUsuario,
			'Password' => $usuario[0]->Password

		);
		// ASEGURARSE QUE ESTE USUARIO NO TENGA YA ESTE ROL
		$disponibles = $this->getIdFromUserName($usuario[0]->NombreUsuario);
		$yaExiste = false;
		for($i = 0; $i < sizeof($disponibles); $i++)
		{
			//echo 'Este usuario tiene este id: '.$disponibles[$i]->Id.'<br>';
			$datos = $this->getUsuario($disponibles[$i]->Id);
			if($datos[0]->Id_Rol == 5){$yaExiste = true;}
		}

		if(!$yaExiste){$this->db->insert('usuario',$nuevo);}
		else{return false;}
		
	}

	/*public function verify_login() {
		$consulta = $this->db->get_where('usuario', array('Usuario' => $this->input->post('usuario', true), 'Contraseña' => $this->input->post('contraseña', true)));
		if ($consulta->num_rows() == 1)
			return true;
		else
			return false;
	}*/

	/*public function add_usuario() {
		$this->db->insert('usuario', array('Nombre' => $this->input->post('nombre', true),
											'Correo' => $this->input->post('correo', true),
											'Usuario' => $this->input->post('usuario', true),
											'Contraseña' => $this->input->post('pass', true),
											'Id_Rol' => 2,
											'Id_Pregunta' => $this->input->post('pregunta', true),
											'Respuesta' => $this->input->post('respuesta', true)));
	}*/
}
?>
