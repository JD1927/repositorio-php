<?
class MaterialModel
{
  var $cod_material = "";
  var $title = "";
  var $description = "";
  var $image = "";


  function MaterialModel($cod_material, $title, $description, $image)
  {
    $this->cod_material = $cod_material;
    $this->title = $title;
    $this->description = $description;
    $this->$image = $image;
  }

  function getCodMaterial()
  {
    return $this->cod_material;
  }

  function setCodMaterial($cod_material)
  {
    $this->cod_material = $cod_material;
  }

  function getTitle()
  {
    return $this->title;
  }

  function setTitle($title)
  {
    $this->title = $title;
  }

  function getDescription()
  {
    return $this->description;
  }

  function setDescription($description)
  {
    $this->description = $description;
  }

  function getImage()
  {
    return $this->image;
  }

  function setImage($image)
  {
    $this->image = $image;
  }
}

?>