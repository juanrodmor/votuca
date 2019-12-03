<?php

include 'classes/MiembroElectoral.php';

class MesaElectoral extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('voto_model');
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
        $this->load->view('elementos/headerComun',$inicio);
        $votaciones = $this->obtenerVotaciones();
		$data = array_merge(array('votaciones'=> $votaciones), $votos);
          $this->load->view('MesaElectoral/MesaElectoral_view',$data);
          $this->load->view('elementos/footer');
        break;

       case 'Secretario delegado':
        redirect('/secretario/delegado');
        break;
       default:
        redirect('/Login_controller');
        break;
    }


  }

	private function abrirUrna($idVotacion) {
		$this->Mesa_model->abreUrna($this->Usuario_model->getId($this->session->userdata('usuario')), $idVotacion);
		$peticionesApertura = $this->Mesa_model->getNApertura($idVotacion);
		return ($peticionesApertura >= 3);
	}

	public function recuentoVotos(){
		if($this->input->post('boton_recuento')){
			$idVotacion = $this->input->post('recuento');
			if ($this->abrirUrna($idVotacion)) {	//Si hay al menos 3 miembros dispuesto a abrir la urna...
				if (!($this->Mesa_model->checkVotos($idVotacion))) {	//Si no se ha hecho aún el recuento...
					$idVotos = $this->Mesa_model->getOptions($idVotacion);
					$this->volcadoVotos($idVotacion, $idVotos);
				}
				$datosVotacion = $this->Mesa_model->getFullVotoData($idVotacion);
				$this->index($datosVotacion);
				//$this->votosPerGroup($idVotacion);
			} else {	//Si no hay suficientes miembros dispuestos a abrir la urna...
				$mensajes = array('mensaje' => 'Aún no hay acuerdo entre los miembros de mesa para hacer recuento de la votación ' . $idVotacion . '.');
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
		if($this->input->post('boton_finalizar')) {	//Acceso correcto
			$idVotacion = $this->input->post('idVotacion');
			if($this->cerrarUrna($idVotacion)) {	//Hay votos suficientes para cerrarla.
				if($this->input->post('invalida') == true) {	//No se cumple el quorum
					$this->Mesa_model->setInvalida($idVotacion);
					$mensajes = array('mensaje' => 'Votación invalidada. No se cumple el Quorum.');
					$this->index($mensajes);
				} else {	//Se cumple el quorum
					$this->Mesa_model->setFinalizada($idVotacion);
					$mensajes = array('success' => '¡Votación finalizada con éxito!');
					$this->index($mensajes);
				}
			} else {	//No hay votos suficientes para cerrarla.
				$mensajes = array('mensaje' => 'Es necesaria la contribución de más miembros para cerrar la votación.');
				$this->index($mensajes);
			}	
		} else {	//Acceso ilegal
			$this->index();
		}
	}
	
	//Añade confirmación de cierre de urna y hace recuento de confirmaciones.
	private function cerrarUrna($idVotacion) {
		$this->Mesa_model->cierraUrna($this->Usuario_model->getId($this->session->userdata('usuario')), $idVotacion);
		$peticionesCierre = $this->Mesa_model->getNCierre($idVotacion);
		return ($peticionesCierre >= 3);
	}

}



?>
