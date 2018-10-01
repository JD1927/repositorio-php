<?
class AreaModel
{
  var $cod_area = "";
  var $name = "";
  var $subarea = "";

  function AreaModel($cod_area, $name, $subarea)
  {
    $this->cod_area = $cod_area;
    $this->name = $name;
    $this->subarea = $subarea;
  }

  function getCod_Area()
  {
    return $this->cod_area;
  }

  function setCod_Area($cod_area)
  {
    $this->cod_area = $cod_area;
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