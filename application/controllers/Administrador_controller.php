<?php

include 'classes/Administrador.php';

class Administrador_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Usuario_model');
        $this->load->helper('date');
	}

	public function index() {
		switch ($this->session->userdata('rol')) {
			case 'Administrador':
				$this->load->view('administracion/administracion_view');
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
				$data = array(
					'usuario' => $usuario,
					'rol' => $this->Usuario_model->getRol($usuario)
				);
			} else {
				$data = array('mensaje' => 'No hay ningún usuario con ese identificador.');
			}
			$this->load->view('administracion/administracion_view', $data);
		}
	}

	public function nuevoRol() {
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
}

?>
