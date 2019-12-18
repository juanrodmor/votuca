<?php

include 'classes/MiembroElectoral.php';

class MesaElectoral extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Voto_model');
    $this->load->model('votaciones_model');
	$this->load->model('Usuario_model');
	$this->load->model('Mesa_model');
  }

	//Obtiene todas las votaciones de las que el usuario loggeado es miembro de mesa.
	private function obtenerVotaciones() {
		$votaciones = $this->Mesa_model->getVotaciones($this->Usuario_model->getId($this->session->userdata('usuario')));
		return $votaciones;
	}

  public function index($votos = array())
  {
  $verified = $this->session->userdata('verified');
  if(isset($verified) && $verified == true)
  {

      switch ($this->session->userdata('rol')) {
         case 'Administrador':
  		redirect('/Administrador_controller');
          break;
         case 'Elector':
          redirect('/Elector_controller');
          break;
         case 'Secretario':
          redirect('/Secretario');
          break;
          case 'MiembroElectoral':
          $inicio['inicio'] = '/MesaElectoral';
          $votaciones = $this->obtenerVotaciones();
  		$data = array_merge(array('votaciones'=> $votaciones), $votos);
            $this->load->view('MesaElectoral/MesaElectoral_view',$data);
            //$this->load->view('elementos/footer');
          break;

         case 'Secretario delegado':
          redirect('/secretario/delegado');
          break;
         default:
          redirect('/Login_controller');
          break;
      }

    }
    else{redirect('/Login_controller');}

  }

	private function abrirUrna($idVotacion) {
		$nuevaConfirmacion = false;
		if (!($this->Mesa_model->getQuiereAbrir($this->Usuario_model->getId($this->session->userdata('usuario')), $idVotacion))) {
			$this->Mesa_model->abreUrna($this->Usuario_model->getId($this->session->userdata('usuario')), $idVotacion);
			$this->monitoring->register_action_mElectoralConfirmed($this->session->userdata('usuario'), $this->votaciones_model->getVotacion($idVotacion));
			$nuevaConfirmacion = true;
		}
		$peticionesApertura = $this->Mesa_model->getNApertura($idVotacion);
		if ($nuevaConfirmacion && $peticionesApertura == 3) {
			$apertores = $this->Mesa_model->getNamesApertura($idVotacion);
			$this->monitoring->register_action_openBox($this->votaciones_model->getVotacion($idVotacion), $apertores);
			return true;
		} else if ($peticionesApertura >= 3) return true;
		else return false;
	}

	public function recuentoVotos(){
		if($this->input->post('boton_recuento')){
			$idVotacion = $this->input->post('recuento');
			if ($this->abrirUrna($idVotacion)) {	//Si hay al menos 3 miembros dispuesto a abrir la urna...
				/*
				if (!($this->Mesa_model->checkVotos($idVotacion))) {	//Si no se ha hecho aún el recuento...
					//$idVotos = $this->Mesa_model->getOptions($idVotacion);
					//$this->volcadoVotos($idVotacion, $idVotos);
				}
				*/
				$this->Voto_model->_usuarioVotacionToRecuento($idVotacion);			// Aqui te he puesto la funcion, borra este coment xD
				$datosVotacion = $this->Mesa_model->getFullVotoData($idVotacion);
				$this->index($datosVotacion);
				//$this->votosPerGroup($idVotacion);
			} else {	//Si no hay suficientes miembros dispuestos a abrir la urna...
				$mensajes = array('mensajeAperturaWait' => 'Aún no hay acuerdo entre los miembros de mesa para hacer recuento de la votación ' . $idVotacion . '.');
				$this->index($mensajes);
			}
		}
	}

	//Comprueba los votos existentes, elimina su registro y almacena el recuento.
	private function volcadoVotos($idVotacion, $idVotos) {
		array_push($idVotos, array('Num_Votos' => array()));
		for($it=0; $it<count($idVotos['Id']); $it++) {
			$idVotos['Num_Votos'][$it] = $this->Mesa_model->volcadoVotos($idVotacion, $idVotos['Id'][$it]);
		}
		$this->Mesa_model->insertVotos($idVotacion, $idVotos['Id'], $idVotos['Num_Votos']);
	}

	//Finaliza la votación cuando suficientes miembros lo confirmen.
	public function finalizaVotacion() {
		if($this->input->post('boton_finalizar') && !($this->Mesa_model->isFinished($this->input->post('idVotacion')))) {	//Acceso correcto
			$idVotacion = $this->input->post('idVotacion');
			if($this->cerrarUrna($idVotacion)) {	//Hay votos suficientes para cerrarla.
				if($this->input->post('invalida') == true) {	//No se cumple el quorum
					$this->Mesa_model->setInvalida($idVotacion);
					$this->monitoring->register_action_closeBoxInvalid($this->votaciones_model->getVotacion($idVotacion));
					$mensajes = array('mensajeVotacionInvalida' => 'Votación invalidada. No se cumple el Quorum.');
					$this->index($mensajes);
				} else {	//Se cumple el quorum
					$this->Mesa_model->setFinalizada($idVotacion);
					$cierran = $this->Mesa_model->getNamesCierre($idVotacion);
					$this->monitoring->register_action_closeBox($this->votaciones_model->getVotacion($idVotacion), $cierran);
					$mensajes = array('mensajeVotacionOK' => '¡Votación finalizada con éxito!');
					$this->index($mensajes);
				}
			} else {	//No hay votos suficientes para cerrarla.
				$mensajes = array('mensajeCierreWait' => 'Es necesaria la contribución de más miembros para cerrar la votación.');
				$this->index($mensajes);
			}
		} else {	//Acceso ilegal
			$this->index();
		}
	}

	//Añade confirmación de cierre de urna y hace recuento de confirmaciones.
	private function cerrarUrna($idVotacion) {
		$nuevaConfirmacion = false;
		if (!($this->Mesa_model->getQuiereCerrar($this->Usuario_model->getId($this->session->userdata('usuario')), $idVotacion))) {
			$this->Mesa_model->cierraUrna($this->Usuario_model->getId($this->session->userdata('usuario')), $idVotacion);
			$this->monitoring->register_action_mElectoralConfirmedClose($this->session->userdata('usuario'), $this->votaciones_model->getVotacion($idVotacion));
			$nuevaConfirmacion = true;
		}
		$peticionesCierre = $this->Mesa_model->getNCierre($idVotacion);
		return ($nuevaConfirmacion && $peticionesCierre == 3);
	}

}



?>