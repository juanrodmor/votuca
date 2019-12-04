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
       // VOTACIONES QUE NO ESTÁN ELIMINADAS
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
    $nombreCensos = $this->censo_model->getCensos();

    // Extraer
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
          $fechaInicio = date('Y-m-d H:i:s',strtotime($this->input->post('fecha_inicio')));
          $fechaFin = date('Y-m-d H:i:s',strtotime($this->input->post('fecha_final')));
          //echo var_dump($fechaInicio);
          $votacion = new Votacion(
            //$this->input->post('id'),
            $this->input->post('titulo'),
            $this->input->post('descripcion'),
            $fechaInicio,
            $fechaFin,
            false,
            false,
            false,
            false,
            0.2
          );
          //echo var_dump($votacion);
          $this->guardarVotacion($votacion);
        }
    }
  }

  public function generarMesaElectoral($usuarios,$idVotacion)
  {
    $elegidos = $this->usuariosAleatorios($usuarios);
    for($i = 0; $i < sizeof($elegidos); $i++)
    {
      $elegidos[$i] = $usuarios[$elegidos[$i]];

      // CREAR EL USUARIO CON ROL DE MESA ELECTORAL
      $this->usuario_model->insertUserAs((int)$elegidos[$i],5,'m');

      // INTRODUCIR ESOS USUARIOS EN LA MESA ELECTORAL
      $idUsuario = (int)$elegidos[$i];

      // Crear el nuevo nombre de usuario
      $nombre = $this->obtenerNombreElectoral($idUsuario,'m');
      $miembro = $this->usuario_model->getIdFromUserName($nombre);
      $this->mesa_model->insertar($miembro[0]->Id,$idVotacion);

    }
    // Enviar correo a cada elegido en la mesa electoral
    //$this->enviarCorreo($elegidos[$i],$ultimoId);  // FUNCIONA
  }

  public function guardarVotacion($datos)
    {
      $censos = $this->input->post('censo'); // Vector con nombres de censos
      $usuarios = array();
      $usuariosIds = array();
      $totales = array();

      // Extraer IDS de los ficheros de esos censos seleccionados
     $idCensos = array();
      for($i = 0; $i < sizeof($censos); $i++)
      {
        $idCensos[] = $this->censo_model->getId($censos[$i]);
      }

      // GUARDAR VOTACION
      $noGuardado = $this->votaciones_model->guardarVotacion($datos);
      $ultimoId = $this->votaciones_model->getLastId();


      // RELACIONAR EL FICHERO DE ESE CENSO CON LA VOTACION
      for($i = 0; $i < sizeof($idCensos); $i++)
      {
        $this->censo_model->insertarVotacion($ultimoId[0]['Id'],$idCensos[$i][0]->Id);
      }

      // SACAR USUARIOS DE TODOS LOS CENSOS
      for($i = 0; $i < sizeof($censos); $i++)
      {
        $usuarios = $this->extraerUsuariosCenso($censos[$i]);
        $usuariosIds = $this->extraerIdsUsuarios($usuarios);

        for($j = 0; $j < sizeof($usuariosIds); $j++)
        {
          // Relacionar este usuario con este censo
          $this->censo_model->setUsuarioCenso($usuariosIds[$j],$idCensos[$i]);
          if(!in_array($usuariosIds[$j],$totales))
          array_push($totales,$usuariosIds[$j]);
        }

      }

      // METER TODOS LOS USUARIOS EXTRAIDOS EN EL CENSO
      $noGuardadoCenso = $this->insertarCenso($totales);

      // ENCRIPTAR USUARIOS PARA QUE TENGAN ABSTENIDOS POR DEFECTO
      $votoUsuarioDefecto = $this->voto_model->votoDefecto($totales,(int)$ultimoId[0]['Id'],1);

      // MESA ELECTORAL
      $this->generarMesaElectoral($totales,(int)$ultimoId[0]['Id']);

      // FINAL DE ESTA MIERDA

      if($noGuardado && $noGuardadoCenso && $votoUsuarioDefecto )
      {
        $datos = array('mensaje'=>'La votación NO se ha guardado');
        $this->load->view('secretario/crearVotacion_view',$datos);
      }
      else{
        $datos = array('mensaje'=>'La votación se ha guardado correctamente');
        $this->index('La votación se ha guardado correctamente');
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
    //echo var_dump($usuariosIds);
    $ultimoId = $this->votaciones_model->getLastId();
    $this->censo_model->insertar($usuariosIds,(int)$ultimoId[0]['Id']);
  }


  public function obtenerNombreElectoral($idUsuario,$letra)
  {
    $usuario = $this->usuario_model->getUsuario($idUsuario);
    $dni = substr($usuario[0]->NombreUsuario,1);
    $nombre = $letra.$dni;
    return $nombre;

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

      // ID DE LA VOTACION A MODIFICAR
      $id = $this->input->post('modificar');

      // SACAR CENSOS
      $censosVotacion = $this->censo_model->getCensosfromVotacion($id);
      $nombreCensos = $this->censo_model->getCensos();
      $datos = array(
        'censos' => $nombreCensos,
        'votaciones' => $this->votaciones_model->getVotacion($id),
        'censosVotacion' => $censosVotacion
      );
      //echo var_dump($censosVotacion[0]->Id_Censo);
      $this->load->view('secretario/modificarVotacion_view', $datos);

    }
	}

  public function eliminarCenso($numCensos,$censo,$idVotacion)
  {
    // Extraer id de ese censo que quiero eliminar
    $idCenso = $this->censo_model->getId($censo);

    if($numCensos > 1)
    {
      // Extraer usuarios actuales del censo de esa votacion
      $usuariosActuales = $this->censo_model->getUsuariosfromVotacion($idVotacion);

      // Obtener censos de usuarios Actuales del censo de mi votacion
      foreach($usuariosActuales as $actual)
        $censosUsuarios[]= $this->censo_model->getCensosFromUsuarios($actual->Id_Usuario);


      // Extraer usuarios de ese censo concreto que quiero borrar
      $borrarUsuarios = $this->censo_model->getUsuariosFromCenso($idCenso);
      $finales = array();

      foreach($borrarUsuarios as $aBorrar)
      {
        // Comprobar que este usuario NO está en otro censo
        $susCensos = $this->censo_model->getCensosFromUsuarios($aBorrar->Id_Usuario);
        if(sizeof($susCensos) == 1)
        {
          // SOLO ESTÁ EN UN CENSO, ¿Es el mio?
          if($susCensos[0]->Id_Censo == $idCenso[0]->Id)
          {$finales[] = $susCensos[0]->Id_Usuario; }
        }
      }

      //echo var_dump($finales);
      // Eliminar esos usuarios de una votacion concreta
      foreach($finales as $usuario)
      {$this->censo_model->eliminarUsuarios($usuario,$idVotacion);}

      // BORRAR MIEMBROS DE LA MESA ELECTORAL
      $miMesa = $this->mesa_model->getMesa($idVotacion);
      $idsMesa = array();
      foreach($miMesa as $dato)
      $idsMesa[] = $dato->Id_Usuario;


      // Obtener miembros posible de la mesa electoral de ese censo
      foreach($finales as $posibleMiembro)
      {
        $nombre = $this->obtenerNombreElectoral($posibleMiembro,'m');
        $miembro = $this->usuario_model->getIdFromUserName($nombre);
        $idMiembro = $miembro[0]->Id;

        // ¿Está este posible miembro electoral en la mesa?
        if(in_array($idMiembro,$idsMesa))
        {
          // Borrarlos de la mesa electoral
          $this->mesa_model->eliminarMiembroFromVotacion($idMiembro,$idVotacion);
        }

      }

      // Renovar la mesa electoral
      //echo 'MESA ELECTORAL DESPUES DE BORRAR<br>';
      $miMesa = $this->mesa_model->getMesa($idVotacion);

      // Notificar a los usuarios de la mesa que se va a la puta

      $this->mesa_model->deleteMesa($idVotacion);

      // Sacar usuarios de los censos restantes
      $censosRestantes = array();
      foreach($numCensos as $id)
      {
        if($id != $idCenso[0]->Id) $censosRestantes[] = $id;
      }
      $usuariosTotales = array();
      echo var_dump($censosRestantes);
      foreach($censosRestantes as $censo)
      {
        echo var_dump($censo);
        //$usuariosTotales[] = $this->censo_model->getUsuariosFromCenso($censo);

        /*$usuarios = $this->extraerUsuariosCenso($nombreCenso);
        $usuariosIds = $this->extraerIdsUsuarios($usuarios);

        for($j = 0; $j < sizeof($usuariosIds); $j++)
        {
          if(!in_array($usuariosIds[$j],$usuariosTotales))
          array_push($usuariosTotales,$usuariosIds[$j]);
        }*/
      }
      //echo var_dump($usuariosTotales);
    }
      if(sizeof($miMesa) < 3) // Hay que renovar la mesa electoral
      {
        $faltan = 3 - sizeof($miMesa);
        // Sacar censos restante que tiene actualmente la votacion
        $censosRestantes = array();
        foreach($numCensos as $id)
        {
          if($id != $idCenso[0]->Id) $censosRestantes[] = $id;
        }

        //echo 'CENSOS RESTANTES PARA ESA VOTACION<br>';
        $censoNuevo = $censosRestantes[0];
        $nombreCenso = $this->censo_model->getNombreCensoFromId($censoNuevo);
        $nombreCenso = $nombreCenso[0]->Nombre;
        $usuariosNuevoCenso = $this->extraerUsuariosCenso($nombreCenso);
        $idsNuevoCenso = $this->extraerIdsUsuarios($usuariosNuevoCenso);

        // Por cada usuario de ese censo, crear su miembro electoral
        // y comprobar que no exista ya.
        $nuevos = array();
        $i = 0;
        $j = 0;
        while($i < $faltan)
        {
          while($j < sizeof($idsNuevoCenso))
          {
            $nombre = $this->obtenerNombreElectoral($idsNuevoCenso[$j],'m');
            $miembro = $this->usuario_model->getIdFromUserName($nombre);
            echo 'Miembro: '.$miembro.'<br>';
            if(!in_array($miembro,$idsMesa))
            {
              echo 'SE INSERTA EN LA MESA<br>';
              //$this->mesa_model->insertar($miembro[0]->Id,$idVotacion);
              ++$i;
            }
            ++$j;
          }
        }
        /*foreach($idsNuevoCenso as $posibleMiembro)
        {
          $nombre = $this->obtenerNombreElectoral($posibleMiembro[$i],'m');
          $miembro = $this->usuario_model->getIdFromUserName($nombre);
          if(!in_array($miembro,$idsMesa))
          {$this->mesa_model->insertar($miembro[0]->Id,$idVotacion);}
        }
      }*/
      // Eliminar relacion con el fichero de censo
      //$this->censo_model->eliminarCenso($idVotacion,$idCenso);

    } // Fin hay varios censos

    else
    {
      // Extraer usuarios de ese censo concreto que quiero borrar
      $borrarUsuarios = $this->censo_model->getUsuariosFromCenso($idCenso);
      foreach($borrarUsuarios as $usuario)
      {
        $this->censo_model->eliminarUsuarios($usuario->Id_Usuario,$idVotacion);
      }
      // Eliminar relacion con el fichero de censo
      $this->censo_model->eliminarCenso($idVotacion,$idCenso);
    }


  }

  public function addCenso($censo,$idVotacion)
  {
    // Extraer ID del censo que voy a añadir
    $idCenso = $this->censo_model->getId($censo);

    // Extraer usuarios de ese censo
    $usuariosAñadir = $this->censo_model->getUsuariosFromCenso($idCenso);
    $idsAñadir = array();
    foreach($usuariosAñadir as $suId)
    $idsAñadir[] = $suId->Id_Usuario;

    // COMPROBAR QUE ESOS USUARIOS NO EXISTEN YA EN EL CENSO DE LA VOTACION
    $totales = $this->censo_model->getUsuariosfromVotacion($idVotacion);
    $idsTotales = array();
    // OBTENER SOLO LOS IDS DE LOS TOTALES
    foreach($totales as $usuario)
    {$idsTotales[] = $usuario->Id_Usuario;}

    // COGER USUARIOS DEL CENSO SELECCIONADO QUE NO ESTEN YA EN EL CENSO
    $finales = array();
    for($i = 0; $i < sizeof($idsAñadir);$i++)
    {
      if(!in_array($idsAñadir[$i],$idsTotales))
      {
        array_push($finales,$idsAñadir[$i]);
      }
    }

    // METER TODOS LOS USUARIOS EXTRAIDOS SIN REPETIR EN EL CENSO
    $noGuardadoCenso = $this->insertarCenso($finales);


    // ENCRIPTAR USUARIOS PARA QUE TENGAN ABSTENIDOS POR DEFECTO
    $votoUsuarioDefecto = $this->voto_model->votoDefecto($finales,$idVotacion,1);

    // GENERAR MIEMBROS DE LA MESA ELECTORAL(si son necesarios)

    // COMPROBAR SI LA MESA ELECTORAL DE ESTA VOTACION FALTA GENTE
    /*$miMesa = $this->mesa_model->getMesa($votacion->getId());
    if(sizeof($miMesa) < 3)
    {
      // Faltan miembros en la mesa
      // GENERAR USUARIOS ALEATORIOS CON LOS MIEMBROS INSERTADOS EN EL CENSO
       $elegidos = $this->usuariosAleatorios($finales);
       for($i = 0; $i < 3-sizeof($miMesa); $i++)
       {
          $elegidos[$i] = $totales[$elegidos[$i]];

          // CREAR EL USUARIO CON ROL DE MESA ELECTORAL
          $this->usuario_model->insertUserAs($elegidos[$i],5,'m');

          // INTRODUCIR ESOS USUARIOS EN LA MESA ELECTORAL
          $idUsuario = (int)$elegidos[$i];

          // Crear el nuevo nombre de usuario
          $nombre = $this->obtenerNombreElectoral($idUsuario,'m');
          $miembro = $this->usuario_model->getIdFromUserName($nombre);
          $this->mesa_model->insertar($miembro[0]->Id,$votacion->getId());

        }
    }*/
    // RELACIONAR EL FICHERO DE ESE CENSO CON LA VOTACION
    $this->censo_model->insertarVotacion($idVotacion,$idCenso[0]->Id);

  }
  public function updateVotacion()
	{
    if($this->input->post('boton_borrador'))
    {
      //CREAR LA NUEVA VOTACION CON LOS NUEVOS DATOS;
      $votacion = new Votacion(
  		                    $_POST['titulo'],
  		                    $_POST['descripcion'],
  			                  $_POST['fecha_inicio'],
  			                  $_POST['fecha_final'],
  			                  false,
                          true
  		            );
      $votacion->setId($_POST['id']);

    //SACAR MODIFICACION DE LOS CENSOS
    $censosEliminar = $this->input->post('censoEliminacion');
    $censosAñadir = $this->input->post('censoInsercion');
    $censosVotacion = $this->censo_model->getCensosfromVotacion($votacion->getId());
    $idsCensos = array();
    foreach($censosVotacion as $censo)
    {$idsCensos[] = $censo->Id_Censo;}

    if($censosEliminar != NULL)
    {
      foreach($censosEliminar as $censo)
      {
        $this->eliminarCenso($idsCensos,$censo,$votacion->getId());
        --$idsCensos;
      }

    }

    // USUARIO A AÑADIR A UN CENSO
    if($censosAñadir != NULL)
    {
      foreach($censosAñadir as $censo)
      {
        $this->addCenso($censo,$votacion->getId());
      }

    }
    // Modificar datos de la votacion
    /*$modificada = $this->votaciones_model->updateVotacion($votacion);

        if($modificada != NULL){
            $this->index('La votación se ha guardado en borrador');
          }*/
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

  /**************************/
  /******* BORRADORES *******/
  /**************************/

  public function obtenerBorradores()
  {
     $this->load->view('elementos/headerSecretario');
     $votaciones['borradores'] = $this->votaciones_model->getBorradores();
     $datos = array(
       'votaciones'=> $votaciones,
       'mensaje' => $mensaje = ''
     );
     //$this->load->view('datetime');
     $this->load->view('secretario/secretario_view',$datos);
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
    $fechaInicio = date('Y-m-d H:i:s',strtotime($this->input->post('fecha_inicio')));

    $hoy = date('Y-m-d H:i:s');
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
    $fechaFinal = date('Y-m-d H:i:s',strtotime($this->input->post('fecha_final')));
    $hoy = date('Y-m-d H:i:s');
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
