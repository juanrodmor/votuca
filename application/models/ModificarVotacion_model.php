<?php

class ModificarVotacion_model extends CI_Model
{
	function getVotaciones()
	{
		$query = $this->db->get('votacion');
  	//return $query->result();
		return $query->result();
	}
}

?>
