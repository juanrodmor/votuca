<?php

class Usuario_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function getPass($usuario) {
		$this->db->select('pass');
		$this->db->where(array('usuario' => $usuario));
		return $this->db->get('usuarios');
		/*$consulta = $this->db->get_where('usuarios', array('usuario' => $usuario));
		return $consulta->result()->pass;*/
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