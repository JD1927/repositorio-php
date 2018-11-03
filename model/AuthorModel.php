<?
class AuthorModel
{
  var $idAuthor = "";
  var $name = "";
  var $nacionality = "";

  function AuthorModel($idAuthor, $name, $nacionality)
  {
    $this->idAuthor = $idAuthor;
    $this->name = $name;
    $this->nacionality = $nacionality;
  }

  function getIdAuthor()
  {
    return $this->idAuthor;
  }

  function setIdAuthor($idAuthor)
  {
    $this->idAuthor = $idAuthor;
  }

  function getName()
  {
    return $this->name;
  }

  function setName($name)
  {
    $this->name = $name;
  }
  function getNacionality()
  {
    return $this->nacionality;
  }

  function setNacionality($nacionality)
  {
    $this->nacionality = $nacionality;
  }
}

?>