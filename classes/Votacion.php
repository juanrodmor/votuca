<?php

class Votacion{

  public $id, $titulo, $descripcion, $fechaInicio,$fechaFinal;
  private $isDelected, $esBorrador,$finalizada,$invalida,$quorum;
  //private $mesaElectoral;

  public function __construct($titulo,$descripcion,$fechaInicio,$fechaFinal,
                              $isDelected,$esBorrador,$finalizada,$invalida,$quorum)
  {
    $this->titulo = $titulo;
    $this->descripcion = $descripcion;
    $this->fechaInicio = $fechaInicio;
    $this->fechaFinal = $fechaFinal;
    $this->isDelected = $isDelected;
    $this->esBorrador = $esBorrador;
    $this->finalizada = $finalizada;
    $this->invalida = $invalida;
    $this->quorum = $quorum;
  }

  public function getId(){return $this->id;}
  public function getTitulo(){return $this->titulo;}
  public function getDescripcion(){return $this->descripcion;}
  public function getFechaInicio(){return $this->fechaInicio;}
  public function getFechaFinal(){return $this->fechaFinal;}
  public function getDelected(){return $this->isDelected;}
  public function getBorrador(){return $this->esBorrador;}

  public function setId($id){$this->id = $id;}
  public function setTitulo($titulo){$this->titulo = $titulo;}
  public function setDescripcion($descripcion){$this->descripcion = $descripcion;}
  public function setFechaInicio($fecha){$this->fechaInicio= $fecha;}
  public function setFechaFinal($fecha){$this->fechaFinal = $fecha;}
  public function setDelected($delected){$this->isDelected = $delected;}
  public function setBorrador($borrador){$this->esBorrador = $borrador;}


}



?>
