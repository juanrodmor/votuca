<?php
error_reporting(E_ALL ^ E_DEPRECATED);

class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Usuario_model');
	}
	
	public function index() {
		$this->load->view('Login_view');
	}
	
	public function encriptar($pass) {
		return password_hash($pass, PASSWORD_DEFAULT);
	}
	
	public function verificar() {
		if ($this->input->post('Enviar')) {
			$cryptpass = encriptar($this->input->post('pass'));
			if ($this->Usuario_model->verificar($cryptpass) == true) {
				$this->session->set_userdata(array('usuario' => $this->input->post('usuario')));
				$this->load->view('Principal_view');
			} else {
				$data = array('mensaje' => 'La combinación usuario/contraseña introducida no es válida.');
				$this->load->view('Login_view', $data);
			}
		} else $this->load->view('Login_view');
	}
	
	//Funciones de registro
	/*
	public function registro() {
		$this->load->view('Registro_view');
	}
	
	public function verifica_registro() {
		if ($this->input->post('Enviar')) {
			$this->form_validation->set_rules();
			$this->form_validation->set_rules();
			$this->form_validation->set_rules();
			$this->form_validation->set_rules();
			$this->form_validation->set_rules();
			
			if ($this->form_validation->run() == false)
				$this->registro();
			else {
				$this->Usuario_model->Añadirusuario();
				$this->load->view('Login_view');
			}
		} else $this->load->view('Registro_view');
	}
	*/
}

?>