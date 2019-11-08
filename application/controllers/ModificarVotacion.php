<?php

class ModificarVotacion extends CI_Controller
{
	public function index()
	{
		$this->load->model('modificarVotacion_model');
		$query = $this->modificarVotacion_model->getVotaciones();
		$data['VOTACIONES'] = null;
		if($query)
		{
			$data['VOTACIONES'] = $query;
		}
  		$this->load->view('administracion/modificarVotacion_view', $data);
	}
	
}

?>
