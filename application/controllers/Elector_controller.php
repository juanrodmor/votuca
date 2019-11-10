<?php
error_reporting(E_ALL ^ E_DEPRECATED);

class Elector_controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		// $this->load->model('Votacion_model');
	}
	
	public function index() {
        // $this->Votacion_model->_list();
        $data=Array();
		$this->load->view('Elector/listar_votaciones',$data);
    }

    // public function datatable(){
        // $this->Votacion_model->_list();
    // }
}