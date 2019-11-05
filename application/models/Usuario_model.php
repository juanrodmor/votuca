<?php

class Usuario_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function verificar($user) {
		$consulta = $this->db->get_where('usuario', array('usuario' => $user));
		if ($consulta->num_rows() == 0)
			return false;
		else
			return true;
	}
	
	public function verify_login() {
		$consulta = $this->db->get_where('usuario', array('Usuario' => $this->input->post('usuario', true), 'Contraseña' => $this->input->post('contraseña', true)));
		if ($consulta->num_rows() == 1)
			return true;
		else
			return false;
	}
	
	public function add_usuario() {
		$this->db->insert('usuario', array('Nombre' => $this->input->post(									    'nombre', true),
											'Correo' => $this->input->post('correo', true),
											'Usuario' => $this->input->post('usuario', true),
											'Contraseña' => $this->input->post('pass', true),
											'Id_Rol' => 2,
											'Id_Pregunta' => $this->input->post(
											  'pregunta', true),
											'Respuesta' => $this->input->post(
											  'respuesta', true)));
	}
}
?>