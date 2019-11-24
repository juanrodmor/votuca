<?php

include 'classes/Votacion.php';


class Secretario extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('usuario_model');
    $this->load->model('votaciones_model');
    $this->load->model('mesa_model');
    $this->load->model('voto_model');
    $this->load->model('censo_model');
    $this->load->model('SecretariosDelegados_model');
    $this->load->library('pagination');

  }

  public function index($mensaje = ''){
    // Seguridad Básica URL
    switch ($this->session->userdata('rol')) {
       case 'Administrador':
       redirect('/Administrador_controller');
        break;
       case 'Elector':
        redirect('/Elector_controller');
        break;
       case 'Secretario':

       $this->load->view('elementos/headerSecretario');
       $votaciones['votaciones'] = $this->votaciones_model->recuperarVotaciones();
       $datos = array(
         'votaciones'=> $votaciones,
         'mensaje' => $mensaje
       );
       //$this->load->view('datetime');
       $this->load->view('secretario/secretario_view',$datos);
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

  /************************************/
  /*********** CREAR VOTACION *********/
  /************************************/


  public function crearVotacion($mensaje = '')
  {
    $this->load->view('elementos/headerSecretario');
    // CENSO
    //$data = $this->usuario_model->recuperarTodos();
    $nombreCensos = $this->censo_model->getCensos();

    // Extraer
    //echo var_dump($nombreCensos);
    $datos = array(
      'censos' => $nombreCensos,
      'mensaje' => $mensaje
    );

    $this->load->view('secretario/crearVotacion_view',$datos);
    //$this->load->view('elementos/footer');
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
        //$this->form_validation->set_rules('censo','Censo','callback_validarCenso');

				// MENSAJES DE ERROR.
				$this->form_validation->set_message('required','El campo %s es obligatorio');

        if($this->form_validation->run() == FALSE) // Hay algun error
        {

          $this->crearVotacion(); // Mostrar mensajes de error en la vista

				}
        else
        {  // Correcta
          // Convierte la fecha en un formato valido para la BD
          $fechaInicio = date('Y-m-d H-i',strtotime($this->input->post('fecha_inicio')));
          $fechaFin = date('Y-m-d H-i',strtotime($this->input->post('fecha_final')));
          //echo var_dump($fechaInicio);
          $votacion = new Votacion(
            //$this->input->post('id'),
            $this->input->post('titulo'),
            $this->input->post('descripcion'),
            $fechaInicio,
            $fechaFin,
            false,
            false
          );
          //echo var_dump($votacion);
          $this->guardarVotacion($votacion);
        }
    }
  }

  public function extraerUsuariosCenso($censo)
  {
    $usuarios = array();
    $fichero = fopen($_SERVER['DOCUMENT_ROOT'] . '/votuca/application/logs/censos/'.$censo.'.txt', "r") or exit("Unable to open file!");
    while(!feof($fichero))
      {
        $usuarios[] = fgets($fichero,10);
      }
      fclose($fichero);

  return $usuarios;
  }

  public function extraerIdsUsuarios($usuarios)
  {
    $i = 0;
    $ids = array();
    while($usuarios[$i] != false && $i < sizeof($usuarios))
    {
      $encontrado = $this->usuario_model->getIdFromUserName($usuarios[$i]);
      if($encontrado){$ids[] = $encontrado[0]->Id;}
      ++$i;
    }
    return $ids;
  }
  public function insertarCenso($usuariosIds)
  {
    $ultimoId = $this->votaciones_model->getLastId();
    $this->censo_model->insertar($usuariosIds,(int)$ultimoId[0]['Id']);
  }

  public function insertarMesaElectoral($elegidos)
  {
    $ultimoId = $this->votaciones_model->getLastId();
    return $this->mesa_model->insertar($elegidos,(int)$ultimoId[0]['Id']);
  }

  public function guardarVotacion($datos)
  {
    $censos = $this->input->post('censo'); // Vector con nombres de censos
    $ultimoId = $this->votaciones_model->getLastId();
    $noGuardado = $this->votaciones_model->guardarVotacion($datos);
    $usuarios = array();
    $usuariosIds = array();

    // SACAR USUARIOS DE TODOS LOS CENSOS
    for($i = 0; $i < sizeof($censos); $i++)
    {
      $usuarios = $this->extraerUsuariosCenso($censos[$i]);
      $usuariosIds = $this->extraerIdsUsuarios($usuarios);
    }

    $noGuardadoCenso = $this->insertarCenso($usuariosIds);

    // VOTO POR DEFECTO A USUARIOS DE ESE CENSO
    $votoUsuarioDefecto = $this->voto_model->votoDefecto($usuariosIds,(int)$ultimoId[0]['Id']+1,1);

    // MESA ELECTORAL ALEATORIA
    $elegidos = $this->usuariosAleatorios($usuariosIds);
    for($i = 0; $i < sizeof($elegidos); $i++)
    {
      $elegidos[$i] = $usuariosIds[$elegidos[$i]];

      // CREAR EL USUARIO CON ROL DE MESA ELECTORAL
      $this->usuario_model->insertUserAs((int)$elegidos[$i],5);
    }
    $noGuardadoMesa = $this->insertarMesaElectoral($elegidos);

    // Enviar correo a cada elegido en la mesa electoral
    $this->enviarCorreo($elegidos,$ultimoId);  // FUNCIONA

    // FINAL DE ESTA MIERDA

    if($noGuardado && $noGuardadoCenso && $votoUsuarioDefecto && $noGuardadoMesa )
    {
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

  public function eliminarVotacion(){
    if($this->input->post('boton_eliminar'))
    {
      $id = $this->input->post('eliminar');
      $eliminada = $this->votaciones_model->eliminarVotacion($id);
      if($eliminada){$this->index('La votación se ha eliminado correctamente');}
    }

  }

  /************************************/
  /*********** MODIFICAR VOTACION *****/
  /************************************/

  public function modificarVotacion()
	{
    if($this->input->post('boton_modificar'))
    {
      if($this->session->userdata('rol') == 'Secretario')
      {
        $this->load->view('elementos/headerSecretario');
      }
      if($this->session->userdata('rol') == 'SecretarioDelegado')
      {
      $this->load->view('elementos/headerDelegado');
      }

      $id = $this->input->post('modificar');
      $data['votaciones'] =  $this->votaciones_model->getVotacion($id);
      $this->load->view('secretario/modificarVotacion_view', $data);

    }
	}

  public function updateVotacion()
	{
    if($this->input->post('boton_borrador'))
    {
      //echo 'HAS PULSADO EL BOTÓN DE BORRADOR';
      $votacion = new Votacion(
  		                    $_POST['titulo'],
  		                    $_POST['descripcion'],
  			                  $_POST['fecha_inicio'],
  			                  $_POST['fecha_final'],
  			                  false,
                          true
  		            );
      $votacion->setId($_POST['id']);
      //echo var_dump($votacion);

  $modificada = $this->votaciones_model->updateVotacion($votacion);

        if($modificada != NULL){
            $this->index('La votación se ha guardado en borrador');
          }
    }
    if($this->input->post('boton_publicar'))
    {
      $votacion = new Votacion(
  		                    $_POST['titulo'],
  		                    $_POST['descripcion'],
  			                  $_POST['fecha_inicio'],
  			                  $_POST['fecha_final'],
  			                  false,
                          false
  		            );
      $votacion->setId($_POST['id']);

  		$modificada = $this->votaciones_model->updateVotacion($votacion);

          if($modificada){
            $this->index('La modificacion se ha realizado correctamente');
          }
    }


	}
  /************************************/
  /*********** DELEGAR VOTACION *******/
  /************************************/

  public function delegarVotacion()
  {
    if($this->input->post('boton_delegar'))
    {
      $this->load->view('elementos/headerSecretario');
      $rol = 3; // Rol secretario
      $secretarios['secretarios'] = $this->usuario_model->recuperarUsuariosRol($rol);
      $idVotacion = $this->input->post('delegar');
      $datos = array(
        'idVotacion' => $idVotacion,
        'secretarios'=> $secretarios
      );
      $this->load->view('secretario/delegar_view',$datos);
      $this->load->view('elementos/footer');
    }
  }

  public function aceptarDelegacion(){
    if($this->input->post('boton_finalizar'))
    {
      $secretario = $this->input->post('idSecretario');
      $idVotacion = $this->input->post('idVotacion');
      // Guardar en la BD
      $noGuardado = $this->SecretariosDelegados_model->guardarSecretarioDelegado($secretario,$idVotacion);
      if($noGuardado){
        $this->index('Has delegado correctamente la votacion');
      }
      else{
        $this->index('Esta votación ya tiene un secretario delegado asignado');
      }
    }


  }

  public function enviar()
  {
    echo "Has pulsado enviar";
  }
  /*******************************************/
  /********* SECRETARIO DELEGADO *************/
  /*******************************************/

  public function delegado($mensaje = ''){
    $consulta = $this->usuario_model->getIdFromUserName($_SESSION['usuario']);
    $idSecretario = $consulta[0]->Id;
    $encontradas = $this->SecretariosDelegados_model->getVotacionesSecretario($idSecretario);

    $inicio['inicio'] = 'secretario/delegado';
    $this->load->view('elementos/headerComun',$inicio);
    $votaciones = array();
    foreach($encontradas as $votacion){
    $votaciones[] = $this->votaciones_model->getVotacion($votacion->Id_Votacion);
    }
    $datos = array(
        'votaciones'=> $votaciones,
        'mensaje' => $mensaje
      );
    $this->load->view('secretario/delegado_view',$datos);
    $this->load->view('elementos/footer');

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
    if($elegidos == NULL || sizeof($elegidos) < 3)
    {
      $this->form_validation->set_message('validarCenso','Introduzca al menos tres usuarios en el censo');
      return FALSE;
    }
    else{return TRUE;}
  }

  public function usuariosAleatorios($usuariosDisponibles)
  {
    $elegidos = array_rand($usuariosDisponibles,3);
    return $elegidos;
  }

  public function enviarCorreo($elegidos,$idVotacion){
    //echo var_dump($idVotacion);
    $config = array(
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_port' => 465,
      'smtp_user' => 'votvotuca@gmail.com',
      'smtp_pass' => 'cadizvotuca19',
      'mailtype' => 'html',
      'charset' => 'utf-8',
      'wordwrap' => TRUE

    );

    $this->email->initialize($config);
    $this->email->from('votvotuca@gmail.com', 'votuca');
    $this->email->to('ibsantamaria96@gmail.com');
    $this->email->subject('ERES MIEMBRO DE LA MESA ELECTORAL');
    $this->email->message('
        <h1> ¡Enhorabuena! </h1>
        <p> Eres miembro de la mesa electoral para la votacion '.$idVotacion[0]['Id'].'</p>'

    );

    $this->email->set_newline("\r\n");
    if($this->email->send()){
    }else{echo $this->email->print_debugger();}
  }


}



?>
