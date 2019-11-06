<?php

include 'classes/Votacion.php';

class Administracion extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('administracion_model');

  }

  function index(){
    $this->load->view('administracion/administracion_view');
  }

  function insertarVotacion($datos)
  {

    $noGuardado = $this->administracion_model->guardarVotacion($datos);
    if($noGuardado){
      $datos = array('mensaje'=>'La votación NO se ha guardado');
      $this->load->view('administracion/administracion_view',$datos);
    }
    else{
      $datos = array('mensaje'=>'La votación se ha guardado correctamente');
      $this->load->view('administracion/administracion_view',$datos);
    }
  }

  function crearVotacion()
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

				// MENSAJES DE ERROR.
				//$this->form_validation->set_message('required','Introduzca bien los campos');

        if($this->form_validation->run() == FALSE)
        { // CORRECTO

          // Conversion de fecha a un formato valido
          $fechaInicio = date('Y-m-d',strtotime($this->input->post('fecha_inicio')));
          $fechaFin = date('Y-m-d',strtotime($this->input->post('fecha_final')));

          $votacion = new Votacion(
            //$this->input->post('id'),
            $this->input->post('titulo'),
            $this->input->post('descripcion'),
            $fechaInicio,
            $fechaFin,
            false,
            false

          );
          $this->insertarVotacion($votacion);
				}
      }
    }
  }



?>
