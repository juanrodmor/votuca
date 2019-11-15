<?php

include 'classes/Votacion.php';


class Secretario extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('usuario_model');
    $this->load->model('votaciones_model');
    $this->load->model('voto_model');
    $this->load->model('censo_model');
    $this->load->model('SecretariosDelegados_model');
    $this->load->library('pagination');

  }

  public function index($mensaje = 'Bienvenido a la pagina del secretario'){
      $votaciones['votaciones'] = $this->votaciones_model->recuperarVotaciones();
      $datos = array(
        'votaciones'=> $votaciones,
        'mensaje' => $mensaje
      );
      $this->load->view('secretario/secretario_view',$datos);

  }

  /************************************/
  /*********** CREAR VOTACION *********/
  /************************************/


  public function crearVotacion()
  {
    $data['usuarios'] = $this->usuario_model->recuperarTodos();
    $this->load->view('secretario/crearVotacion_view',$data);
  }
  public function insertarVotacion()
  {
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
        $this->form_validation->set_rules('censo','Censo','callback_validarCenso');

				// MENSAJES DE ERROR.
				$this->form_validation->set_message('required','El campo %s es obligatorio');

        if($this->form_validation->run() == FALSE) // Hay algun error
        {
          $this->crearVotacion(); // Mostrar mensajes de error en la vista

				}
        else{  // Correcta
          // Convierte la fecha en un formato valido para la BD
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
  public function insertarCenso($usuarios)
  {
    $ultimoId = $this->votaciones_model->getLastId();
    return $this->censo_model->insertar($usuarios,(int)$ultimoId[0]['Id']+1);
  }

  public function guardarVotacion($datos)
  {
    $ultimoId = $this->votaciones_model->getLastId();
    $noGuardado = $this->votaciones_model->guardarVotacion($datos);
    $noGuardadoCenso = $this->insertarCenso($this->input->post('censo'));
    $votoUsuarioDefecto = $this->voto_model->votoDefecto($this->input->post('censo'),(int)$ultimoId[0]['Id']+1,1);

    if($noGuardado && $noGuardadoCenso && $votoUsuarioDefecto ){
      $datos = array('mensaje'=>'La votación NO se ha guardado');
      $this->load->view('secretario/crearVotacion_view',$datos);
    }
    else{
      $datos = array('mensaje'=>'La votación se ha guardado correctamente');
      $this->index('La votación se ha guardado correctamente');
    }
  }

  /************************************/
  /*********** ELIMINAR VOTACION ******/
  /************************************/

  public function eliminarVotacion($id){
    $eliminada = $this->votaciones_model->eliminarVotacion($id);
    if($eliminada){$this->index('La votación se ha eliminado correctamente');}
  }

  /************************************/
  /*********** MODIFICAR VOTACION *****/
  /************************************/

  public function modificarVotacion($id)
	{
    $data['votaciones'] =  $this->votaciones_model->getVotacion($id);
		$this->load->view('secretario/modificarVotacion_view', $data);
	}

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

		$modificada = $this->votaciones_model->updateVotacion($votacion);
    if($modificada){
      $this->index('La modificacion se ha realizado correctamente');
    }

	}
  /************************************/
  /*********** DELEGAR VOTACION *******/
  /************************************/

  public function delegarVotacion($idVotacion)
  {
    $rol = 3;
    $secretarios['secretarios'] = $this->usuario_model->recuperarUsuariosRol($rol);
    $datos = array(
      'idVotacion' => $idVotacion,
      'secretarios'=> $secretarios
    );
    $this->load->view('secretario/delegar_view',$datos);

  }

  public function aceptarDelegacion($idVotacion,$secretario){
    // Guardar en la BD
    $noGuardado = $this->SecretariosDelegados_model->guardarSecretarioDelegado($secretario,$idVotacion);
    if($noGuardado){
      $this->index('Has delegado correctamente la votacion');
    }
    else{
      $this->index('Esta votación ya tiene un máximo de dos delegados');
    }

  }

  /*******************************************/
  /********* SECRETARIO DELEGADO *************/
  /*******************************************/

  public function delegado($mensaje = 'Bienvenido a la pagina del secretario delegado'){
      $votaciones['votaciones'] = $this->votaciones_model->recuperarVotaciones();
      $datos = array(
        'votaciones'=> $votaciones,
        'mensaje' => $mensaje
      );
      $this->load->view('secretario/delegado_view',$datos);

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
      //echo "Devuelvo true inicio";
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
      //echo "Devuelvo true final";
      return TRUE;
    }
  }

  public function validarCenso(){
    $elegidos = $this->input->post('censo');
    if($elegidos == NULL)
    {
      $this->form_validation->set_message('validarCenso','Introduzca al menos un usuario en el censo');
      return FALSE;
    }
    else{return TRUE;}
  }


}



?>
