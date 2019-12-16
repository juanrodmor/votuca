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
	public function setUserObject($username, $password, $id_rol, $id_grupo, $email)
	{
		$data = array(
			'Id_Rol' => $id_rol,
			'Id_Grupo' => $id_grupo,
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
		$usr = substr($usuario, 1);
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
	
	public function getGrupo($usuario)
	{		
		$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $usuario));
		return $consulta->row()->Id_Grupo;
	}
	
	public function setAuth($usuario, $auth)
	{
		$this->db->set('Auth', $auth);	
		$this->db->where('NombreUsuario', $usuario);	
		$this->db->update('usuario');
		
		$data = array(
			'auth_key' => $auth,
			'first_time' => 1,
			'attemps' => 0
		);
		
		$this->db->insert('autorizacion', $data);
		
	}
	
	public function getAuth($usuario)
	{
		//$consulta = $this->db->get_where('usuario', array('Id' => $usuario->getId()));
		$this->db->select('Auth');
		$this->db->from('usuario');
		$this->db->where('NombreUsuario', $usuario);
		$result = $this->db->get()->result_array();
		
		if($result[0]['Auth'] == "")
			return null;
		else
			return $result[0]['Auth'];
		
	}
	
	public function setIP($usuario, $ip)
	{
		echo $ip;
		echo $usuario;
		$this->db->set('IP', $ip);	
		$this->db->where('NombreUsuario', $usuario);		
		$this->db->update('usuario');
	}
	
	public function getIP($usuario)
	{
		$this->db->select('IP');
		$this->db->from('usuario');
		$this->db->where('NombreUsuario', $usuario);
		$result = $this->db->get()->result_array();
		
		if($result[0]['IP'] == "")
			return null;
		else
			return $result[0]['IP'];
	}
	
	public function is_first_auth()
	{
		$usuario = $this->session->userdata('usuario');
		
		$auth = $this->getAuth($usuario);
		$this->db->select('first_time');
		$this->db->from('autorizacion');
		$this->db->where('auth_key', $auth);
		$result = $this->db->get()->result_array();
		
		if(!empty($result))
			return $result[0]['first_time'];
		else
			false;
	}
	
	public function notFirstAuth()
	{
		$usuario = $this->session->userdata('usuario');
		
		$auth = $this->getAuth($usuario);
		$this->db->set('first_time', false);	
		$this->db->where('auth_key', $auth);		
		$this->db->update('autorizacion');
	}
	
	public function resetAttemps()
	{
		$usuario = $this->session->userdata('usuario');
		
		$auth = $this->getAuth($usuario);
		$this->db->set('attemps', 0);	
		$this->db->where('auth_key', $auth);		
		$this->db->update('autorizacion');		
	}
	
	public function incrementAttemps()
	{
		$usuario = $this->session->userdata('usuario');
		
		$auth = $this->getAuth($usuario);
		$this->db->set('attemps', 'attemps+1', false);	
		$this->db->where('auth_key', $auth);		
		$this->db->update('autorizacion');	
		$consulta = $this->db->get_where('autorizacion', array('auth_key' => $auth));
		$intentos = $consulta->row()->attemps;
		
		if($intentos > 3)
		{
			$this->db->set('blocked', true);
			$this->db->where('auth_key', $auth);
			$this->db->update('autorizacion');
			return "attemps_limit";
		}
	}
	
	public function blockedAuth()
	{
		$usuario = $this->session->userdata('usuario');
		
		$auth = $this->getAuth($usuario);
		$this->db->select('blocked');
		$this->db->from('autorizacion');
		$this->db->where('auth_key', $auth);
		$result = $this->db->get()->result_array();
		
		if(!empty($result))
			return $result[0]['blocked'];
		else
			return false;
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
	public function insertUserAs($idUser, $idRol, $letraRol)
	{
		//echo '<br>ANALIZANDO USUARIO CON ID: '.$idUser.'<br>';
		$usuario = $this->getUsuario($idUser);
		//echo var_dump(substr($usuario[0]->NombreUsuario,1));
    $nuevo = array(
			'Id_Rol' => $idRol,
			'NombreUsuario' => $letraRol.substr($usuario[0]->NombreUsuario,1),
			'Password' => $usuario[0]->Password
		);
	 // ASEGURARSE QUE ESTE USUARIO NO TENGA YA ESTE ROL (cuenta m+DNI)
		$usuarioElectoral = $letraRol.substr($usuario[0]->NombreUsuario,1);
		$existe = $this->userExists($usuarioElectoral);
		if(!$existe){$this->db->insert('usuario',$nuevo);}
		
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