<?php

class Votacion{

  public $id, $titulo, $descripcion, $fechaInicio,$fechaFinal;
  private $isDelected;
  private $mesaElectoral;

  public function __construct($titulo,$descripcion,$fechaInicio,$fechaFinal,
                              $isDelected)
  {
    $this->titulo = $titulo;
    $this->descripcion = $descripcion;
    $this->fechaInicio = $fechaInicio;
    $this->fechaFinal = $fechaFinal;
    $this->isDelected = $isDelected;
  }

  public function getId(){return $this->id;}
  public function getTitulo(){return $this->titulo;}
  public function getDescripcion(){return $this->descripcion;}
  public function getFechaInicio(){return $this->fechaInicio;}
  public function getFechaFinal(){return $this->fechaFinal;}
  public function getDelected(){return $this->isDelected;}

  public function setId($id){$this->id = $id;}
  public function setTitulo($titulo){$this->titulo = $titulo;}
  public function setDescripcion($descripcion){$this->descripcion = $descripcion;}
  public function setFechaInicio($fecha){$this->fechaInicio= $fecha;}
  public function setFechaFinal($fecha){$this->fechaFinal = $fecha;}
  public function setDelected($delected){$this->isDelected = $delected;}


}



?>
