<?php

include 'classes/Censos.php';

class Censo extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('secretario_model');
    $this->load->model('censo_model');
    $this->load->library('pagination');

  }

  public function insertar(){echo 'VAMOS A INSERTAR EN EL CENSO';}

  public function getCensos(){
    $censos = $this->censo_model->getCensos();
  }


}


?>
