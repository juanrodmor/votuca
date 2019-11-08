<?php
error_reporting(E_ALL ^ E_DEPRECATED);

class Login_controller extends CI_Controller {
	//El controlador trabaja con el modelo de Usuario.
	public function __construct() {
		parent::__construct();
		$this->load->model('Usuario_model');
	}
	
	//Por defecto carga la vista de login.
	public function index() {
		$this->load->view('Login_view');
	}
	
	//Función auxiliar de encriptación de contraseñas.
	public function encriptar($pass) {
		return password_hash($pass, PASSWORD_DEFAULT);
	}
	
	//Función de verificación de los datos introducidos en el login.
	public function verificar() {
		if ($this->input->post('Enviar')) {		//Si se accede mediante envío de datos y no por URL...
			$this->form_validation->set_rules('usuario', 'username', 'required|trim');
			$this->form_validation->set_rules('pass', 'pass', 'required|trim');
			$this->form_validation->set_message('required', 'El campo %s es obligatorio.');
			
			if ($this->form_validation->run() != false) {	//Si se cumplen las reglas de validación...
				if ($this->Usuario_model->userExists($this->input->post('usuario'))	//Si existe el usuario y coincide la pass...
					&& password_verify($this->input->post('pass'), $this->Usuario_model->getPass($this->input->post('usuario')))) {
					$this->session->set_userdata(array('usuario' => $this->input->post('usuario')));
					$this->load->view('Principal_view');
				} else {	//Si no existe el usuario o la pass no coincide...
					$data = array('mensaje' => 'La combinación usuario/contraseña introducida no es válida.');
					$this->load->view('Login_view', $data);
				}
			} else {	//Si no se cumplen las reglas de validación...
				$this->load->view('Login_view');
			}
		} else $this->load->view('Login_view');		//Si se accede de forma ilegal (no por envío de formulario)...
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