<?php

class Usuario {

	public $_id, $_pass;

	public function __construct($id, $pass) {
		$this->_id = $id;
		$this->_pass = $pass;
	}

	public function getId() { return $this->_id; }
	public function getPass() { return $this->_pass; }

}

?>
