<?php

class Votacion{

  public $id, $titulo, $descripcion, $fechaInicio,$fechaFinal;
  public $isDeleted, $esBorrador,$finalizada,$invalida,$quorum;
  public $Id_TipoVotacion, $VotoModificable, $SoloAsistentes, $RecuentoParalelo, $NumOpciones;
  //private $mesaElectoral;

  public function __construct($tipo,$titulo,$descripcion,$fechaInicio,$fechaFinal,
                              $isDeleted,$esBorrador,$finalizada,$invalida,$quorum,
                              $modificable,$asistentes,$paralelo,$nOpc)
  {
    $this->titulo = $titulo;
    $this->descripcion = $descripcion;
    $this->fechaInicio = $fechaInicio;
    $this->fechaFinal = $fechaFinal;
    $this->isDeleted = $isDeleted;
    $this->esBorrador = $esBorrador;
    $this->finalizada = $finalizada;
    $this->invalida = $invalida;
    $this->quorum = $quorum;
    $this->Id_TipoVotacion = $tipo;
    $this->VotoModificable = $modificable;
    $this->SoloAsistentes = $asistentes;
    $this->RecuentoParalelo = $paralelo;
    $this->NumOpciones = $nOpc;
  }

  public function getId(){return $this->id;}
  public function getTitulo(){return $this->titulo;}
  public function getDescripcion(){return $this->descripcion;}
  public function getFechaInicio(){return $this->fechaInicio;}
  public function getFechaFinal(){return $this->fechaFinal;}
  public function getDeleted(){return $this->isDeleted;}
  public function getBorrador(){return $this->esBorrador;}
  public function getFinalizada(){return $this->finalizada;}
  public function getInvalida(){return $this->invalida;}
  public function getQuorum(){return $this->quorum;}
  public function getTipo(){return $this->Id_TipoVotacion;}
  public function getModificable(){return $this->VotoModificable;}
  public function getAsistentes(){return $this->SoloAsistentes;}
  public function getRecuentoParalelo(){return $this->RecuentoParalelo;}
  public function getOpciones(){return $this->NumOpciones;}

  public function setId($id){$this->id = $id;}
  public function setTitulo($titulo){$this->titulo = $titulo;}
  public function setDescripcion($descripcion){$this->descripcion = $descripcion;}
  public function setFechaInicio($fecha){$this->fechaInicio= $fecha;}
  public function setFechaFinal($fecha){$this->fechaFinal = $fecha;}
  public function setDeleted($delected){$this->isDeleted = $deleted;}
  public function setBorrador($borrador){$this->esBorrador = $borrador;}
  public function setFinalizada($finalizada){$this->finalizada = $finalizada;}
  public function setInvalida($invalida){$this->invalida = $invalida;}
  public function setQuorum($quorum){$this->quorum = $quorum;}
  public function setTipo($tipo){$this->Id_TipoVotacion = $tipo;}
  public function setModificable($modificable){$this->VotoModificable = $modificable;}
  public function setAsistentes($asistentes){$this->SoloAsistentes = $asistentes;}
  public function setRecuentoParalelo($paralelo){$this->RecuentoParalelo = $paralelo;}
  public function setOpciones($opciones){$this->NumOpciones = $opciones;}


}



?>
