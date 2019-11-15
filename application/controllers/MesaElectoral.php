<?php

include 'classes/MiembroElectoral.php';

class MesaElectoral extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('votaciones_model');


  }

  public function index($mensaje = 'Bienvenido a la pagina de la mesa electoral')
  {
      $votaciones['votaciones'] = $this->secretario_model->recuperarVotacionesAcabadas();
      $datos = array(
        'votaciones'=> $votaciones,
        'mensaje' => $mensaje
      );
      $this->load->view('MesaElectoral/MesaElectoral_view',$datos);

  }

  public function recuentoVotos($idVotacion){
    $nVotos = $this->votaciones_model->recuentoVotos($idVotacion);
    $datos = array(
      'total' => $nVotos,
      'votacion' => $idVotacion
    )
    
    //echo "Se han hecho: ". $nVotos. " en la votacion ".$idVotacion;

  }

}



?>
