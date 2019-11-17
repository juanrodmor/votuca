<?php

include 'classes/MiembroElectoral.php';

class MesaElectoral extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('voto_model');
    $this->load->model('votaciones_model');


  }

  public function index($mensaje = 'Bienvenido a la pagina de la mesa electoral')
  {
    switch ($this->session->userdata('rol')) {
       case 'Administrador':
       redirect('/Administrador_controller');
        break;
       case 'Elector':
        redirect('/Elector_controller');
        break;
       case 'Secretario':
        redirect('/Secretario');
        break;
        case 'MiembroElectoral':
          $votaciones['votaciones'] = $this->votaciones_model->recuperarVotacionesAcabadas();
          $datos = array(
                    'votaciones'=> $votaciones,
                    'mensaje' => $mensaje
                  );
          $this->load->view('MesaElectoral/MesaElectoral_view',$datos);
        break;

       case 'Secretario delegado':
        redirect('/secretario/delegado');
        break;
       default:
        redirect('/Login_controller');
        break;
    }


  }

  public function recuentoVotos($idVotacion){
    $nVotos = $this->voto_model->recuentoVotos($idVotacion);
    $datos = array(
      'total' => $nVotos,
      'votacion' => $idVotacion
    );

    //echo "Se han hecho: ". $nVotos. " en la votacion ".$idVotacion;

  }

}



?>
