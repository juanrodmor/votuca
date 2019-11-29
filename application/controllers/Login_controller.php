<?php
error_reporting(E_ALL ^ E_DEPRECATED);

class Login_controller extends CI_Controller {
	//El controlador trabaja con el modelo de Usuario.
	public function __construct() {
		parent::__construct();
		$this->load->model('Usuario_model');
		$this->load->model('votaciones_model');
		include $_SERVER['DOCUMENT_ROOT'] . '/votuca/classes/Usuario.php';
	}


	public function redireccionar(){
		switch($this->session->userdata('rol'))
		{
			case 'Elector':
				redirect('/Elector_controller');
				break;
			case 'Secretario':
				redirect('/Secretario');
				break;
			case 'SecretarioDelegado':
				redirect('/Secretario/delegado');
				break;
			case 'MiembroElectoral':
				redirect('/MesaElectoral');
				break;
			case 'Administrador':
				redirect('/Administrador_controller');
				break;
			case 'Temporal':
				$this->load->view('Contrasenia_view');
				break;
			default:
				$loggeado = $this->session->userdata('usuario');
				if (isset($loggeado)) {	//Si estaba loggeado...
					session_destroy();
					$data = array('mensaje' => 'Se produjo un error con la información de usuario. Si continua sucediendo, contacte con el administrador.');
					$this->load->view('login_view', $data);
				} else {	//Si no...
					redirect('/Login_controller');
				}
				break;
		}
	}
	//Por defecto carga la vista de login.
	public function index() {
		$loggeado = $this->session->userdata('usuario');
		if (isset($loggeado)) {	//Si estaba loggeado...
			$this->redireccionar();
		} else {	//Si no...
			$this->load->view('login_view');
		}
	}

	/*
	//Función auxiliar de encriptación de contraseñas.
	private function encriptar($pass) {
		return password_hash($pass, PASSWORD_DEFAULT);
	}
	*/

	//Función de verificación de los datos introducidos en el login.
	public function verificar() {
		if ($this->input->post('Enviar')) {		//Si se accede mediante envío de datos y no por URL...
			$this->form_validation->set_rules('usuario', 'Nombre de usuario', 'required|trim');
			$this->form_validation->set_rules('pass', 'Contraseña', 'required|trim');
			$this->form_validation->set_message('required', 'El campo \'%s\' es obligatorio.');

			if ($this->form_validation->run() != false) {	//Si se cumplen las reglas de validación...
				$usuario = new Usuario($this->input->post('usuario'), $this->input->post('pass'));
				
				if ($this->Usuario_model->userExists($usuario->getId())	//Si existe el usuario y coincide la pass...
					&& password_verify($usuario->getPass(), $this->Usuario_model->getPass($usuario->getId()))) {
					
					$this->loginOK($usuario);
					
				} else {	//Si no existe el usuario o la pass no coincide...
					$this->monitoring->register_action_login($this->input->post('usuario'));	//Almacena la info del login en un log.
					$data = array('mensaje' => 'La combinación usuario/contraseña introducida no es válida.');
					$this->load->view('login_view', $data);
				}
			} else {	//Si no se cumplen las reglas de validación...
				$this->load->view('login_view');
			}
		} else $this->load->view('login_view');		//Si se accede de forma ilegal (no por envío de formulario)...
	}
	
	//Comprueba si el periodo del usuario ha expirado.
	private function caduca($idUsuario) {
		$fecha = $this->Usuario_model->getFecha($idUsuario);
		if ($fecha <= date('Y-m-d H:i:s')) return 'CADUCA';
		else return 'EXPIRA';
	}
	
	//Comprueba si el usuario está en periodo de expiración.
	private function expira($usuario) {
		$idUsuario = $this->Usuario_model->getId($usuario->getId());
		if ($this->Usuario_model->checkExpira($idUsuario) == true) $this->caduca($idUsuario);
		else return 'NO';
	}
	
	//Gestiona un login exitoso.
	private function loginOK($usuario) {
		$estado = $this->expira($usuario);
		switch($estado) {
			case 'NO': 
				$this->session->set_userdata(array('usuario' => $usuario->getId(), 'rol' => $this->Usuario_model->getRol($usuario->getId())));
				$this->monitoring->register_action_login($this->session->userdata('usuario'), 'success');	//Almacena la info del login exitoso en un log.
				//$this->evaluaRol();	//Para multirol
				$this->redireccionar();
				break;
			case 'EXPIRA': 
				$this->session->set_userdata(array('usuario' => $usuario->getId(), 'rol' => 'Temporal'));
				$this->monitoring->register_action_login($this->session->userdata('usuario'), 'success');
				$this->redireccionar();
				break;
			case 'CADUCA': 
				$this->monitoring->register_action_login($usuario->getId(), 'blocked');
				$this->Usuario_model->deleteUsuario($usuario->getId());
				$this->monitoring->register_action_deleteUsuario($usuario->getId());
				$data = array('mensaje' => 'El usuario con el que intenta acceder ya no tiene permisos en el sistema.');
				$this->load->view('login_view', $data);
				break;
		}
	}

	/*	PARA MULTIROL
	//Evalúa los permisos del usuario loggeado.
	public function evaluaRol() {
		$roles = $this->session->userdata('rol');
		if (count($roles) == 1) {
			$this->session->set_userdata('rol', 'Elector');
			$this->redireccionar();
		} else {
			$data = array('roles' => $roles);
			$this->load->view('loginSeleccionRol_view', $data);
		}
	}

	//Elección de rol por parte del usuario.
	public function seleccionRol() {
		if ($this->input->post('radio') != NULL) {
			$this->session->set_userdata('rol', $this->input->post('radio'));
			$this->redireccionar();
		} else $this->evaluaRol();
	}
	*/

	//Función para desconectarse de la web.
	public function logout() {
		$loggeado = $this->session->userdata('usuario');
		if (isset($loggeado)) {	//Si estaba loggeado...
			$this->monitoring->register_action_logout($this->session->userdata('usuario'));	//Almacena la info del logout en un log.
			$this->session->unset_userdata(array('usuario', 'rol'));
			session_destroy();
			$data = array('mensaje' => 'La sesión se ha cerrado con éxito.');
			$this->load->view('login_view', $data);
		} else {	//Si no...
			$this->load->view('login_view');
		}
	}

	/***********************************/
	/***********************************/
	/***********************************/

	public function crearPassword($pass)
	{
		echo password_hash($pass, PASSWORD_DEFAULT);
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
