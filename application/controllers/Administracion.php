<?php

include 'classes/Votacion.php';

class Administracion extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('administracion_model');
    $this->load->library('pagination');

  }
  // FALTA PAGINACION
  public function index($mensaje = ''){  // PANTALLA PRINCIPAL
    $votaciones['votaciones'] = $this->administracion_model->recuperarVotaciones();
    $datos = array(
      'votaciones'=> $votaciones,
      'mensaje' => $mensaje
    );
    $this->load->view('administracion/administracion_view',$datos);

  }

  /************************************/
  /*********** CREAR VOTACION *********/
  /************************************/

  public function crearVotacion(){$this->load->view('administracion/crearVotacion_view');}
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
      $this->index('La votación se ha guardado correctamente');
    }
  }

  /************************************/
  /*********** ELIMINAR VOTACION ******/
  /************************************/

  public function prueba($id){
    $eliminada = $this->administracion_model->eliminarVotacion($id);
    if($eliminada){$this->index('La votación se ha eliminado correctamente');}
  }

  /************************************/
  /*********** MODIFICAR VOTACION *****/
  /************************************/

  public function modificarVotacion($id)
	{
		$data['votaciones'] =  $this->administracion_model->getVotacion($id);
		$this->load->view('administracion/modificarVotacion_view', $data);
	}

  // AUN NO FUNCIONA
  public function updateVotacion()
	{
		$votacion = new Votacion(
		                    $_POST['titulo'],
		                    $_POST['descripcion'],
			                  $_POST['fecha_inicio'],
			                  $_POST['fecha_final'],
			                  false
		            );
    $votacion->setId($_POST['id']);

		$modificada = $this->administracion_model->updateVotacion($votacion);
    if($modificada){
      $this->index('La modificacion se ha realizado correctamente');
    }


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
