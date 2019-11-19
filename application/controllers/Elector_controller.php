<?php
error_reporting(E_ALL ^ E_DEPRECATED);

class Elector_controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Voto_model');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
	}

	public function index() {
		if ($this->session->userdata('rol') != 'Elector') {
			redirect('/Login_controller');
	    }
	    else {
				$titulo['titulo'] = 'MIS VOTACIONES';
				$inicio['inicio'] = 'Elector_controller/';
				$this->load->view('elementos/head',$titulo);
				$this->load->view('elementos/headerComun',$inicio);
	    	$id_user = $this->Voto_model->_userId($_SESSION['usuario']);
	        $datos = $this->Voto_model->_listar($id_user);
	        $votos = array(
	        	'datos' => $datos
	        );
			$this->load->view('Elector/votacion_view', $votos);
			$this->load->view('elementos/footer');
	    }

    }

    public function votar($id_votacion) {
			$title['titulo'] = 'MIS VOTACIONES';
			$inicio['inicio'] = 'Elector_controller/';
			$this->load->view('elementos/head',$title);
			$this->load->view('elementos/headerComun',$inicio);
    	$id_usuario = $this->Voto_model->_userId($_SESSION['usuario']);
    	$votos = $this->Voto_model->_votosDisponibles();	// habrá que pasarle $id_votacion para mostrar los votos disponibles para esa votacion
    	$datos = array(
    		'id_votacion' => $id_votacion,
    		'id_usuario' => $id_usuario,
    		'votos' => $votos
    	);
    	$this->load->view('Elector/voto_view', $datos);
			$this->load->view('elementos/footer');

    }

    public function guardarVoto($id_votacion) {

    	$this->form_validation->set_rules('voto', 'Voto', 'required');
    	$this->form_validation->set_message('required','Seleccione un voto valido');

    	if($this->form_validation->run() == TRUE) {
	        $voto = $_POST['voto'];
	    	//$voto = $this->input->post('voto');
	    	$id_usuario = $this->Voto_model->_userId($_SESSION['usuario']);

	    	$this->Voto_model->_votar($id_usuario, $id_votacion, $voto);
	    	$this->index();
	    } else {
	    	$votos = $this->Voto_model->_votosDisponibles();
	    	$id_usuario = $this->Voto_model->_userId($_SESSION['usuario']);
	    	$datos = array(
    		'id_votacion' => $id_votacion,
    		'id_usuario' => $id_usuario,
    		'votos' => $votos
    	);
		    	$title['titulo'] = 'MIS VOTACIONES';
				$inicio['inicio'] = 'Elector_controller/';
				$this->load->view('elementos/head',$title);
				$this->load->view('elementos/headerComun',$inicio);
	        $this->load->view('Elector/voto_view', $datos);
	        	$this->load->view('elementos/footer');
	    }
    }


    public function verResultados($id_votacion, $titulo) {
			$title['titulo'] = 'MIS VOTACIONES';
			$inicio['inicio'] = 'Elector_controller/';
			$this->load->view('elementos/head',$title);
			$this->load->view('elementos/headerComun',$inicio);
    	$datos = $this->Voto_model->recuentoVotos($id_votacion);
    	$total = sizeof($datos);
    	$recVotos = $this->Voto_model->tiposVotos($datos);

    	$datos = array(
    		'total' => $total,
    		'titulo' => $titulo,
    		'votos' => $recVotos
    	);
    	$this->load->view('Elector/resultados_view', $datos);
			$this->load->view('elementos/footer');
    }

}
