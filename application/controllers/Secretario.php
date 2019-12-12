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


  // FUNCION QUE LLAMA A LAS VISTAS
  public function crearVotacion($tipo = '')
  {
    $adicionales = array();
    $this->load->view('elementos/headerSecretario');

    // CENSO
    $nombreCensos = $this->censo_model->getCensos();
    $datos = array(
      'censos' => $nombreCensos
    );
    switch($tipo)
    {
      case 'simple':
        $datos += array('soloAsistentes' => true);
        $this->load->view('secretario/votacionSimple_view',$datos);
        break;
      case 'compleja':
      $datos += array('soloAsistentes' => true);
      $this->load->view('secretario/votacionCompleja_view',$datos);
      break;
    }
    //$this->load->view('elementos/footer');*/
  }

  private function mostrarAsistentes($tipo)
  {
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
          'censos' => $nombreCensos,
          'asistentes' => $nombresUsuarios
          );
      switch($tipo)
      {
        case 'simple':
          $datos += array('soloAsistentes' => true);
          $this->load->view('elementos/headerSecretario');
          $this->load->view('secretario/votacionSimple_view',$datos);
          break;
        case 'compleja':
          $datos += array('soloAsistentes' => true);
          $this->load->view('secretario/votacionCompleja_view',$datos);
          break;
      }

  }

  private function validaciones($validarAsistentes)
  {
    $this->form_validation->set_rules('titulo','Titulo','required');
    $this->form_validation->set_rules('descripcion','Descripcion','required');
    $this->form_validation->set_rules('inicio','Fecha Inicio','required');
    $this->form_validation->set_rules('final','Fecha Final','required');
    $this->form_validation->set_rules('inicio','Fecha Inicio','callback_validarFechaInicio');
    $this->form_validation->set_rules('final','Fecha Final','callback_validarFechaFinal');
    if($validarAsistentes == true)
    {$this->form_validation->set_rules('asistentes','Asistentes','callback_validarAsistentes');}

    // MENSAJES DE ERROR.
    $this->form_validation->set_message('required','El campo %s es obligatorio');
    return $this->form_validation->run();
  }

  private function prepararVotacion($tipo)
  {
    $fechaInicio = date('Y-m-d H:i:s',strtotime($this->input->post('fecha_inicio')));
    $fechaFin = date('Y-m-d H:i:s',strtotime($this->input->post('fecha_final')));

    $esModificable = false;
    if($this->input->post('esModificable') != NULL)
        $esModificable = true;

    switch($tipo)
    {
      case 'simple':
      $votacion = new Votacion(
      //$this->input->post('id'),
          1,
          $this->input->post('titulo'),
          $this->input->post('descripcion'),
          $fechaInicio,
          $fechaFin,
          false,
          false,
          false,
          false,
          $this->input->post('quorum'),
          $esModificable,
          false,
          false,
          1


        );
        break;

        case 'compleja':
        $votacion = new Votacion(
          //$this->input->post('id'),
          2,
          $this->input->post('titulo'),
          $this->input->post('descripcion'),
          $fechaInicio,
          $fechaFin,
          false, // Deleted
          false, // EsBorrador
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

  private function aceptarInsercion($tipo)
  {
    // CREAR VOTACION EN BASE A SU TIPO
    $votacion = $this->prepararVotacion($tipo);
    $this->guardarVotacion($votacion);
  }

  public function insertarVotacion($tipo)
  {
    if($this->input->post('submit_reg')) // Si se ha pulsado el botón enviar
    {
      if($this->input->post('soloAsistentes') != NULL && $this->input->post('censo') != NULL)
      {$this->mostrarAsistentes($tipo);}
      else // NO SE HAN INTRODUCIDO ASISTENTES O LOS ACABAS DE INTRODUCIR
      {
        if($this->input->post('asistentes') != NULL) // SI HAS ELEGIDO ASISTENTES
        {
          if($this->validaciones(true) == FALSE) // HAY ALGUN ERROR AL INTRODUCIR DATOS
          {{$this->crearVotacion($tipo);}}
          else{$this->aceptarInsercion($tipo);} // NO HAY ERROR EN VALIDACIONES
        }
        if($this->input->post('asistentes') == NULL) // NO HAY ASISTENTES, SOLO CENSO
        {
          if($this->validaciones(false) == FALSE) // Hay algun error
          {$this->crearVotacion($tipo);} // Mostrar mensajes de error en la vista
          else{$this->aceptarInsercion($tipo);}

        }
      }
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
      $this->usuario_model->insertUserAs((int)$elegidos[$i],5,'m');

      // Crear el nuevo nombre de usuario
      $idUsuario = (int)$elegidos[$i];
      $nombre = $this->obtenerNombreElectoral($idUsuario,'m');
      $miembro = $this->usuario_model->getIdFromUserName($nombre);
      $this->mesa_model->insertar($miembro[0]->Id,$idVotacion);

    }
    // Enviar correo a cada elegido en la mesa electoral
    //$this->enviarCorreo($elegidos[$i],$ultimoId);  // FUNCIONA
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
    //echo var_dump($usuariosIds);
    $this->censo_model->insertar($usuariosIds,$idVotacion);
  }

  private function guardarSusOpciones($idVotacion,$tipo)
  {
    if($tipo == 1 || $tipo == 3)
    {
      $misVotos = array(1,2,3);
      $this->voto_model->insertarOpciones($idVotacion,$misVotos);
    }
    else{
      echo 'OTRO TIPO';
    }
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

        // MESA ELECTORAL
        $this->generarMesaElectoral($totales,$idVotacion);
      }
      else
      {  // GUARDAR ASISTENTES
        // GUARDAR VOTACION
        $noGuardado = $this->votaciones_model->guardarVotacion($datos);
        $idVotacion = $this->votaciones_model->getLastId();

        // RELACION LA VOTACION CON SUS POSIBLES OPCIONES
        $this->guardarSusOpciones($idVotacion,$datos->getTipo());

        // METER TODOS LOS USUARIOS EXTRAIDOS EN EL CENSO ASISTENTES
        $noGuardadoCenso = $this->censo_model->insertarCensoAsistente($asistentes,$idVotacion);
        $this->censo_model->insertar($asistentes,$idVotacion);
        // ENCRIPTAR USUARIOS PARA QUE TENGAN ABSTENIDOS POR DEFECTO
        $votoUsuarioDefecto = $this->voto_model->votoDefecto($asistentes,$idVotacion,1);

        // MESA ELECTORAL
        $this->generarMesaElectoral($asistentes,$idVotacion);
      }



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

  // FUNCIÓN QUE MUESTRA LA VISTA DE MODIFICAR VOTACION
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
      // Obtener los censos de este usuario a borrar
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
    $numCensos = sizeof($censosVotacion);

    if($numCensos > 1) // Si una votación tiene más de un censo asignado...
    {
      // BORRAR USUARIOS DEL CENSO DE UNA VOTACION
      $usuariosActuales = $this->censo_model->getUsuariosfromVotacion($idVotacion);
      $usuariosEliminar = $this->getUsuariosAEliminar($usuariosActuales,$idVotacion,$idCenso);
      // Eliminar esos usuarios de una votacion concreta
      foreach($usuariosEliminar as $usuario)
      {$this->censo_model->eliminarUsuarios($usuario,$idVotacion);}
      // Eliminar voto de esos usuarios
      $this->eliminarVotoUsuarios($usuariosEliminar,$idVotacion);


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
      {
        if($censo != $idCenso) $censosRestantes[] = $censo;
      }

      // OBTENER USUARIOS DE ESE CENSO
      $usuariosRestantes = $this->extraerUsuariosCensos($censosRestantes);
      $this->generarMesaElectoral($usuariosRestantes,$idVotacion);

      // Eliminar relacion con el fichero de censo
      $this->censo_model->eliminarCenso($idVotacion,$idCenso);

    } // Fin hay varios censos

    /*else
    {
      // Extraer usuarios de ese censo concreto que quiero borrar
      $borrarUsuarios = $this->censo_model->getUsuariosFromCenso($idCenso);
      foreach($borrarUsuarios as $usuario)
      {
        $this->censo_model->eliminarUsuarios($usuario->Id_Usuario,$idVotacion);
      }
      // Eliminar relacion con el fichero de censo
      $this->censo_model->eliminarCenso($idVotacion,$idCenso);
    }*/


  }

  public function addCenso($censosVotacion,$censo,$idVotacion)
  {
    // Extraer ID del censo que voy a añadir
    $idCenso = $this->censo_model->getId($censo);
    $censoExtraer[] = $idCenso;

    // Extraer usuarios de ese censo a añadir
    $usuariosAñadir = $this->extraerUsuariosCensos($censoExtraer);

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

    // GENERAR MIEMBROS DE LA MESA ELECTORAL
    $miMesa = $this->mesa_model->getMesa($idVotacion);
    // Obtener usuarios actuales de la mesa electoral
    $usuariosMesa = array();
    foreach($miMesa as $dato)
    {$usuariosMesa[] = $dato->Id_Usuario;}
    // Notificar a los usuariosMesa de la mesa que se va a la puta pq se añade un censo

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

  private function actualizarVotacionFromBoton($boton,$publicar)
  {
    if($this->input->post($boton))
    {
      //CREAR LA NUEVA VOTACION CON LOS NUEVOS DATOS;
      $votacion = new Votacion(
                          $_POST['titulo'],
                          $_POST['descripcion'],
                          $_POST['fecha_inicio'],
                          $_POST['fecha_final'],
                          false,
                          $publicar, // Es borrador
                          false,
                          false,
                          0.2
                  );
      $votacion->setId($_POST['id']);
      $idVotacion = $votacion->getId();

      //SACAR MODIFICACION DE LOS CENSOS
      $censosVotacion = $this->censo_model->getCensosfromVotacion($idVotacion);
      $censosEliminar = $this->input->post('censoEliminacion');
      $censosAñadir = $this->input->post('censoInsercion');
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
      // Modificar datos de la votacion
      $modificada = $this->votaciones_model->updateVotacion($votacion);

        if($modificada != NULL){
            $this->index('La votación se ha guardado en borrador');
          }
    }
  }

  public function updateVotacion()
	{
    $this->actualizarVotacionFromBoton($this->input->post('boton_borrador'),false);
    $this->actualizarVotacionFromBoton($this->input->post('boton_publicar'),true);
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
