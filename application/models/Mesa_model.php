<?php
class Mesa_model extends CI_Model {


  public function insertar($usuarios,$idVotacion)
  {
    $sinProblemas = true;
    echo var_dump($usuarios);
    for($i = 0; $i < sizeof($usuarios);$i++)
    {
      $datos = array(
        'Id_Usuario' => $usuarios[$i],
        'Id_Votacion' => $idVotacion
      );
      $noGuardado = $this->db->insert('mesa_electoral',$datos);
      if($noGuardado){$sinProblemas = false;}
    }
    if($sinProblemas){return true;}
    else{return false;}
  }
}


?>
