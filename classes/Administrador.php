<?php

class Administrador extends Usuario {
	
	public function __construct($id, $pass) {
		parent::__construct($id, $pass);
	}
	
	//public function concederPermisos() { return $this->_id; }
	//public function getEstadoSistema() { return $this->_pass; }
	
}

?>