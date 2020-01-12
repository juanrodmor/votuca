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
    $this->load->model('ponderaciones_model');
    $this->load->model('SecretariosDelegados_model');
    $this->load->library('pagination');
    $this->load->library('mailing');

  }


  public function index($mensaje = ''){
    // SEGURIDAD DEL QR
    $verified = $this->session->userdata('verified');
    if(isset($verified) && $verified == true)
    {
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
    else{redirect('/Login_controller');}



  }


  /************************************/
  /*********** CREAR VOTACION *********/
  /************************************/

  //public function encriptado($palabra){echo password_hash($palabra,PASSWORD_DEFAULT);}

  // FUNCION QUE LLAMA A LAS VISTAS
  public function crearVotacion($nombreTipo = '')
  {
    $adicionales = array();
    $this->load->view('elementos/headerSecretario');

    // CENSO
    $nombreCensos = $this->censo_model->getCensos();
    $datos = array(
      'censos' => $nombreCensos
    );
    $tipoVotacion = $this->votaciones_model->getTipoVotacion($nombreTipo);
    switch($tipoVotacion->Nombre)
    {
      case 'VotacionSimple':
        $datos += array('permitirAsistentes' => true,
                        'permitirPonderaciones' => false,
                        'permitirRecuento' => false,
                        'permitirOpciones' => false,
                        'tipoVotacion' => $tipoVotacion->Id);
        $this->load->view('secretario/crearVotacion_view',$datos);
        break;
      case 'VotacionCompleja':
      $datos += array('permitirAsistentes' => true,
                      'permitirPonderaciones' => false,
                      'permitirRecuento' => false,
                      'permitirOpciones' => true,
                      'tipoVotacion' => $tipoVotacion->Id);
      $this->load->view('secretario/crearVotacion_view',$datos);
      break;

      case 'ConsultaSimple':
      $datos += array('permitirAsistentes' => false,
                      'permitirPonderaciones' => true,
                      'permitirRecuento' => true,
                      'permitirOpciones' => false,
                      'tipoVotacion' => $tipoVotacion->Id);
      $this->load->view('secretario/crearVotacion_view',$datos);
      break;

      case 'ConsultaCompleja':
      $datos += array('permitirAsistentes' => false,
                      'permitirPonderaciones' => true,
                      'permitirRecuento' => true,
                      'permitirOpciones' => true,
                      'tipoVotacion' => $tipoVotacion->Id);
      $this->load->view('secretario/crearVotacion_view',$datos);
      break;

      case 'EleccionRepresentantes':
      $datos += array('permitirAsistentes' => true,
                      'permitirPonderaciones' => false,
                      'permitirRecuento' => false,
                      'permitirOpciones' => true,
                      'tipoVotacion' => $tipoVotacion->Id);
      $this->load->view('secretario/crearVotacion_view',$datos);
      break;

      case 'CargosUniponderados':
      $datos += array('permitirAsistentes' => false,
                      'permitirPonderaciones' => true,
                      'permitirRecuento' => false,
                      'permitirOpciones' => true,
                      'tipoVotacion' => $tipoVotacion->Id);
      $this->load->view('secretario/crearVotacion_view',$datos);
      break;

    }
    //$this->load->view('elementos/footer');*/
  }

  public function insertarVotacion()
  {
    $idTipo = $this->input->post('Id_TipoVotacion');
    $tipo = $this->votaciones_model->getNombreTipo($idTipo);
    // VALIDACIÓN
    if($this->input->post('submit_reg')) // Si se ha pulsado el botón enviar
    {
      if($this->input->post('soloAsistentes') != NULL
         && $this->input->post('asistentes') != NULL
         && $this->input->post('censo') != NULL
         ) // SI HAS ELEGIDO ASISTENTES
      {
        if($this->validaciones(true,true) == FALSE) // HAY ALGUN ERROR AL INTRODUCIR DATOS
        {$this->mostrarAsistentes($tipo);} // Hay que arreglarla para los asistentes
        else{$this->aceptarInsercion($tipo,false);} // NO HAY ERROR EN VALIDACIONES
      }
      else
      {
        if($this->input->post('soloAsistentes') != NULL
           && $this->input->post('asistentes') == NULL
           && $this->input->post('censo') != NULL
           ) // SI NO HAS ELIGIDO ASISTENTES
        {
          if($this->validaciones(true,true) == FALSE) // HAY ALGUN ERROR AL INTRODUCIR DATOS
          {$this->mostrarAsistentes($tipo);} // Hay que arreglarla para los asistentes
          else{$this->aceptarInsercion($tipo,false);} // NO HAY ERROR EN VALIDACIONES
        }
        else if($this->input->post('soloAsistentes') != NULL && $this->input->post('censo') != NULL)
        {$this->mostrarAsistentes($tipo);}
        else
        {

          if($this->input->post('soloAsistentes') != NULL && !isset($_POST['censo']))
          {if($this->validaciones(false,true) == FALSE)
            {$this->crearVotacion($tipo);}}
          else if($this->input->post('asistentes') == NULL) // NO HAY ASISTENTES, SOLO CENSO
          {
            if($this->validaciones(false,true) == FALSE)
            {$this->crearVotacion($tipo);} // Mostrar mensajes de error en la vista
            else{$this->aceptarInsercion($tipo,false);}

          }
        }
      }
    }

    if($this->input->post('boton_borrador'))
    {
      if($this->input->post('soloAsistentes') != NULL
         && $this->input->post('asistentes') != NULL
         && $this->input->post('censo') != NULL
         ) // SI HAS ELEGIDO ASISTENTES
      {
        if($this->validaciones(true,true) == FALSE) // HAY ALGUN ERROR AL INTRODUCIR DATOS
        {$this->mostrarAsistentes($tipo);} // Hay que arreglarla para los asistentes
        else{$this->aceptarInsercion($tipo,true);} // NO HAY ERROR EN VALIDACIONES
      }
      else
      {
        if($this->input->post('soloAsistentes') != NULL
           && $this->input->post('asistentes') == NULL
           && $this->input->post('censo') != NULL
           ) // SI NO HAS ELIGIDO ASISTENTES
        {
          if($this->validaciones(true,true) == FALSE) // HAY ALGUN ERROR AL INTRODUCIR DATOS
          {$this->mostrarAsistentes($tipo);} // Hay que arreglarla para los asistentes
          else{$this->aceptarInsercion($tipo,true);} // NO HAY ERROR EN VALIDACIONES
        }
        else if($this->input->post('soloAsistentes') != NULL && $this->input->post('censo') != NULL)
        {$this->mostrarAsistentes($tipo);}
        else
        {

          if($this->input->post('soloAsistentes') != NULL && !isset($_POST['censo']))
          {if($this->validaciones(false,true) == FALSE)
            {$this->crearVotacion($tipo);}}
          else if($this->input->post('asistentes') == NULL) // NO HAY ASISTENTES, SOLO CENSO
          {
            if($this->validaciones(false,true) == FALSE)
            {$this->crearVotacion($tipo);} // Mostrar mensajes de error en la vista
            else{$this->aceptarInsercion($tipo,true);}

          }
        }
      }
    }
  }

  private function aceptarInsercion($tipo,$enBorrador)
  {
    // CREAR VOTACION EN BASE A SU TIPO
    $votacion = $this->prepararVotacion($tipo,$enBorrador);
    $this->guardarVotacion($votacion);
  }

  private function prepararVotacion($nombreTipo,$enBorrador)
  {
    $fechaInicio = date('Y-m-d H:i:s',strtotime($this->input->post('fecha_inicio')));
    $fechaFin = date('Y-m-d H:i:s',strtotime($this->input->post('fecha_final')));

    $esModificable = false;
    if($this->input->post('esModificable') != NULL)
        $esModificable = true;

    $recuentoParalelo = false;
    if($this->input->post('recuentoParalelo') != NULL)
        $recuentoParalelo = true;

    $soloAsistentes = false;
    if($this->input->post('soloAsistentes') != NULL)
        $soloAsistentes = true;

    $tipoVotacion = $this->votaciones_model->getTipoVotacion($nombreTipo);
    switch($tipoVotacion->Nombre)
    {
      case 'VotacionSimple':
      $votacion = new Votacion(
      //$this->input->post('id'),
          $tipoVotacion->Id,
          $this->input->post('titulo'),
          $this->input->post('descripcion'),
          $fechaInicio,
          $fechaFin,
          false,
          $enBorrador,
          false,
          false,
          $this->input->post('quorum'),
          $esModificable,
          $soloAsistentes,
          false,
          1
        );
        break;

        case 'VotacionCompleja':
        $votacion = new Votacion(
          //$this->input->post('id'),
          $tipoVotacion->Id,
          $this->input->post('titulo'),
          $this->input->post('descripcion'),
          $fechaInicio,
          $fechaFin,
          false, // Deleted
          $enBorrador, // EsBorrador
          false, // Finalizada
          false, //Invalida
          $this->input->post('quorum'),
          $esModificable,
          $soloAsistentes, // SoloAsistentes
          false, // Recuento Paralelo
          $this->input->post('nOpciones')// NumOpciones
        );
        break;

        case 'ConsultaSimple':
        $votacion = new Votacion(
          //$this->input->post('id'),
          $tipoVotacion->Id,
          $this->input->post('titulo'),
          $this->input->post('descripcion'),
          $fechaInicio,
          $fechaFin,
          false, // Deleted
          $enBorrador, // EsBorrador
          false, // Finalizada
          false, //Invalida
          $this->input->post('quorum'),
          $esModificable,
          false, // SoloAsistentes
          $recuentoParalelo, // Recuento Paralelo
          1// NumOpciones
        );
        break;

        case 'ConsultaCompleja':
        $votacion = new Votacion(
          //$this->input->post('id'),
          $tipoVotacion->Id,
          $this->input->post('titulo'),
          $this->input->post('descripcion'),
          $fechaInicio,
          $fechaFin,
          false, // Deleted
          $enBorrador, // EsBorrador
          false, // Finalizada
          false, //Invalida
          $this->input->post('quorum'),
          $esModificable,
          false, // SoloAsistentes
          $recuentoParalelo, // Recuento Paralelo
          $this->input->post('nOpciones')// NumOpciones
        );
        break;

        case 'EleccionRepresentantes':
        $votacion = new Votacion(
          //$this->input->post('id'),
          $tipoVotacion->Id,
          $this->input->post('titulo'),
          $this->input->post('descripcion'),
          $fechaInicio,
          $fechaFin,
          false, // Deleted
          $enBorrador, // EsBorrador
          false, // Finalizada
          false, //Invalida
          $this->input->post('quorum'),
          $esModificable,
          $soloAsistentes, // SoloAsistentes
          false, // Recuento Paralelo
          $this->input->post('nOpciones')// NumOpciones
        );
        break;

        case 'CargosUniponderados':
        $votacion = new Votacion(
          //$this->input->post('id'),
          $tipoVotacion->Id,
          $this->input->post('titulo'),
          $this->input->post('descripcion'),
          $fechaInicio,
          $fechaFin,
          false, // Deleted
          $enBorrador, // EsBorrador
          false, // Finalizada
          false, //Invalida
          $this->input->post('quorum'),
          $esModificable,
          false, // SoloAsistentes
          false, // Recuento Paralelo
          $this->input->post('nOpciones')// NumOpciones
        );
        break;
      }
      return $votacion;
  }

  // FUNCIÓN QUE GUARDA UNA VOTACION EN LA BD
  public function guardarVotacion($datos)
  {
    //echo var_dump($datos);
      $asistentes = $this->input->post('asistentes');
      $nombreCensos = $this->input->post('censo'); // Vector con nombres de censos
      $usuarios = array();
      $usuariosIds = array();
      $totales = array();
      //echo var_dump($this->input->post('esModificable'));
      // GUARDAR VOTACION SIN ASISTENTES SELECCIONADOS
      if($asistentes == NULL)
      {
        //echo 'GUARDAMOS VOTACION NORMAL';
        // Extraer IDS de los ficheros de esos censos seleccionados
       $idsFicheros = array();
       $idsFicheros = $this->extraerIdsFicheros($nombreCensos);

        // GUARDAR VOTACION
        $noGuardado = $this->votaciones_model->guardarVotacion($datos);
        $idVotacion = $this->votaciones_model->getLastId();

        // RELACIONAR LA NUEVA VOTACION CON EL FICHERO DE CADA CENSO
        $this->relacionVotacionFichero($idsFicheros,$idVotacion);

        // RELACION LA VOTACION CON SUS POSIBLES OPCIONES
        $this->guardarSusOpciones($idVotacion,$datos->getTipo());

        // GENERAR PONDERACIONES
        $this->generarPonderaciones($idVotacion,$datos->getTipo());

        // SACAR USUARIOS DE TODOS LOS FICHEROS DE CENSOS
        for($i = 0; $i < sizeof($nombreCensos); $i++)
        {
          $usuarios = $this->extraerUsuariosFichero($nombreCensos[$i]);
          $usuariosIds = $this->extraerIdsUsuarios($usuarios);

          for($j = 0; $j < sizeof($usuariosIds); $j++)
          {
            // Relacionar este usuario con este censo en la bd
            $this->censo_model->setUsuarioCenso($usuariosIds[$j],$idsFicheros[$i]);
            if(!in_array($usuariosIds[$j],$totales))
            array_push($totales,$usuariosIds[$j]);
          }
        }

        // METER TODOS LOS USUARIOS EXTRAIDOS EN EL CENSO
        $noGuardadoCenso = $this->insertarUsuariosCenso($totales,$idVotacion);

        // ENCRIPTAR USUARIOS PARA QUE TENGAN ABSTENIDOS POR DEFECTO
        $votoUsuarioDefecto = $this->voto_model->votoDefecto($totales,$idVotacion,1);

        // MESA ELECTORAL Y CORREOS
        $correoEnviado = $this->generarMesaElectoral($totales,$idVotacion);

        // GUARDAR NUM_VOTOS EN RECUENTO
        $this->generarNumeroVotos($idVotacion,$datos->getTipo());
      }
     else
      {  // GUARDAR ASISTENTES
        // GUARDAR VOTACION
        $noGuardado = $this->votaciones_model->guardarVotacion($datos);
        $idVotacion = $this->votaciones_model->getLastId();

        // RELACION LA VOTACION CON SUS POSIBLES OPCIONES
        $this->guardarSusOpciones($idVotacion,$datos->getTipo());

        // GENERAR PONDERACIONES
        $this->generarPonderaciones($idVotacion,$datos->getTipo());

        // METER TODOS LOS USUARIOS EXTRAIDOS EN EL CENSO ASISTENTES
        $noGuardadoCenso = $this->censo_model->insertarCensoAsistente($asistentes,$idVotacion);
        $this->censo_model->insertar($asistentes,$idVotacion);

        // ENCRIPTAR USUARIOS PARA QUE TENGAN ABSTENIDOS POR DEFECTO
        $votoUsuarioDefecto = $this->voto_model->votoDefecto($asistentes,$idVotacion,1);

        // MESA ELECTORAL Y CORREOS
        $correoEnviado = $this->generarMesaElectoral($asistentes,$idVotacion);

        // GUARDAR NUM_VOTOS EN RECUENTO
        $this->generarNumeroVotos($idVotacion,$datos->getTipo());
      }

      // MOSTRAR MENSAJE FINAL
      if($noGuardado && $noGuardadoCenso && $votoUsuarioDefecto && $correoEnviado != 'success')
      {
        $datos = array('mensaje'=>'La votación NO se ha guardado');
        $this->load->view('secretario/crearVotacion_view',$datos);
      }
      else{
        $this->index('La votación se ha guardado correctamente.');
      }
    }


  /**************************************************/
  /********* FUNCIONES AUXILIARES INSERTAR  *********/
  /**************************************************/

    // LLAMA A LA VISTA MOSTRANDO ASISTENTES
    private function mostrarAsistentes($tipo)
    {
      $idTipo = $this->input->post('Id_TipoVotacion');
      $esModificable = false;
      if($this->input->post('esModificable') != NULL)
          $esModificable = true;

      $recuentoParalelo = false;
      if($this->input->post('recuentoParalelo') != NULL)
          $esModificable = true;

      $soloAsistentes = false;
      if($this->input->post('soloAsistentes') != NULL)
          $soloAsistentes = true;

      $usuarios = array();
      $usuariosIds = array();
      $totales = array();
      $censosSeleccionados = $this->input->post('censo');
      // Extraer IDS de los ficheros de esos censos seleccionados
      $idsFicheros = array();
      $idsFicheros = $this->extraerIdsFicheros($censosSeleccionados);
      // SACAR USUARIOS DE TODOS LOS FICHERoS DE CENSOS
      for($i = 0; $i < sizeof($censosSeleccionados); $i++)
      {
        $usuarios = $this->extraerUsuariosFichero($censosSeleccionados[$i]);
        $usuariosIds = $this->extraerIdsUsuarios($usuarios);

        for($j = 0; $j < sizeof($usuariosIds); $j++)
        {
          // Relacionar este usuario con este censo en la bd
          $this->censo_model->setUsuarioCenso($usuariosIds[$j],$idsFicheros[$i]);
          if(!in_array($usuariosIds[$j],$totales))
          array_push($totales,$usuariosIds[$j]);
        }
      }
      // OBTENER NOMBRES DE ESOS USUARIOS
      $nombresUsuarios = array();
      foreach($totales as $idUser)
      {
        $aux = $this->usuario_model->getUsuario($idUser);
        $nombresUsuarios[] = $aux;
      }
      $nombreCensos = $this->censo_model->getCensos();
      $datos = array(
          'pulsadoModificar' => $esModificable,
          'pulsadoParalelo' => $recuentoParalelo,
          'pulsadoAsistentes' => $soloAsistentes,
          'censos' => $nombreCensos,
          'asistentes' => $nombresUsuarios,
          'mensaje' => 'Seleccione abajo el censo asistente',
          'tipoVotacion' => $idTipo
      );
      $this->llamarVistasCrear($tipo,$datos);

    }

    private function llamarVistasCrear($tipo,$datos)
    {
      $this->load->view('elementos/headerSecretario');
      switch($tipo)
      {
        case 'VotacionSimple':
          $datos += array('permitirAsistentes' => true,
                          'permitirPonderaciones' => false,
                          'permitirRecuento' => false,
                          'permitirOpciones' => false);
          $this->load->view('secretario/crearVotacion_view',$datos);
          break;
        case 'VotacionCompleja':
        $datos += array('permitirAsistentes' => true,
                        'permitirPonderaciones' => false,
                        'permitirRecuento' => false,
                        'permitirOpciones' => true);
        $this->load->view('secretario/crearVotacion_view',$datos);
        break;

        case 'ConsultaSimple':
        $datos += array('permitirAsistentes' => false,
                        'permitirPonderaciones' => true,
                        'permitirRecuento' => true,
                        'permitirOpciones' => false);
        $this->load->view('secretario/crearVotacion_view',$datos);
        break;

        case 'ConsultaCompleja':
        $datos += array('permitirAsistentes' => false,
                        'permitirPonderaciones' => true,
                        'permitirRecuento' => true,
                        'permitirOpciones' => true);
        $this->load->view('secretario/crearVotacion_view',$datos);
        break;

        case 'EleccionRepresentantes':
        $datos += array('permitirAsistentes' => true,
                        'permitirPonderaciones' => false,
                        'permitirRecuento' => false,
                        'permitirOpciones' => true);
        $this->load->view('secretario/crearVotacion_view',$datos);
        break;

        case 'CargosUniponderados':
        $datos += array('permitirAsistentes' => false,
                        'permitirPonderaciones' => true,
                        'permitirRecuento' => false,
                        'permitirOpciones' => true);
        $this->load->view('secretario/crearVotacion_view',$datos);
        break;

      }
    }

    private function obtenerNombreElectoral($idUsuario,$letra)
    {
      $usuario = $this->usuario_model->getUsuario($idUsuario);
      $dni = substr($usuario[0]->NombreUsuario,1);
      $nombre = $letra.$dni;
      return $nombre;
    }

    private function generarMesaElectoral($usuarios,$idVotacion)
    {
      $elegidos = $this->usuariosAleatorios($usuarios);
      for($i = 0; $i < sizeof($elegidos); $i++)
      {
        $elegidos[$i] = $usuarios[$elegidos[$i]];

        // CREAR EL USUARIO CON ROL DE MESA ELECTORAL
        $insertado = $this->usuario_model->insertUserAs((int)$elegidos[$i],5,'m');

        // Crear el nuevo nombre de usuario
        $idUsuario = (int)$elegidos[$i];
        $nombre = $this->obtenerNombreElectoral($idUsuario,'m');
        $miembro = $this->usuario_model->getIdFromUserName($nombre);
        $this->mesa_model->insertar($miembro[0]->Id,$idVotacion);

        // Obtener correo de ese miembro insertado o no insertado
        $miembroNuevo = $this->usuario_model->getUsuario($miembro[0]->Id);

        // Crear tiempo de expiracion para ese usuario y correo
        $asunto = 0;
        $mensaje = 0;
        if($insertado)
        {
          if(!$this->usuario_model->comprobarExpiracion($miembro[0]->Id))
          {$this->usuario_model->setUserTimeLimit($nombre);}
          // Enviar correo a cada elegido en la mesa electoral
          $asunto = '[NOTIFICACIÓN VOTUCA] Miembro electoral.';
          $mensaje = '<h1>Eres miembro de la mesa electoral</h1>
          Eres miembro de la mesa electoral de la votacion '.$idVotacion.'

          <p>Puede loguearse como usuario: <h2>'.$nombre.'</h2> y su misma contraseña de elector.</p>
          <p> Disponie de un período de 24 horas para modificar su contraseña, de no ser asi se borrará su usuario de la mesa electoral.</p>
          <p>Coordialmente, la administración de VotUCA.</p>
          ';
        }
        else
        {
          // Enviar correo a cada elegido en la mesa electoral
          $asunto = '[NOTIFICACIÓN VOTUCA] Miembro electoral.';
          $mensaje = '<h1>Eres miembro de la mesa electoral</h1>
          Eres miembro de la mesa electoral de la votacion '.$idVotacion.'

          <p>Puede loguearse como usuario: <h2>'.$nombre.'</h2> y su misma contraseña de elector.</p>
          <p>Coordialmente, la administración de VotUCA.</p>
          ';
        }

        //echo var_dump($existe);

      }
      //echo var_dump($miembroNuevo);
      $result = $this->mailing->sendEmail($miembroNuevo[0]->NombreUsuario, $asunto, $mensaje);
      /*$data = array('mensaje_success' => 'Se ha enviado la notificacion de miembro electoral al usuario ' . $miembroNuevo[0]->NombreUsuario . '.');

      if($result == 'success')
      {
        $data['mensaje_success'] .= ' Dicho usuario ha sido notificado por correo.';
      }
      else
      {$data['mensaje_failure'] = 'La notificación por correo ha fallado.';}*/
      return $result;
    }

    private function extraerIdsFicheros($nombreCensos)
    {
      $idCensos = array();
      for($i = 0; $i < sizeof($nombreCensos); $i++)
          $idCensos[] = $this->censo_model->getId($nombreCensos[$i]);
      return $idCensos;
    }

    private function relacionVotacionFichero($idsFicheros,$idVotacion)
    {
      for($i = 0; $i < sizeof($idsFicheros); $i++)
      {
        $this->censo_model->insertarVotacion($idVotacion,$idsFicheros[$i]);
      }
    }

    private function extraerUsuariosFichero($nombreCenso)
    {
      $usuarios = array();
      $fichero = fopen($_SERVER['DOCUMENT_ROOT'] . '/votuca/application/logs/censos/'.$nombreCenso.'.txt', "r") or exit("Unable to open file!");
      while(!feof($fichero))
        {
          $usuarios[] = fgets($fichero,10);
        }
        fclose($fichero);

      return $usuarios;
    }

    private function extraerIdsUsuarios($usuarios)
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

    private function insertarUsuariosCenso($usuariosIds,$idVotacion)
    {
      $this->censo_model->insertar($usuariosIds,$idVotacion);
    }

    private function guardarSusOpciones($idVotacion,$tipo)
    {
      if($tipo == 1 || $tipo == 3)  // VOTACION COMPLEJA && CONSULTA SIMPLE
      {
        $misVotos = array(2,3,4);
        $this->voto_model->insertarOpciones($idVotacion,$misVotos);
      }
      else{
        switch($tipo)
        {
          case 2: // VOTACION COMPLEJA
            $extraccionOpciones = explode(",",$this->input->post('opciones'));

            // Crear cada opcion para que esté disponible
            $idsOpciones = array();
            foreach($extraccionOpciones as $opcion)
            {
               $this->voto_model->nuevoTipoVoto($opcion);
               $idsOpciones[] = $this->voto_model->getIdFromNombreVoto($opcion);
             }

            // Extraer ids de esos nuevos tipos de votos
            $this->voto_model->insertarOpciones($idVotacion,$idsOpciones);


          break;

          case 4: // CONSULTA COMPLEJA
          $extraccionOpciones = explode(",",$this->input->post('opciones'));

          // Crear cada opcion para que esté disponible
          $idsOpciones = array();
          foreach($extraccionOpciones as $opcion)
          {
             $this->voto_model->nuevoTipoVoto($opcion);
             $idsOpciones[] = $this->voto_model->getIdFromNombreVoto($opcion);
           }

          // Extraer ids de esos nuevos tipos de votos
          $this->voto_model->insertarOpciones($idVotacion,$idsOpciones);
          break;

          case 5:
          $extraccionOpciones = explode(",",$this->input->post('opciones'));

          // Crear cada opcion para que esté disponible
          $idsOpciones = array();
          foreach($extraccionOpciones as $opcion)
          {
             $this->voto_model->nuevoTipoVoto($opcion);
             $idsOpciones[] = $this->voto_model->getIdFromNombreVoto($opcion);
           }

          // Extraer ids de esos nuevos tipos de votos
          $this->voto_model->insertarOpciones($idVotacion,$idsOpciones);
          break;

          case 6:
          $extraccionOpciones = explode(",",$this->input->post('opciones'));

          // Crear cada opcion para que esté disponible
          $idsOpciones = array();
          foreach($extraccionOpciones as $opcion)
          {
             $this->voto_model->nuevoTipoVoto($opcion);
             $idsOpciones[] = $this->voto_model->getIdFromNombreVoto($opcion);
           }

          // Extraer ids de esos nuevos tipos de votos
          $this->voto_model->insertarOpciones($idVotacion,$idsOpciones);
          break;
        }
      }
    }

    private function validaciones($validarAsistentes,$validarCenso)
    {
      $this->form_validation->set_rules('titulo','Titulo','required');
      $this->form_validation->set_rules('descripcion','Descripcion','required');
      $this->form_validation->set_rules('inicio','Fecha Inicio','required');
      $this->form_validation->set_rules('final','Fecha Final','required');
      /*$this->form_validation->set_rules('ponderacionPAS','Ponderaciones PAS','required');
      $this->form_validation->set_rules('ponderacionAumnos','Ponderaciones Alumnos','required');
      $this->form_validation->set_rules('ponderacionProfesores','Ponderaciones Profesores','required');
      */
      $this->form_validation->set_rules('inicio','Fecha Inicio','callback_validarFechaInicio');
      $this->form_validation->set_rules('final','Fecha Final','callback_validarFechaFinal');
      $this->form_validation->set_rules('opciones',"Opciones",'callback_validarOpciones');
      $this->form_validation->set_rules('quorum','Quorum','callback_validarQuorum');
      if($validarAsistentes)
      $this->form_validation->set_rules('asistentes','Asistentes','callback_validarAsistentes');
      if($validarCenso)
      $this->form_validation->set_rules('censos','Censo','callback_validarFicherosCenso');
      // MENSAJES DE ERROR.
      $this->form_validation->set_message('required','El campo %s es obligatorio');
      return $this->form_validation->run();
    }

    private function generarPonderaciones($idVotacion,$tipo)
    {
      switch($tipo)
      {
        case 1:
        $this->ponderaciones_model->insertarPonderacion($idVotacion,1,1);
        $this->ponderaciones_model->insertarPonderacion($idVotacion,2,1);
        $this->ponderaciones_model->insertarPonderacion($idVotacion,3,1);
        break;

        case 2:
        $this->ponderaciones_model->insertarPonderacion($idVotacion,1,1);
        $this->ponderaciones_model->insertarPonderacion($idVotacion,2,1);
        $this->ponderaciones_model->insertarPonderacion($idVotacion,3,1);
        break;

        case 3:
        $this->ponderaciones_model->insertarPonderacion($idVotacion,1,$this->input->post('ponderacionPAS'));
        $this->ponderaciones_model->insertarPonderacion($idVotacion,2,$this->input->post('ponderacionAlumnos'));
        $this->ponderaciones_model->insertarPonderacion($idVotacion,3,$this->input->post('ponderacionProfesores'));
        break;

        case 4:
        $this->ponderaciones_model->insertarPonderacion($idVotacion,1,$this->input->post('ponderacionPAS'));
        $this->ponderaciones_model->insertarPonderacion($idVotacion,2,$this->input->post('ponderacionAlumnos'));
        $this->ponderaciones_model->insertarPonderacion($idVotacion,3,$this->input->post('ponderacionProfesores'));
        break;

        case 5:
        $this->ponderaciones_model->insertarPonderacion($idVotacion,1,1);
        $this->ponderaciones_model->insertarPonderacion($idVotacion,2,1);
        $this->ponderaciones_model->insertarPonderacion($idVotacion,3,1);
        break;

        case 6:
        $this->ponderaciones_model->insertarPonderacion($idVotacion,1,$this->input->post('ponderacionPAS'));
        $this->ponderaciones_model->insertarPonderacion($idVotacion,2,$this->input->post('ponderacionAlumnos'));
        $this->ponderaciones_model->insertarPonderacion($idVotacion,3,$this->input->post('ponderacionProfesores'));
        break;
      }
    }

    private function generarNumeroVotos($idVotacion,$tipo)
    {
      $numeroUsuarios = 0;
      // EXTRAER OPCIONES
      $opciones = $this->voto_model->getVotosFromVotacion($idVotacion);
      //$opciones[] = 1;
      //echo var_dump($opciones).'<br>';

      // Contar usuarios por grupo
      $alumnos = 0;
      $profesores = 0;
      $pas = 0;


      $hasAsistentes = $this->votaciones_model->hasSoloAsistentes($idVotacion);
      if($hasAsistentes[0]->soloAsistentes == 0) // NO TIENE ASISTENTES
      {$censoTotal= $this->votaciones_model->contarUsuarios('censo',$idVotacion);}
      else{$censoTotal = $this->votaciones_model->contarUsuarios('censo_asistente',$idVotacion);}
      $this->voto_model->recuentoPorDefecto($idVotacion,4,1,$censoTotal[0]->total);

      $usuariosCenso = $this->censo_model->getUsuariosfromVotacion($idVotacion);

      // CALCULO DE CADA GRUPO
      foreach($usuariosCenso as $usuario)
      {
        $grupos = $this->usuario_model->getUserGroups($usuario->Id_Usuario);
        foreach($grupos as $grupo)
        {
          switch($grupo->Id_Grupo)
          {
            case 1:
              $pas = $pas + 1;
              break;
            case 2:
              $alumnos = $alumnos + 1;
              break;
            case 3:
              $profesores = $profesores + 1;
              break;
          }
        }
      }
      // INTRODUCIR DATOS EN RECUENTO
      for($i = 1; $i < 4; $i++)
      {
        switch($i)
        {
          case 1:
            $numeroUsuarios = $pas;
            break;
          case 2:
            $numeroUsuarios = $alumnos;
            break;
          case 3:
            $numeroUsuarios = $profesores;
            break;

        }

        $this->voto_model->recuentoPorDefecto($idVotacion,$i,$opciones,$numeroUsuarios);
      }
      //echo var_dump($numeroUsuarios).'<br>';


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

  // FUNCIÓN QUE MUESTRA LA VISTA DE MODIFICAR VOTACION LA PRIMERA VEZ
  public function modificarVotacion()
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
      $votacion = $this->votaciones_model->getVotacion($id);


      // SACAR CENSOS
      $censosVotacion = $this->censo_model->getCensosfromVotacion($id);
      $nombreCensos = $this->censo_model->getCensos();

      // CHECKBOXES ENCENDIDOS
      $soloAsistentes = false;
      if($votacion->SoloAsistentes == 1){$soloAsistentes = true;}

      $esModificable = false;
      if($votacion->VotoModificable == 1){$esModificable = true;}

      $recuentoParalelo = false;
      if($votacion->RecuentoParalelo == 1){$recuentoParalelo = true;}

      $cambiarOpciones = false;
      if($votacion->NumOpciones > 1){$cambiarOpciones = true;}

      $cambiarPonderaciones = false;
      if($votacion->Id_TipoVotacion == 3 || $votacion->Id_TipoVotacion == 4
         || $votacion->Id_TipoVotacion == 6)
      {$cambiarPonderaciones = true;}

      // SACAR ASISTENTES SI LA VOTACIÓN TIENE CENSO ASISTENTE
      $idsAsistentes = array();
      $asistentesNombre = array();
      $asistentes = array();
      if($soloAsistentes)
      {
        $usuariosAsistentes = $this->censo_model->getCensoAsistente($id);
        foreach($usuariosAsistentes as $asistente)
        {$idsAsistentes[] = $asistente->Id_Usuario;}

        // EXTRAER NOMBRES DE USUARIOS ASOCIADOS A ESOS IDS
        foreach($idsAsistentes as $id)
        {$asistentesNombre[] = $this->usuario_model->getUserNameFromId($id);}

        foreach($asistentesNombre as $nombre)
        {$asistentes[] = $nombre[0]->NombreUsuario;}

      }

      // SACAR OPCIONES DE UNA VOTACION
      $nombresVotos = NULL;
      if($votacion->Id_TipoVotacion == 2 || $votacion->Id_TipoVotacion == 5
         || $votacion->Id_TipoVotacion == 4 || $votacion->Id_TipoVotacion == 6)
      {
        $idsVotos = $this->voto_model->getVotosFromVotacion($votacion->Id);
        foreach($idsVotos as $id)
        $nombresVotos[] = $this->voto_model->getNombreFromIdVoto($id->Id_Voto);
      }

      // SACAR PONDERACIONES DE UNA VOTACION
      $pondPAS = $this->votaciones_model->getPonderacionesFromGrupo($votacion->Id,1);
      $pondAlumnos = $this->votaciones_model->getPonderacionesFromGrupo($votacion->Id,2);
      $pondProfesores = $this->votaciones_model->getPonderacionesFromGrupo($votacion->Id,3);

      $datos = array(
        'censos' => $nombreCensos,
        'votaciones' => $votacion,
        'censosVotacion' => $censosVotacion,
        'pulsadoAsistentes' => $soloAsistentes,
        'pulsadoModificar' => $esModificable,
        'pulsadoRecuento' => $recuentoParalelo,
        'cambiarOpciones' => $cambiarOpciones,
        'cambiarPonderaciones' => $cambiarPonderaciones,
        'pondPAS' => $pondPAS,
        'pondAlumnos' => $pondAlumnos,
        'pondProfesores' => $pondProfesores,
        'asistentes' => $asistentes,
        'idsAsistentes' => $idsAsistentes,
        'nombresVotos' => $nombresVotos,
        'ultimoPaso' => false,
      );
      // SACAR TIPO DE VOTACION
      $this->load->view('secretario/modificarVotacion_view', $datos);

	}

  public function updateVotacion()
	{
    if($this->input->post('boton_borrador'))
    $this->actualizarVotacionFromBoton('boton_borrador',true);
    if($this->input->post('boton_publicar'))
    $this->actualizarVotacionFromBoton('boton_publicar',false);
  }

  private function actualizarVotacionFromBoton($boton,$publicar)
  {
      if($this->input->post($boton))
      {
        if($this->validaciones(false,false) == FALSE) // Algun fallo en algun campo
        {$this->mostrarErrores($_POST);}
        else // No hay ningún fallo en ningun campo campo escrito
        {
          // MODIFICAR DATOS DE LA VOTACION
          $idVotacion = $_POST['id'];
          $antesModificar = $this->votaciones_model->getVotacion($idVotacion);
          $datos = $this->actualizarVotacionDatos($publicar);
          $idTipo = $_POST['Id_TipoVotacion'];
          $censosVotacion = $this->censo_model->getCensosfromVotacion($idVotacion);

          // ACTUALIZAR PONDERACIONES
          if(isset($_POST['ponderacionPAS']) && isset($_POST['ponderacionAlumnos']) && ($_POST['ponderacionProfesores']))
          {
            $pondPas = $_POST['ponderacionPAS'];
            $pondAlum = $_POST['ponderacionAlumnos'];
            $pondProfesores = $_POST['ponderacionProfesores'];
            $this->votaciones_model->updatePonderaciones($idVotacion,$pondPas,$pondAlum,$pondProfesores);
          }

          // JUEGO DE ASISTENTES
          $finalizado = false;
          $soloAsistentes = false;
          if(isset($_POST['soloAsistentes']) && $_POST['soloAsistentes']  == 1){$soloAsistentes = true;}

          // 1. NO PULSADO SOLO ASISTENTES Y ADEMÁS LA VOTACION NO TENIA ASISTENTES
          if(!$soloAsistentes && $antesModificar->SoloAsistentes == false)
          {
            // Modificar censo si es necesario
            $this->modificarSoloCensos($idVotacion);
            $finalizado = true;

          }
          // 2. NO PULSADO SOLO ASISTENTES Y ADEMÁS LA VOTACION TENIA ASISTENTES
          if(!$soloAsistentes && $antesModificar->SoloAsistentes == true)
          {
            $this->actualizarAsistentes($idVotacion,$_POST['asistentes'],'eliminarAsistencia');
            $finalizado = true;
          }

          // 3. PULSADO SOLO ASISTENTES Y LA VOTACION NO TENIA ASISTENTES
          if($soloAsistentes && $antesModificar->SoloAsistentes == false)
          {
            // Pasar censo actual de la votacion al censo asistente
            $totales = $this->censo_model->getUsuariosfromVotacion($idVotacion);
            $idsTotales = array();
            foreach($totales as $usuario)
            {$idsTotales[] = $usuario->Id_Usuario;}
            $this->actualizarAsistentes($idVotacion,$idsTotales,'transferirCenso');

            // Comprobar si se añaden nuevos censos
            if(isset($_POST['censo']) && !isset($_POST['asistentes']))
             $this->actualizarAsistentes($idVotacion,$_POST['censo'],'llamarNuevos');

          }

          // 4. PULSADO SOLO ASISTENTES Y LA VOTACION TENIA ASISTENTES
          if($soloAsistentes && $antesModificar->SoloAsistentes == true )
          {
            //echo 'Esta votacion tenia censo asistente y SIGUE TENIENDO.<br>';
            if(isset($_POST['censo']) && $_POST['ultimoPaso'] == false)
            {
              $this->actualizarAsistentes($idVotacion,$_POST['censo'],'llamarNuevos');
            }
            else
            {
              if(isset($_POST['asistentes']) && isset($_POST['censo']) && $_POST['ultimoPaso'] == true)
              {
                $this->actualizarAsistentes($idVotacion,$_POST['asistentes'],'añadirAsistentes');
                $finalizado = true;
              }
              else if(!isset($_POST['asistentes']) && isset($_POST['censo']) && $_POST['ultimoPaso'] == true)
              {$this->recargarDatosVotacion($_POST,NULL);}
              else
              {
                if(isset($_POST['asistentes']) && sizeof($_POST['asistentes']) < 3 && $_POST['ultimoPaso'] == false )
                {
                  if($this->validaciones(true,false) == FALSE)
                  {$this->mostrarErrores($_POST);}
                }
                else
                {
                  $this->actualizarAsistentes($idVotacion,$_POST['asistentes'],'resetear');
                  $finalizado = true;
                }
              }
            }
            if(isset($_POST['censoEliminacion']) && $_POST['censoEliminacion'] != NULL)
            {
              foreach($_POST['censoEliminacion'] as $censo)
              {
                $this->eliminarCensoAsistente($censo,$idVotacion);
                $finalizado = true;
              }
            }
          }
        }
          $modificada = $this->votaciones_model->updateVotacion($datos,$idVotacion);
      }
      if($modificada != NULL && $finalizado)
          $this->index('La votación se ha modificado correctamente');

  }

  /**********************************************/
  /********** FUNCIONES AUXILIARES MODIFICAR ****/
  /**********************************************/

  private function modificarCensoAsistente($idVotacion)
  {
    $censosVotacion = $this->censo_model->getCensosfromVotacion($idVotacion);
    $censosEliminar = $this->input->post('censoEliminacion');
    $censosAñadir = $this->input->post('censo');
    $idsCensos = array();
    foreach($censosVotacion as $censo)
    {$idsCensos[] = $censo->Id_Fichero;}
    // AÑADIR CENSOS
    if($censosAñadir != NULL)
    {
      foreach($censosAñadir as $censo)
      {
        $this->addCenso($idsCensos,$censo,$idVotacion);
        $this->addCensoAsistente($censo,$idVotacion);
      }
    }
    // ELIMINAR CENSO
    if($censosEliminar != NULL)
    {  // Hay censos a eliminar
      foreach($censosEliminar as $censo)
      {
        $this->eliminarCenso($idsCensos,$censo,$idVotacion);
        $this->eliminarCensoAsistente($idsCensos,$censo,$idVotacion);
        --$idsCensos;
      }
    }
  }

  private function mostrarAsistentesModificar($misDatos)
  {

    $esModificable = false;
    if($this->input->post('esModificable') != NULL)
        $esModificable = true;

    $recuentoParalelo = false;
    if($this->input->post('recuentoParalelo') != NULL)
        $esModificable = true;

    $soloAsistentes = false;
    if($this->input->post('soloAsistentes') != NULL)
        $soloAsistentes = true;

    // Recargar los datos de la votacion
    $datos = $this->recargarDatosVotacion($misDatos);

    // Incorporar asistentes del censo seleccionado
    $censosSeleccionados = $this->input->post('censo');
    $totales = array();
    if(isset($_POST['asistentes'])){$totales = $_POST['asistentes'];}
    // Extraer IDS de los ficheros de esos censos seleccionados
    $idsFicheros = array();
    $idsFicheros = $this->extraerIdsFicheros($censosSeleccionados);
    // SACAR USUARIOS DE TODOS LOS FICHERoS DE CENSOS
    for($i = 0; $i < sizeof($censosSeleccionados); $i++)
    {
      $usuarios = $this->extraerUsuariosFichero($censosSeleccionados[$i]);
      $usuariosIds = $this->extraerIdsUsuarios($usuarios);

      for($j = 0; $j < sizeof($usuariosIds); $j++)
      {
        // Relacionar este usuario con este censo en la bd
        $this->censo_model->setUsuarioCenso($usuariosIds[$j],$idsFicheros[$i]);
        if(!in_array($usuariosIds[$j],$totales))
        array_push($totales,$usuariosIds[$j]);
      }
    }
    // OBTENER NOMBRES DE ESOS USUARIOS
    $nombresUsuarios = array();
    foreach($totales as $idUser)
    {
      $aux = $this->usuario_model->getUsuario($idUser);
      $nombresUsuarios[] = $aux;
    }
    // INTRODUCIR ESOS NUEVOS USUARIOS EN LA TABLA DE ASISTENTES
    $asistentesActuales = $datos['asistentes'];
    $idsActuales = $datos['idsAsistentes'];
    //echo var_dump($nombresUsuarios[0]);
    foreach($nombresUsuarios as $nombre)
    {
      if(!in_array($nombre[0]->NombreUsuario,$asistentesActuales))
      {
        $asistentesActuales[] = $nombre[0]->NombreUsuario;
        $idsActuales[] = $nombre[0]->Id;
      }
    }
    $datos['asistentes'] = $asistentesActuales;
    $datos['idsAsistentes'] = $idsActuales;
    $votacion = $this->votaciones_model->getVotacion($misDatos['id']);
    $this->load->view('secretario/modificarVotacion_view', $datos);
    //$this->llamarVistasModificar($votacion->Id_TipoVotacion,$datos);


  }

  private function recargarDatosVotacion($misDatos,$asistentesRecibidos)
  {
    if($this->session->userdata('rol') == 'Secretario')
      {
        $this->load->view('elementos/headerSecretario');
      }
      if($this->session->userdata('rol') == 'SecretarioDelegado')
      {
      $this->load->view('elementos/headerDelegado');
      }
    $votacion = $this->votaciones_model->getVotacion($misDatos['id']);

    // SACAR CENSOS
    $censosVotacion = $this->censo_model->getCensosfromVotacion($misDatos['id']);
    $nombreCensos = $this->censo_model->getCensos();

    // CHECKBOXES ENCENDIDOS
    $soloAsistentes = false;
    if($misDatos['soloAsistentes'] == 1){$soloAsistentes = true;}

    $esModificable = false;
    if($votacion->VotoModificable == 1){$esModificable = true;}

    // SACAR ASISTENTES SI LA VOTACIÓN TIENE CENSO ASISTENTE
    $idsAsistentes = array();
    $asistentesNombre = array();
    $asistentes = array();
    $mensaje = null;
    if($soloAsistentes && $asistentesRecibidos == NULL )
    {
      $usuariosAsistentes = $this->censo_model->getCensoAsistente($misDatos['id']);
      foreach($usuariosAsistentes as $asistente)
      {$idsAsistentes[] = $asistente->Id_Usuario;}

      // EXTRAER NOMBRES DE USUARIOS ASOCIADOS A ESOS IDS
      foreach($idsAsistentes as $id)
      {$asistentesNombre[] = $this->usuario_model->getUserNameFromId($id);}

      foreach($asistentesNombre as $nombre)
      {$asistentes[] = $nombre[0]->NombreUsuario;}

    }
    else
    {
      $idsAsistentes = $asistentesRecibidos;
      foreach($idsAsistentes as $id)
      {$asistentesNombre[] = $this->usuario_model->getUserNameFromId($id);}

      foreach($asistentesNombre as $nombre)
      {$asistentes[] = $nombre[0]->NombreUsuario;}
      $mensaje = 'Seleccione abajo el censo asistente';
    }
    $datos = array(
      'censos' => $nombreCensos,
      'votaciones' => $votacion,
      'censosVotacion' => $censosVotacion,
      'pulsadoAsistentes' => $soloAsistentes,
      'pulsadoModificar' => $esModificable,
      'asistentes' => $asistentes,
      'idsAsistentes' => $idsAsistentes,
      'asistentesExistentes' => true,
      'mensaje' => $mensaje,
      'ultimoPaso' => true
    );
    $this->load->view('secretario/modificarVotacion_view', $datos);


  }

  private function mostrarErrores($misDatos)
  {
    if($this->session->userdata('rol') == 'Secretario')
    {$this->load->view('elementos/headerSecretario');}
    if($this->session->userdata('rol') == 'SecretarioDelegado')
    {$this->load->view('elementos/headerDelegado');}

    $totales = $this->censo_model->getUsuariosfromVotacion($misDatos['id']);
    $idsTotales = array();
    foreach($totales as $usuario)
    {$idsTotales[] = $usuario->Id_Usuario;}
    $this->recargarDatosVotacion($misDatos,$idsTotales);
    //$this->load->view('secretario/modificarVotacion_view', $datos);
  }

  private function extraerUsuariosCensos($censos)
  {

    $usuariosRestantes = array();
   foreach($censos as $censo)
   {
    $usuariosRestantes[] = $this->censo_model->getUsuariosFromCenso($censo);
   }
   $usuariosFinales = array();
   foreach($usuariosRestantes as $conjunto)
     foreach($conjunto as $usuario)
     $usuariosFinales[] = $usuario->Id_Usuario;

    return $usuariosFinales;
  }

  private function getUsuariosAEliminar($usuariosActuales,$idVotacion,$idCenso)
  {
    // Obtener censos de usuarios Actuales del censo de mi votacion
    foreach($usuariosActuales as $actual)
      $censosUsuarios[]= $this->censo_model->getCensosFromUsuarios($actual->Id_Usuario);

    // Extraer usuarios de ese censo concreto que quiero borrar
    $borrarUsuarios = $this->censo_model->getUsuariosFromCenso($idCenso);

    $finales = array();
    foreach($borrarUsuarios as $aBorrar)
    {
      // Obtener los ids de los censos de estos usuarios a borrar
      $susCensos = $this->censo_model->getWhereUsuario($aBorrar->Id_Usuario);

      if(sizeof($susCensos) == 1)
      {
        // SOLO ESTÁ EN UN CENSO, ¿Es el mio?
        if($susCensos[0]->Id_Fichero == $idCenso)
          {$finales[] = $susCensos[0]->Id_Usuario; }
      }
    }

    return $finales;
  }

  private function eliminarVotoUsuarios($usuarios,$idVotacion)
  {$this->voto_model->borrarVoto($usuarios,$idVotacion);}

  private function eliminarCenso($censosVotacion,$censo,$idVotacion)
  {
    // Extraer id de ese censo que quiero eliminar
    $idCenso = $this->censo_model->getId($censo);

    // BORRAR USUARIOS DEL CENSO DE UNA VOTACION
    $usuariosActuales = $this->censo_model->getUsuariosfromVotacion($idVotacion);
    $usuariosEliminar = $this->getUsuariosAEliminar($usuariosActuales,$idVotacion,$idCenso);

    // Eliminar esos usuarios de una votacion concreta
    foreach($usuariosEliminar as $usuario)
    {$this->censo_model->eliminarUsuarios($usuario,$idVotacion);}

    // Eliminar voto de esos usuarios
    $this->eliminarVotoUsuarios($usuariosEliminar,$idVotacion);

    // Eliminar num votos de recuento
    $this->actualizarRecuento($idVotacion,$usuariosEliminar,'eliminar');


    // BORRAR MIEMBROS DE LA MESA ELECTORAL
    $miMesa = $this->mesa_model->getMesa($idVotacion);
    $usuariosMesa = array();
    foreach($miMesa as $dato)
    {$usuariosMesa[] = $dato->Id_Usuario;}
    // Notificar a los usuariosMesa de la mesa que se va a la puta

    // Borrar la mesa electoral
    $this->mesa_model->deleteMesa($idVotacion);

    // RENOVAR LA MESA ELECTORAL
    $miMesa = $this->mesa_model->getMesa($idVotacion);

    // Obtener censos restantes de esa votacion (excluyendo el que se va a eliminar)
    $censosRestantes = array();
    foreach($censosVotacion as $existente)
    {
      if($existente != $idCenso) $censosRestantes[] = $existente;
    }

    // OBTENER USUARIOS DE ESE CENSO
    $usuariosRestantes = array();
    foreach($censosRestantes as $restante)
    {
      $nombre = $this->censo_model->getNombreCensoFromId($restante);
      $usuarios = $this->extraerUsuariosFichero($nombre);
      $usuariosIds = $this->extraerIdsUsuarios($usuarios);
      foreach($usuariosIds as $id)
      {$usuariosRestantes[] = $id;}

    }

    $this->generarMesaElectoral($usuariosRestantes,$idVotacion);

    // Eliminar relacion con el fichero de censo
    $this->censo_model->eliminarCenso($idVotacion,$idCenso);
  }

  private function eliminarCensoAsistente($censo,$idVotacion)
  {
    // Extraer id de ese censo que quiero eliminar
    $censosVotacion = $this->censo_model->getCensosfromVotacion($idVotacion);
    $idCenso = $this->censo_model->getId($censo);
    $usuariosActuales = $this->censo_model->getCensoAsistente($idVotacion);
    $usuariosEliminar = $this->getUsuariosAEliminar($usuariosActuales,$idVotacion,$idCenso);

    // Eliminar esos usuarios del censo asistente y del censo
    foreach($usuariosEliminar as $usuario)
    {
      $this->censo_model->eliminarUsuariosAsistentes($usuario,$idVotacion);
      $this->censo_model->eliminarUsuarios($usuario,$idVotacion);
    }
    // Eliminar relacion con el fichero de censo
    $this->censo_model->eliminarCenso($idVotacion,$idCenso);

    // Eliminar voto de esos usuarios
    $this->eliminarVotoUsuarios($usuariosEliminar,$idVotacion);

    // Eliminar num votos de recuento
    $this->actualizarRecuento($idVotacion,$usuariosEliminar,'eliminar');

    // BORRAR MIEMBROS DE LA MESA ELECTORAL
    $miMesa = $this->mesa_model->getMesa($idVotacion);
    $usuariosMesa = array();
    foreach($miMesa as $dato)
    {$usuariosMesa[] = $dato->Id_Usuario;}
    // Notificar a los usuariosMesa de la mesa que se va a la puta

    // Borrar la mesa electoral
    $this->mesa_model->deleteMesa($idVotacion);

    // RENOVAR LA MESA ELECTORAL
    $miMesa = $this->mesa_model->getMesa($idVotacion);

    // Obtener censos restantes de esa votacion (excluyendo el que se va a eliminar)
    $censosRestantes = array();
    foreach($censosVotacion as $censo)
    {if($censo->Id_Fichero != $idCenso) $censosRestantes[] = $censo->Id_Fichero;}

    // OBTENER USUARIOS DE TODOS CENSOS
    $usuariosRestantes = $this->extraerUsuariosCensos($censosRestantes);
    $this->generarMesaElectoral($usuariosRestantes,$idVotacion);

    /*// OBTENER USUARIOS DE ESE CENSO
    $usuariosRestantes = array();
    foreach($censosRestantes as $restante)
    {
      $nombre = $this->censo_model->getNombreCensoFromId($restante);
      $usuarios = $this->extraerUsuariosFichero($nombre);
      $usuariosIds = $this->extraerIdsUsuarios($usuarios);
      foreach($usuariosIds as $id)
      {$usuariosRestantes[] = $id;}

    }

    $this->generarMesaElectoral($usuariosRestantes,$idVotacion);*/

  }

  private function addCenso($censosVotacion,$censo,$idVotacion)
  {
    // Extraer ID del censo que voy a añadir
    $idCenso =$this->censo_model->getId($censo);
    $censoExtraer[] = $idCenso;

    // Extraer usuarios de ese censo a añadir
    $usuarios = $this->extraerUsuariosFichero($censo);
    $usuariosAñadir = $this->extraerIdsUsuarios($usuarios);
    // RELACIONAR USUARIOS CON ESTE CENSO
    for($j = 0; $j < sizeof($usuariosAñadir); $j++)
    {
      // Relacionar este usuario con este censo en la bd
      $this->censo_model->setUsuarioCenso($usuariosAñadir[$j],$idCenso);
    }


    // Extraer usuarios que están actualmente en el censo de esa votacion
    $totales = $this->censo_model->getUsuariosfromVotacion($idVotacion);
    $idsTotales = array();
    foreach($totales as $usuario)
    {$idsTotales[] = $usuario->Id_Usuario;}

    // Obtener solo usuarios sin repetir
    $finales = array();
    for($i = 0; $i < sizeof($usuariosAñadir);$i++)
    {
      if(!in_array($usuariosAñadir[$i],$idsTotales))
      {
        array_push($finales,$usuariosAñadir[$i]);
      }
    }

    // METER TODOS LOS USUARIOS EXTRAIDOS SIN REPETIR EN EL CENSO
    $noGuardadoCenso = $this->insertarUsuariosCenso($finales,$idVotacion);

    // ENCRIPTAR USUARIOS PARA QUE TENGAN ABSTENIDOS POR DEFECTO
    $votoUsuarioDefecto = $this->voto_model->votoDefecto($finales,$idVotacion,1);

    // MODIFICAR EL RECUENTO DE DICHA VOTACION
    $this->actualizarRecuento($idVotacion,$finales,'añadir');

    // GENERAR MIEMBROS DE LA MESA ELECTORAL
    $miMesa = $this->mesa_model->getMesa($idVotacion);
    // Obtener usuarios actuales de la mesa electoral
    $usuariosMesa = array();
    foreach($miMesa as $dato)
    {$usuariosMesa[] = $dato->Id_Usuario;}

    // Notificar a los usuariosMesa de la mesa que se modifica pq se añade un censo
    foreach($usuariosMesa as $id)
    {
      // Obtener correo de ese miembro
      $miembroNuevo = $this->usuario_model->getUsuario($id);
      $asunto = '[NOTIFICACIÓN VOTUCA] Modificación mesa electoral.';
      $mensaje = '<h1>Su mesa electoral ha sido modificada</h1>
      Se ha modificado el censo de la votación '.$idVotacion.'. Usted ya no es miembro de la mesa hasta nuevo aviso.

      <p>Coordialmente, la administración de VotUCA.</p>
      ';
      //echo var_dump($miembroNuevo);
      $result = $this->mailing->sendEmail($miembroNuevo[0]->NombreUsuario, $asunto, $mensaje);
    }

    // Borrar la mesa electoral
    $this->mesa_model->deleteMesa($idVotacion);

    // Obtener censos todos los censos que esta votación va a tener ahora
    $censosRestantes = array($idCenso);
    foreach($censosVotacion as $censo)
    {if($censo != $idCenso) $censosRestantes[] = $censo;}

    // OBTENER USUARIOS DE TODOS CENSOS
    $usuariosRestantes = $this->extraerUsuariosCensos($censosRestantes);
    $this->generarMesaElectoral($usuariosRestantes,$idVotacion);

    // RELACIONAR EL FICHERO DE ESE CENSO CON LA VOTACION
    $this->censo_model->insertarVotacion($idVotacion,$idCenso);

  }

  private function actualizarRecuento($idVotacion,$usuariosFinales,$accion)
  {
    foreach($usuariosFinales as $usuario)
    {
      // Obtiene grupos de ese usuario
      $grupos = $this->usuario_model->getUserGroups($usuario);
      switch($accion)
      {
        case 'añadir':
        $censoTotal= $this->votaciones_model->contarUsuarios('censo',$idVotacion);
        $this->voto_model->actualizarRecuentoTotal($idVotacion,4,1,$censoTotal[0]->total);
        foreach($grupos as $grupo)
        {$this->voto_model->incrementarAbstenidos($idVotacion,$grupo->Id_Grupo);}
        break;

        case 'eliminar':
        $censoTotal= $this->votaciones_model->contarUsuarios('censo',$idVotacion);
        $this->voto_model->actualizarRecuentoTotal($idVotacion,4,1,$censoTotal[0]->total);
        foreach($grupos as $grupo)
        {$this->voto_model->decrementarAbstenidos($idVotacion,$grupo->Id_Grupo);}
        break;
      }
    }
  }

  private function addCensoAsistente($censo,$idVotacion)
  {
    // Extraer ID del censo que voy a añadir
    $idCenso = $this->censo_model->getId($censo);
    $censosVotacion = $this->censo_model->getCensosfromVotacion($idVotacion);
    $censoExtraer[] = $idCenso;

    // Extraer usuarios de ese censo a añadir
    //$usuariosAñadir = $this->extraerUsuariosCensos($censoExtraer);
    $usuarios = $this->extraerUsuariosFichero($censo);
    $usuariosAñadir = $this->extraerIdsUsuarios($usuarios);
    // RELACIONAR USUARIOS CON ESTE CENSO
    for($j = 0; $j < sizeof($usuariosAñadir); $j++)
    {
      // Relacionar este usuario con este censo en la bd
      $this->censo_model->setUsuarioCenso($usuariosAñadir[$j],$idCenso);
    }

    // Extraer usuarios que están actualmente en el censo asistente de esa votacion
    $totales = $this->censo_model->getCensoAsistente($idVotacion);
    $idsTotales = array();
    foreach($totales as $usuario)
    {$idsTotales[] = $usuario->Id_Usuario;}

    // Obtener solo usuarios sin repetir
    $finales = array();
    for($i = 0; $i < sizeof($usuariosAñadir);$i++)
    {
      if(!in_array($usuariosAñadir[$i],$idsTotales))
      {
        array_push($finales,$usuariosAñadir[$i]);
      }
    }

    // METER TODOS LOS USUARIOS EXTRAIDOS SIN REPETIR EN EL CENSO ASISTENTE
    $noGuardadoCenso = $this->censo_model->insertarCensoAsistente($finales,$idVotacion);
    $noGuardadoCenso = $this->insertarUsuariosCenso($finales,$idVotacion);

    // RELACIONAR EL FICHERO DE ESE CENSO CON LA VOTACION
    $this->censo_model->insertarVotacion($idVotacion,$idCenso);

    // ENCRIPTAR USUARIOS PARA QUE TENGAN ABSTENIDOS POR DEFECTO
    $votoUsuarioDefecto = $this->voto_model->votoDefecto($finales,$idVotacion,1);

    // MODIFICAR EL RECUENTO DE DICHA VOTACION
    $this->actualizarRecuento($idVotacion,$finales,'añadir');

    // GENERAR MIEMBROS DE LA MESA ELECTORAL
    $miMesa = $this->mesa_model->getMesa($idVotacion);
    // Obtener usuarios actuales de la mesa electoral
    $usuariosMesa = array();
    foreach($miMesa as $dato)
    {$usuariosMesa[] = $dato->Id_Usuario;}

    // Notificar a los usuariosMesa de la mesa que se modifica pq se añade un censo
    foreach($usuariosMesa as $id)
    {
      // Obtener correo de ese miembro
      $miembroNuevo = $this->usuario_model->getUsuario($id);
      $asunto = '[NOTIFICACIÓN VOTUCA] Modificación mesa electoral.';
      $mensaje = '<h1>Su mesa electoral ha sido modificada</h1>
      Se ha modificado el censo de la votación '.$idVotacion.'. Usted ya no es miembro de la mesa hasta nuevo aviso.

      <p>Coordialmente, la administración de VotUCA.</p>
      ';
      //echo var_dump($miembroNuevo);
      $result = $this->mailing->sendEmail($miembroNuevo[0]->NombreUsuario, $asunto, $mensaje);
    }

    // Borrar la mesa electoral
    $this->mesa_model->deleteMesa($idVotacion);

    // Obtener todos los censos que esta votación va a tener ahora
    $censosRestantes = array($idCenso);
    foreach($censosVotacion as $censo)
    {if($censo->Id_Fichero != $idCenso) $censosRestantes[] = $censo->Id_Fichero;}

    // OBTENER USUARIOS DE TODOS CENSOS
    $usuariosRestantes = $this->extraerUsuariosCensos($censosRestantes);
    $this->generarMesaElectoral($usuariosRestantes,$idVotacion);

  }

  private function actualizarVotacionDatos($publicar)
  {
    $soloAsistentes = false;
    if(isset($_POST['soloAsistentes']) && $_POST['soloAsistentes']  == 1){$soloAsistentes = true;}

    $esModificable = false;
    if(isset($_POST['esModificable']) && $_POST['esModificable'] == 1){$esModificable = true;}

    $recuentoParalelo = false;
    if(isset($_POST['recuentoParalelo']) && $_POST['recuentoParalelo'] == 1){$recuentoParalelo = true;}
    $datos = array(
      'Titulo' => $_POST['titulo'],
      'Descripcion' => $_POST['descripcion'],
      'FechaInicio' => $_POST['fecha_inicio'],
      'FechaFinal' => $_POST['fecha_final'],
      'isDeleted' => false,
      'esBorrador' => $publicar,
      'Finalizada' => false,
      'Quorum' => $_POST['quorum'],
      'Invalida' => false,
      'VotoModificable' => $esModificable,
      'SoloAsistentes' => $soloAsistentes,
      'recuentoParalelo' => $recuentoParalelo,
      'NumOpciones' => $_POST['NumOpciones']
    );

    return $datos;
  }

  private function modificarSoloCensos($idVotacion)
  {
    $censosVotacion = $this->censo_model->getCensosfromVotacion($idVotacion);
    $censosEliminar = $this->input->post('censoEliminacion');
    $censosAñadir = $this->input->post('censo');
    $idsCensos = array();
    foreach($censosVotacion as $censo)
    {$idsCensos[] = $censo->Id_Fichero;}

    if($censosEliminar != NULL)
    {  // Hay censos a eliminar
      foreach($censosEliminar as $censo)
      {
        $this->eliminarCenso($idsCensos,$censo,$idVotacion);
        --$idsCensos;
      }
    }
    // AÑADIR CENSOS
    if($censosAñadir != NULL)
    {
      foreach($censosAñadir as $censo)
      {
        $this->addCenso($idsCensos,$censo,$idVotacion);
      }
    }
  }

  private function actualizarAsistentes($idVotacion,$asistentes,$accion)
  {
    if($accion == 'resetear')
    {
      $votacion = $this->votaciones_model->getVotacion($idVotacion);
      $this->censo_model->eliminarTodoCenso($idVotacion);
      $this->censo_model->eliminarTodosAsistentes($idVotacion);
      $this->voto_model->eliminarCestoCompleto($idVotacion);
      $this->voto_model->eliminarUrnaCompleta($idVotacion);

      //Metemos los nuevos asistentes (aunque sean los mismos)
      $noGuardadoCenso = $this->insertarUsuariosCenso($asistentes,$idVotacion);
      $noGuardadoCenso = $this->censo_model->insertarCensoAsistente($asistentes,$idVotacion);
      $votoUsuarioDefecto = $this->voto_model->votoDefecto($asistentes,$idVotacion,1);
      $this->generarNumeroVotos($idVotacion,$votacion->Id_TipoVotacion);


      /*// GENERAR MESA ELECTORAL
      // GENERAR MIEMBROS DE LA MESA ELECTORAL
      $miMesa = $this->mesa_model->getMesa($idVotacion);
      // Obtener usuarios actuales de la mesa electoral
      $usuariosMesa = array();
      foreach($miMesa as $dato)
      {$usuariosMesa[] = $dato->Id_Usuario;}

      // Notificar a los usuariosMesa de la mesa que se modifica pq se añade un censo
      foreach($usuariosMesa as $id)
      {
        // Obtener correo de ese miembro
        $miembroNuevo = $this->usuario_model->getUsuario($id);
        $asunto = '[NOTIFICACIÓN VOTUCA] Modificación mesa electoral.';
        $mensaje = '<h1>Su mesa electoral ha sido modificada</h1>
        Se ha modificado el censo de la votación '.$idVotacion.'. Usted ya no es miembro de la mesa hasta nuevo aviso.

        <p>Coordialmente, la administración de VotUCA.</p>
        ';
        //echo var_dump($miembroNuevo);
        $result = $this->mailing->sendEmail($miembroNuevo[0]->NombreUsuario, $asunto, $mensaje);
      }

      // Borrar la mesa electoral
      $this->mesa_model->deleteMesa($idVotacion);

      $this->generarMesaElectoral($asistentes,$idVotacion);*/
    }

    if($accion == 'transferirCenso')
    {
      $this->censo_model->insertarCensoAsistente($asistentes,$idVotacion);
    }

    if($accion == 'llamarNuevos')
    {
      // Sacar usuarios del censo de esa votacion
      $totales = $this->censo_model->getUsuariosfromVotacion($idVotacion);
      $idsTotales = array();
      foreach($totales as $usuario)
      {$idsTotales[] = $usuario->Id_Usuario;}

      // Obtener usuarios del censo actual
      $asistentesActuales = $idsTotales;
      if(isset($_POST['asistentes']))
      {$asistentesActuales = $_POST['asistentes'];}

      $censos = $asistentes;
      $totales = array();
      foreach ($censos as $nombreCenso)
      {
        $usuarios = $this->extraerUsuariosFichero($nombreCenso);
        $usuariosIds = $this->extraerIdsUsuarios($usuarios);
        for($j = 0; $j < sizeof($usuariosIds); $j++)
        {
          if(!in_array($usuariosIds[$j],$asistentesActuales))
          {array_push($totales,$usuariosIds[$j]);}
        }
      }
      $this->recargarDatosVotacion($_POST,$totales);


    }

    if($accion == 'añadirAsistentes')
    {
      $noGuardadoCenso = $this->censo_model->insertarCensoAsistente($asistentes,$idVotacion);
      $noGuardadoCenso = $this->insertarUsuariosCenso($asistentes,$idVotacion);
      $censos = $_POST['censo'];
      foreach($censos as $nombreCenso)
      {
        $idCenso = $this->censo_model->getId($nombreCenso);
        foreach($asistentes as $asistente)
        $this->censo_model->setUsuarioCenso($asistente,$idCenso);
      }


      // Ver si podemos relacionar un fichero de censo con esta votacion
      $totales = $this->censo_model->getUsuariosfromVotacion($idVotacion);
      $idsTotales = array();
      foreach($totales as $usuario)
      {$idsTotales[] = $usuario->Id_Usuario;}

      $censos = $_POST['censo'];
      foreach($censos as $censo)
      {
        $idCenso =$this->censo_model->getId($censo);
        $censoExtraer[] = $idCenso;

        // Extraer usuarios de ese censo a añadir
        $usuarios = $this->extraerUsuariosFichero($censo);
        $usuariosCenso = $this->extraerIdsUsuarios($usuarios);
        $totales = sizeof($usuariosCenso);
        $contador = 0;
        foreach($idsTotales as $usuarioAnalizar)
        {
          if(in_array($usuarioAnalizar,$usuariosCenso))
          {$contador = $contador + 1;}
        }
        if($contador == $totales)
        {
          $this->censo_model->insertarVotacion($idVotacion,$idCenso);
        }
      }

      // ENCRIPTAR USUARIOS PARA QUE TENGAN ABSTENIDOS POR DEFECTO
      $votoUsuarioDefecto = $this->voto_model->votoDefecto($asistentes,$idVotacion,1);

      // MODIFICAR EL RECUENTO DE DICHA VOTACION
      $this->actualizarRecuento($idVotacion,$asistentes,'añadir');

      // GENERAR MIEMBROS DE LA MESA ELECTORAL
      /*$miMesa = $this->mesa_model->getMesa($idVotacion);
      // Obtener usuarios actuales de la mesa electoral
      $usuariosMesa = array();
      foreach($miMesa as $dato)
      {$usuariosMesa[] = $dato->Id_Usuario;}

      // Notificar a los usuariosMesa de la mesa que se modifica pq se añade algo al censo
      foreach($usuariosMesa as $id)
      {
        // Obtener correo de ese miembro
        $miembroNuevo = $this->usuario_model->getUsuario($id);
        $asunto = '[NOTIFICACIÓN VOTUCA] Modificación mesa electoral.';
        $mensaje = '<h1>Su mesa electoral ha sido modificada</h1>
        Se ha modificado el censo de la votación '.$idVotacion.'. Usted ya no es miembro de la mesa hasta nuevo aviso.

        <p>Coordialmente, la administración de VotUCA.</p>
        ';
        //echo var_dump($miembroNuevo);
        $result = $this->mailing->sendEmail($miembroNuevo[0]->NombreUsuario, $asunto, $mensaje);
      }

      // Borrar la mesa electoral
      $this->mesa_model->deleteMesa($idVotacion);


      $totales = $this->censo_model->getUsuariosfromVotacion($idVotacion);
      foreach($totales as $usuario)
      {$idsTotales[] = $usuario->Id_Usuario;}
      $this->generarMesaElectoral($idsTotales,$idVotacion);*/

    }

    if($accion == 'eliminarAsistencia')
    {
      $this->censo_model->eliminarTodosAsistentes($idVotacion);
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
      //$this->load->view('elementos/footer');
    }
  }

  public function aceptarDelegacion()
  {
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
     $this->load->view('secretario/borradores_view',$datos);
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
    if($fechaInicio <= $hoy){
        $this->form_validation->set_message('validarFechaInicio','Introduzca bien la fecha %s');
        return FALSE;
    }
    else{
      //echo "Devuelvo true inicio";
      return TRUE;
    }
  }

  public function validarFechaFinal(){
    $fechaInicio = date('Y-m-d H:i:s',strtotime($this->input->post('fecha_inicio')));
    $fechaFinal = date('Y-m-d H:i:s',strtotime($this->input->post('fecha_final')));
    $hoy = date('Y-m-d H:i:s');
    if($fechaFinal <= $fechaInicio){
        $this->form_validation->set_message('validarFechaFinal','Introduzca bien la fecha %s');
        return FALSE;
    }
    else{
      //echo "Devuelvo true final";
      return TRUE;
    }
  }

  public function validarOpciones()
  {
    $opciones = explode(",",$this->input->post('opciones'));
    $numero = $this->input->post('nOpciones');
    if(sizeof($opciones) < $numero)
    {
      $this->form_validation->set_message('validarOpciones','Introduzca al menos '.$numero.' opciones');
      return FALSE;
    }
    else{return TRUE;}
  }

  public function validarQuorum()
  {
    $quorum = $this->input->post('quorum');
    if($quorum < 0 || $quorum > 1)
    {
      $this->form_validation->set_message('validarQuorum','Introduzca un quorum válido (entre 0 y 1)');
      return FALSE;
    }
    else{return TRUE;}
  }

  public function validarFicherosCenso(){
    $soloAsistentes = $this->input->post('soloAsistentes');
    $asistentes = $this->input->post('asistentes');
    $elegidos = $this->input->post('censo');
    if($soloAsistentes)
    {
      if($asistentes != NULL)
      {
        if(sizeof($asistentes) < 3)
        {
          if($elegidos == NULL || sizeof($elegidos) < 1)
          {
            $this->form_validation->set_message('validarFicherosCenso','Introduzca al menos un fichero de censo');
            return FALSE;
          }
          else{return TRUE;}
        }
      }
      else // NO HAY ASISTENTES PERO HAS PULSADO ASISTENTES
      {
        if($elegidos == NULL || sizeof($elegidos) < 1)
        {
          $this->form_validation->set_message('validarFicherosCenso','Introduzca al menos un fichero de censo');
          return FALSE;
        }
        else{return TRUE;}
      }
    }
    else
    {
      if($elegidos == NULL || sizeof($elegidos) < 1)
      {
        $this->form_validation->set_message('validarFicherosCenso','Introduzca al menos un fichero de censo');
        return FALSE;
      }
      else{return TRUE;}
    }
  }

  public function validarAsistentes(){
    $elegidos = $this->input->post('asistentes');
    if($elegidos == NULL || sizeof($elegidos) < 3)
    {
      $this->form_validation->set_message('validarAsistentes','Introduzca al menos tres usuarios asistentes');
      return FALSE;
    }
    else{return TRUE;}
  }

  public function usuariosAleatorios($usuariosDisponibles)
  {
    $elegidos = array_rand($usuariosDisponibles,3);
    return $elegidos;
  }

  /*public function enviarCorreo($elegido,$idVotacion,$titulo,$contenido){
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
    $this->email->to($elegido[0]->Email);
    $this->email->subject($titulo);
    $this->email->message($contenido);

    $this->email->set_newline("\r\n");
    if($this->email->send()){
    }else{echo $this->email->print_debugger();}
  }*/


}



?>
