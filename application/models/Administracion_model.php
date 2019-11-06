<?php

class Administracion_model extends CI_Model{

// COMO COMPROBAR QUE UNA VOTACION NO EXISTE YA
  function guardarVotacion($datos){$this->db->insert('votaciones',$datos);}
}



?>
