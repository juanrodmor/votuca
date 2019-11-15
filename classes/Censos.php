<?php

class Censos {

	public $id_Usuario, $id_Votacion;

	public function __construct($idU, $idV) {
		$this->id_Usuario = $idU;
		$this->id_Votacion = $idV;
	}

	public function getIdUsuario() { return $this->id_Usuario; }
	public function getIdVotacion() { return $this->id_Votacion; }

}

?>
