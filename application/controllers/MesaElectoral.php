<?php

include 'classes/MiembroElectoral.php';

class MesaElectoral extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('voto_model');
    $this->load->model('votaciones_model');


  }

  public function index($mensaje = '')
  {
    switch ($this->session->userdata('rol')) {
       case 'Administrador':
        break;
       case 'Elector':
        redirect('/Elector_controller');
        break;
       case 'Secretario':
        redirect('/Secretario');
        break;
        case 'MiembroElectoral':
        $inicio['inicio'] = '/MesaElectoral';
        $this->load->view('elementos/headerComun',$inicio);
          $votaciones['votaciones'] = $this->votaciones_model->recuperarVotacionesAcabadas();
          $datos = array(
                    'votaciones'=> $votaciones,
                    'mensaje' => $mensaje
                  );
          $this->load->view('MesaElectoral/MesaElectoral_view',$datos);
          $this->load->view('elementos/footer');
        break;

       case 'Secretario delegado':
        redirect('/secretario/delegado');
        break;
       default:
        redirect('/Login_controller');
        break;
    }


  }

  public function recuentoVotos(){
    if($this->input->post('boton_recuento')){
      $idVotacion = $this->input->post('recuento');
      $nVotos = $this->voto_model->recuentoVotosElectoral($idVotacion);
      $datos = array(
        'total' => $nVotos,
        'votacion' => $idVotacion
      );

      // Devolver numero de votos totales
      $mensaje = "Se han hecho: ". $nVotos. " votos totales en la votacion ".$idVotacion;
      $this->index($mensaje);
    }

  }

}



?>
