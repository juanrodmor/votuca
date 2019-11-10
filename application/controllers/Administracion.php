<?php

include 'classes/Votacion.php';

class Administracion extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('administracion_model');
    $this->load->library('pagination');

  }
  // FALTA PAGINACION
  public function index(){  // PANTALLA PRINCIPAL
    /*$paginas = 2;
    $config['total_rows'] = $this->administracion_model->totalVotaciones();//calcula el número de filas
    $config['per_page'] = $paginas; //Número de registros mostrados por páginas
    $config['base_url'] = base_url().'administracion/';
    $config['num_links'] = 3; //Número de links mostrados en la paginación
    $config['first_link'] = 'Primera';//primer link
    $config['last_link'] = 'Última';//último link
    $config["uri_segment"] = 3;//el segmento de la paginación
    $config['next_link'] = '>';//siguiente link
    $config['prev_link'] = '<';//anterior link
    $config['full_tag_open'] = '<div class="pagination">';
    $config['full_tag_close'] = '</div>';
    $this->pagination->initialize($config); //inicializamos la paginación
    //$votaciones['votaciones'] = $this->administracion_model->recuperarVotacion();
    $votaciones['votaciones'] = $this->administracion_model->obtenerVotacionesLimite($config['per_page'],$this->uri->segment(3));
    $this->pagination->create_links();*/
    $votaciones['votaciones'] = $this->administracion_model->recuperarVotaciones();
    $this->load->view('administracion/administracion_view',$votaciones);
  }

  /************************************/
  /*********** CREAR VOTACION *********/
  /************************************/

  public function crearVotacion(){
    $this->load->view('administracion/crearVotacion_view');

  }
  public function insertarVotacion()
  {
    //$this->load->view('prueba');
    if($this->input->post('submit_reg')) // Si se ha pulsado el botón enviar
    {
        // VALIDACIONES
        //$this->form_validation->set_rules('id','ID','required');
				$this->form_validation->set_rules('titulo','Titulo','required');
				$this->form_validation->set_rules('descripcion','Descripcion','required');
				$this->form_validation->set_rules('inicio','Fecha Inicio','required');
        $this->form_validation->set_rules('final','Fecha Final','required');
        $this->form_validation->set_rules('inicio','Fecha Inicio','callback_validarFechaInicio');
        $this->form_validation->set_rules('final','Fecha Final','callback_validarFechaFinal');

				// MENSAJES DE ERROR.
				$this->form_validation->set_message('required','El campo %s es obligatorio');

        if($this->form_validation->run() == FALSE) // Hay algun error
        {
          $this->crearVotacion(); // Mostrar mensajes de error en la vista

				}
        else{  // Correcta
          $fechaInicio = date('Y-m-d',strtotime($this->input->post('fecha_inicio')));
          $fechaFin = date('Y-m-d',strtotime($this->input->post('fecha_final')));
          $votacion = new Votacion(
            //$this->input->post('id'),
            $this->input->post('titulo'),
            $this->input->post('descripcion'),
            $fechaInicio,
            $fechaFin,
            false

          );
          $this->guardarVotacion($votacion);
        }
      }
    }

  public function guardarVotacion($datos)
  {

    $noGuardado = $this->administracion_model->guardarVotacion($datos);
    if($noGuardado){
      $datos = array('mensaje'=>'La votación NO se ha guardado');
      $this->load->view('administracion/crearVotacion_view',$datos);
    }
    else{
      $datos = array('mensaje'=>'La votación se ha guardado correctamente');
      $this->load->view('administracion/crearVotacion_view',$datos);
    }
  }

  /************************************/
  /*********** ELIMINAR VOTACION ******/
  /************************************/

  public function prueba($id){
    $eliminada = $this->administracion_model->eliminarVotacion($id);
    if($eliminada){

      $this->index();

    }
  }

  /************************************/
  /*********** MODIFICAR VOTACION *****/
  /************************************/

  public function FormEdicion($id)
	{

		$data['votaciones'] =  $this->administracion_model->getVotacion($id);
		$this->load->view('administracion/FormEdicion_view', $data);
	}

  // AUN NO FUNCIONA
  public function updateVotacion()
	{
		//$id = $this->input->post('id');
		$votacion = new Votacion(
			$this->input->post('id'),
			$this->input->post('titulo'),
			$this->input->post('descripcion'),
			$this->input->post('fecha_inicio'),
			$this->input->post('fecha_final'),
			false

		);
		// ESTO NO ES RESPONSABILIDAD DEL MODELO
		//$this->db->where('id', $votacion->getId());
		//$this->db->update('votacion', $votacion);
    echo var_dump($votacion);
		/*$modificada = $this->administracion_model->updateVotacion($votacion);
    if($modificada){
      echo "Se ha modificado correctamente";
    }
    else{
      echo "HA SUCEDIDO ALGUN ERROR";
    }*/

	}

  /*******************************************/
  /********* FUNCIONES DE AYUDA **************/
  /*******************************************/

  public function validarFechaInicio(){
    $fechaInicio = date('Y-m-d',strtotime($this->input->post('fecha_inicio')));
    $hoy = date('Y-m-d');
    if($fechaInicio < $hoy){
        $this->form_validation->set_message('validarFechaInicio','Introduzca bien la fecha %s');
        return FALSE;
    }
    else{
      echo "Devuelvo true inicio";
      return TRUE;
    }
  }

  public function validarFechaFinal(){
    $fechaFinal = date('Y-m-d',strtotime($this->input->post('fecha_final')));
    $hoy = date('Y-m-d');
    if($fechaFinal < $hoy){
        $this->form_validation->set_message('validarFechaFinal','Introduzca bien la fecha %s');
        return FALSE;
    }
    else{
      echo "Devuelvo true final";
      return TRUE;
    }
  }


}



?>
