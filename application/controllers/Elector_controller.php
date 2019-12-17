<?php
error_reporting(E_ALL ^ E_DEPRECATED);

class Elector_controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Voto_model');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
	}

	public function index($mensaje = FALSE) {
		if ($this->session->userdata('rol') != 'Elector') {
			redirect('/Login_controller');
	    }
	    else {
	    	//$this->Voto_model->_actualizarFechasVotaciones();		// esto lo hacen los miembros de la mesa electoral para abrir las urnas
				$titulo['titulo'] = 'MIS VOTACIONES';
				$inicio['inicio'] = 'Elector_controller/';
				$this->load->view('elementos/head',$titulo);
					//$this->load->view('elementos/headerComun',$inicio);
				$this->load->view('elementos/headerVotacion',$inicio);
	    	$id_user = $this->Voto_model->_userId($_SESSION['usuario']);
	        $datos = $this->Voto_model->_listar($id_user);
        	$votos = array(
	        	'datos' => $datos,
	        	'mensaje' => $mensaje
	        );
			$this->load->view('Elector/votacion_view', $votos);
			//$this->load->view('elementos/footer');
	    }

    }


// -----------------------------------------------------------------------------------------------------------------------------



    public function votar() {
    	if(!isset($_POST['id_votacion']) OR !isset($_POST['titulo'])  OR !isset($_POST['descrip']) OR !isset($_POST['fch']) OR !isset($_POST['modif']) OR !isset($_POST['opc']) ){
    		$mensaje = "Acceda debidamente a la opción de votar, por favor.";
    		$this->index($mensaje);
    	}
    	else {
			$id_votacion = $_POST['id_votacion'];
			$titulo = $_POST['titulo'];
			$descrip = $_POST['descrip'];
			$fch = $_POST['fch'];
			$modif = $_POST['modif'];
			$opc = $_POST['opc'];

				$title['titulo'] = 'MIS VOTACIONES';
				$inicio['inicio'] = 'Elector_controller/';
				$this->load->view('elementos/head',$title);
				//$this->load->view('elementos/headerComun',$inicio);
				$this->load->view('elementos/headerVotacion',$inicio);
			$id_usuario = $this->Voto_model->_userId($_SESSION['usuario']);
			$votos = $this->Voto_model->_votosDisponibles($id_votacion);
			$datos = array(
				'id_votacion' => $id_votacion,
				'id_usuario' => $id_usuario,
				'descrip' => $descrip,
				'titulo' => $titulo,
				'fch' => $fch,
				'modif' => $modif,
				'opc' => $opc,
				'votos' => $votos
			);
			$this->load->view('Elector/voto_view', $datos);
			//$this->load->view('elementos/footer');	// arreglar footer
		}

    }

    public function guardarVoto() {

    	if(!isset($_POST['id_votacion']) OR !isset($_POST['titulo'])  OR !isset($_POST['descrip']) OR !isset($_POST['fch']) OR !isset($_POST['modif']) OR !isset($_POST['opc']) ){
    		$mensaje = "Acceda debidamente a la opción de votar para poder guardar un voto, por favor.";
    		$this->index($mensaje);
    	}
    	else {
	    	$id_votacion = $_POST['id_votacion'];
	    	$titulo = $_POST['titulo'];
			$descrip = $_POST['descrip'];
			$fch = $_POST['fch'];
			$modif = $_POST['modif'];
			$opc = $_POST['opc'];

			if($opc == 1) {	// votacion simple
				$this->form_validation->set_rules('voto', 'Voto', 'required');
    			$this->form_validation->set_message('required','Seleccione un voto.');

				if($this->form_validation->run() == TRUE) {
					$voto = $_POST['voto'];
			    	//$voto = $this->input->post('voto');
			    	$id_usuario = $this->Voto_model->_userId($_SESSION['usuario']);

			    	$votado = $this->Voto_model->_votar($id_usuario, $id_votacion, $voto, $modif);

			    	if($votado == TRUE)
			    		$mensaje = 'correcto';
			    	if($votado == FALSE)
			    		$mensaje = 'mal';

			    	$this->index($mensaje);
				}
				else {
			    	$votos = $this->Voto_model->_votosDisponibles($id_votacion);
			    	$id_usuario = $this->Voto_model->_userId($_SESSION['usuario']);
			    	$datos = array(
		    		'id_votacion' => $id_votacion,
		    		'id_usuario' => $id_usuario,
		    		'descrip' => $descrip,
					'titulo' => $titulo,
					'fch' => $fch,
					'modif' => $modif,
					'opc' => $opc,
		    		'votos' => $votos
		    		);
				    	$title['titulo'] = 'MIS VOTACIONES';
						$inicio['inicio'] = 'Elector_controller/';
						$this->load->view('elementos/head',$title);
						$this->load->view('elementos/headerVotacion',$inicio);
			        $this->load->view('Elector/voto_view', $datos);
			        //	$this->load->view('elementos/footer');		//arreglar footer
		    	}
			}
			else {	// votacion compleja
				$this->form_validation->set_rules('voto[]', 'Voto', 'required');
    			$this->form_validation->set_message('required','Seleccione al menos un voto.');

    			if($this->form_validation->run() == TRUE) {
    				$voto = $_POST['voto'];
			    	$id_usuario = $this->Voto_model->_userId($_SESSION['usuario']);

			    	$votado = $this->Voto_model->_votar($id_usuario, $id_votacion, $voto, $modif);

			    	if($votado == TRUE)
			    		$mensaje = 'correcto';
			    	if($votado == FALSE)
			    		$mensaje = 'mal';

			    	$this->index($mensaje);
    			}
    			else {
    				$votos = $this->Voto_model->_votosDisponibles($id_votacion);
			    	$id_usuario = $this->Voto_model->_userId($_SESSION['usuario']);
			    	$datos = array(
		    		'id_votacion' => $id_votacion,
		    		'id_usuario' => $id_usuario,
		    		'descrip' => $descrip,
					'titulo' => $titulo,
					'fch' => $fch,
					'modif' => $modif,
					'opc' => $opc,
		    		'votos' => $votos
		    		);
				    	$title['titulo'] = 'MIS VOTACIONES';
						$inicio['inicio'] = 'Elector_controller/';
						$this->load->view('elementos/head',$title);
						$this->load->view('elementos/headerVotacion',$inicio);
			        $this->load->view('Elector/voto_view', $datos);
			        //	$this->load->view('elementos/footer');		//arreglar footer
    			}
			}
		}
	}


//	-----------------------------------------------------------------------------------------------------------------------


    public function verResultados() {
    	if(!isset($_POST['id_votacion']) OR !isset($_POST['titulo'])) {
    		$mensaje = "Acceda debidamente a la opción de ver resultados, por favor.";
    		$this->index($mensaje);
    	}
    	else {
	    	$id_votacion = $_POST['id_votacion'];
	    	$titulo = $_POST['titulo'];

	    	$datos = $this->Voto_model->recuentoVotos($id_votacion);

	    	if($datos != FALSE) {
		    		$title['titulo'] = 'RESULTADOS';
					$inicio['inicio'] = 'Elector_controller/';
					$this->load->view('elementos/head',$title);
					$this->load->view('elementos/headerComun',$inicio);
					//$this->load->view('elementos/headerVotacion',$inicio);		// Avisar a alvaro para que ponga bien los botones y contenido ajustado
				$total = 0;
				foreach($datos as $voto) {
					if($voto->Id_Voto != 1)
						$total += $voto->Num_Votos;
				}
				$censo = $this->Voto_model->censoAsignado($id_votacion);
	    		$nomVotos = $this->Voto_model->nombreVotos($datos);

	    		$info = array(
		    		'titulo' => $titulo,
	    			'censo' => $censo,
		    		'total' => $total,
		    		'datos' => $datos,
		    		'nomVotos' => $nomVotos
		    	);

	    		/*
	    		echo "informacion para resultados: <br>";
	    		echo "censo total: ".$censo.'<br>';
	    		echo "votos totales: ".$total.'<br><br>';
	    		for($i=0; $i<sizeof($datos); ++$i)
	    		{
	    			echo $nomVotos[$i].": ".$datos[$i]->Num_Votos."<br>";
	    		}
	    		*/

				$this->load->view('Elector/resultados_view', $info);
				//	$this->load->view('elementos/footer');
	    	}
	    	else {
	    		$mensaje = 'No se pueden mostrar resultados antes de la finalizacion de la votación.';
	    		$this->index($mensaje);
	    	}

    	}
    }
}
