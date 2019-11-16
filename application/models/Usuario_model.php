<?php

class Usuario_model extends CI_Model {
	//Nos aseguramos que cargue la base de datos.
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	//Devuelve la contraseña de un usuario específico.
	public function getPass($usuario) {
		$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $usuario));
		return $consulta->row()->Password;
	}

	//Comprueba si el usuario recibido existe en la base de datos.
	public function userExists($usuario) {
		$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $usuario));
		return ($consulta->num_rows() == 1);
	}

	//Devuelve el rol de un usuario específico.
	public function getRol($usuario) {
		$consulta = $this->db->get_where('usuario', array('NombreUsuario' => $usuario));
		$consulta2 = $this->db->get_where('rol', array('Id' => $consulta->row()->Id_Rol));
		return $consulta2->row()->Nombre;
	}

	/*****************************/
	/******* FUNCIONES INMA ******/
	/*****************************/
	public function recuperarTodos()
	{
		$query = $this->db->query("SELECT  * from usuario;");
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
