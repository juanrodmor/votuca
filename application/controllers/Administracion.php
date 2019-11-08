<?php

include 'classes/Votacion.php';

class Administracion extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('administracion_model');

  }
  public function index(){  // PANTALLA PRINCIPAL
    $votaciones['votaciones'] = $this->administracion_model->recuperarVotacion();
    $this->load->view('administracion/administracion_view',$votaciones);
  }

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

  public function prueba(){
    echo "Has pulsado en prueba";
    $this->load->view('administracion/crearVotacion_view');
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
