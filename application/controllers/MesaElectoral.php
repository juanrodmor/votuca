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
		$arrayVotaciones = array();
		foreach($votaciones as $row) {	//$row es un objeto mesa_electoral
			array_push($arrayVotaciones, $this->votaciones_model->getVotacion($row->Id_Votacion));	//$arrayVotaciones es un array de objetos votacion
		}
		return $arrayVotaciones;
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
			if ($this->abrirUrna($idVotacion)) {
				$nVotos = $this->voto_model->recuentoVotosElectoral($idVotacion);
				$maxVotantes = 500;	//MODIFICAR CUANDO SE SEPA CENSO
				$votos = $this->voto_model->recuentoVotos($idVotacion);
				$votosSi = 0; $votosNo = 0; $votosBlanco = 0;
				if ($nVotos != 0) {
					foreach($votos as $voto) {
						switch ($voto->Id_Voto) {
							case 2:
								$votosSi++; break;
							case 3:
								$votosNo++; break;
							case 4:
								$votosBlanco++; break;
						}
					}
				}
				$datosVotacion = array(
				'total' => $nVotos,
				'si' => $votosSi,
				'no' => $votosNo,
				'blanco' => $votosBlanco,
				'censo' => $maxVotantes,
				'votacion' => $idVotacion
				);

				//$this->votosPerGroup($idVotacion);
				$this->index($datosVotacion);
			} else {
				$mensajes = array('mensaje' => 'Aún no hay acuerdo entre los miembros de mesa para hacer recuento de la votación ' . $idVotacion . '.');
				$this->index($mensajes);
			}
		}
	}

}



?>
