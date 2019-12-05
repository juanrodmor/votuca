<?php

include 'classes/Administrador.php';

class Administrador_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Usuario_model');
		$this->load->model('Votaciones_model');
		$this->load->helper('date');
		$this->load->library('mailing');
	}

	public function index() {
		switch ($this->session->userdata('rol')) {
			case 'Administrador':
				$this->monitoring();
				//$this->load->view('administracion/administracion_view');
				//$this->load->view('administracion/administracionMonitoring_view');
				//$this->load->view('elementos/footer');
				break;
			case 'Elector':
				redirect('Elector_controller');
				break;
			case 'Secretario':
				redirect('Secretario');
				break;
			case 'Secretario delegado':
				redirect('Secretario_delegado');
				break;
			default:
				redirect('/Login_controller');
				break;
		}
	}

	private function logs() {
		$datename = mdate("%Y%m%d");
		$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/votuca/application/logs/' . $datename .'.txt', "r");
		return $file;
	}

	public function monitoring() {
		$file = $this->logs();
		$logarray = array();
		if ($this->input->post('Filtrar')) {
			$login = $this->input->post('cLogin'); if($login === 'true'){$login = true;} else{$login = false;}
			$logout = $this->input->post('cLogout'); if($logout === 'true'){$logout = true;} else{$logout = false;}
			$vote = $this->input->post('cVote'); if($vote === 'true'){$vote = true;} else{$vote = false;}
			$included = false;
			while (($line = fgets($file)) !== false) {
				if ($login === true && strpos($line, '[LOGIN]') !== false) {
					array_push($logarray, $line);
					$included = true;
				}
				if ($included == false && $logout === true && strpos($line, '[LOGOUT]') !== false) {
					array_push($logarray, $line);
					$included = true;
				}
				if ($included == false && $vote === true && strpos($line, '[VOTE]') !== false) {
					array_push($logarray, $line);
					$included = true;
				}
				$included = false;
			}
		} else
		{
			while (($line = fgets($file)) !== false)
			{
				array_push($logarray, $line);
			}
		}
		$data = array('loginfo' => $logarray);
		$this->load->view('administracion/administracionMonitoring_view', $data);
	}

	public function buscador() {
		if ($this->input->post('Buscar')) {
			$usuario = $this->input->post('usuario');
			if ($this->Usuario_model->userExists($usuario)) {
				$roles = array();
				foreach ($this->Usuario_model->getAllRoles($usuario) as $rol)
					array_push($roles, $rol['Nombre']);
				$data = array(
					'usuario' => $usuario,
					'rol' => $roles
				);
				
			} else {
				$data = array('mensaje' => 'No hay ningún usuario con ese identificador.');
			}
			$this->load->view('administracion/administracion_view', $data);
		}
	}


	public function nuevoRol()
	{
		if($this->input->post('checkBoxInput'))
		{
			$roles = $this->Usuario_model->getRoles();
			$newrol = $this->input->post('checkBoxInput');

			if(in_array($newrol, $roles))
			{
				$usuario = $this->input->post('usuario');
				$oldrol = $this->Usuario_model->getRol($usuario);
				if($this->Usuario_model->userExists($usuario))
				{
					$newUsername = $usuario;
					foreach($roles as $rol)
					{
						if($rol == $newrol)
						{
							$newUsername[0] = strtolower($rol[0]);
						}
					}

					if($this->Usuario_model->userExists($newUsername))
					{
						$data = array('mensaje_failure' => 'Intenta conceder permisos a un usuario que ya los tiene. Por favor, revise su acción.');
						$this->load->view('administracion/administracion_view', $data);		
					}
					else
					{
						$this->Usuario_model->setUserObject($newUsername, $this->Usuario_model->getPass($usuario), $this->Usuario_model->getRolId($newrol), $this->Usuario_model->getEmail($usuario));
						$this->Usuario_model->setUserTimeLimit($newUsername);
						//$newIdUser = $this->Usuario_model->getId($newUsername);

						$asunto = '[NOTIFICACIÓN VOTUCA] Nuevo rol.';
						$mensaje = '<h1>Tienes un nuevo rol en VotUCA</h1>
						
						<p>Has sido designado como ' . $newrol . ' en la plataforma. Por ello, <b>dispondrás de una nueva cuenta únicamente para ejercer dicho rol.</b></p>
						<p>El usuario generado para acceder a tu cuenta con privilegios es el siguiente: ' . $newUsername . '. <b>Podrás acceder usando tu contraseña actual. Una vez accedas al sistema, deberás establecer tu propia contraseña antes de 24 horas.</b><p>
						<br><br><br>
						
						<p>Coordialmente, la administración de VotUCA.</p>
						';
						
						$result = $this->mailing->sendEmail($newUsername, $asunto, $mensaje);
						$data = array('mensaje_success' => 'Se ha actualizado el rol de ' . $usuario . ', que pasa de ser ' . $oldrol . ' a ser ' . $newrol . '.');						
						
						if($result == 'success')
						{
							$data['mensaje_success'] .= ' Dicho usuario ha sido notificado por correo.';
						}
						else
						{
							$data['mensaje_failure'] = 'La notificación por correo ha fallado.';						
						}
						
						if ($newUsername[0] == 's' || $newUsername[0] == 'm') {	//Si el nuevo rol es secretario delegado o miembro electoral
							$votaciones = $this->Votaciones_model->recuperarVotaciones();
							$idVotaciones = array();
							$tituloVotaciones = array();
							foreach($votaciones as $votacion) {
								array_push($idVotaciones, $votacion->Id);
								array_push($tituloVotaciones, $votacion->Titulo);
							}
							$data['Id_Votacion'] = $idVotaciones;
							$data['Titulo'] = $tituloVotaciones;
							$data['Id_Usuario'] = $this->Usuario_model->getId($newUsername);
							$this->load->view('administracion/administracion_assignRol_view', $data);
						}
						else
						{
							$this->load->view('administracion/administracion_view', $data);	
						}

					}

				}
				else
				{
					$data = array('mensaje_failure' => 'Intenta conceder permisos a un usuario inexistente. Por favor, revise su acción.');
					$this->load->view('administracion/administracion_view', $data);						
				}
			}
			else
			{
				$data = array('mensaje_failure' => 'Se ha intentado modificar el rol de forma ilegal. Por favor, seleccione uno de los valores mostrados.');
				$this->load->view('administracion/administracion_view', $data);				
			}

		}
	}
	
	//Asigna al nuevo rol las votaciones indicadas.
	public function asignaVotaciones() {
		if($this->input->post('Enviar')) {
			$idUsuario = $this->input->post('usuario');
			//¿Que recibo? ¿Como recorro las opciones?
			//Insertar en la tabla correspondiente dichas votaciones.
			$data = array('mensaje' => 'Se han asignado con éxito las votaciones seleccionadas al usuario.');
			$this->load->view('administracion/administracion_view', $data);
		} else {
			$this->index();
		}
	}

/**
	public function nuevoRol() {
		$this->load->view('elementos/headerAdmin');
		if ($this->input->post('checkBoxInput')) {
			$usuario = $this->input->post('usuario');
			$oldrol = $this->Usuario_model->getRol($usuario);
			$newrol = $this->input->post('checkBoxInput');
			$roles = $this->Usuario_model->getRoles();
			$valido = false;
			foreach ($roles as &$rol) {
				if ($valido == false && $rol == $newrol) $valido = true;
			}
			if ($valido == true) {
				$this->Usuario_model->setRol($usuario, $newrol);
				$data = array('mensaje_success' => 'Se ha actualizado el rol de ' . $usuario . ', que pasa de ser ' . $oldrol . ' a ser ' . $newrol . '.');
				$this->load->view('administracion/administracion_view', $data);
			} else {
				$data = array('mensaje_failure' => 'Se ha intentado modificar el rol de forma ilegal. Por favor, seleccione uno de los valores mostrados.');
				$this->load->view('administracion/administracion_view', $data);
			}
		}
	}
*/
	/*********************************/
	/**********************************/
	/**********************************/

	public function gestionusuarios(){
		$this->load->view('administracion/administracion_view');
		//$this->load->view('elementos/footer');
	}
}

?>
