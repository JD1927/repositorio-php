<?
class AreaModel
{
  var $codArea = "";
  var $name = "";
  var $subarea = "";

  function AreaModel($codArea, $name, $subarea)
  {
    $this->codArea = $codArea;
    $this->name = $name;
    $this->subarea = $subarea;
  }

  function getCodArea()
  {
    return $this->codArea;
  }

  function setCodArea($codArea)
  {
    $this->codArea = $codArea;
  }

  function getName()
  {
    return $this->name;
  }

  function setName($name)
  {
    $this->name = $name;
  }
  function getSubarea()
  {
    return $this->subarea;
  }

  function setSubarea($subarea)
  {
    $this->subarea = $subarea;
  }
}

?>