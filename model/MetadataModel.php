<?
class MetadataModel
{
  var $cod_metadadata = "";
  var $type = "";
  var $metadata = "";
  var $date_created = "";
  var $date_updated = "";
  var $user = "";
  var $audency = "";
  var $compatibility = "";
  var $language = "";
  var $cost = "";

  function MetadataModel(
    $cod_metadadata,
    $type,
    $metadata,
    $date_created,
    $date_updated,
    $user,
    $audency,
    $compatibility,
    $language,
    $cost
  ) {
    $this->cod_metadadata = $cod_metadadata;
    $this->type = $type;
    $this->metadata = $metadata;
    $this->date_created = $date_created;
    $this->date_updated = $date_updated;
    $this->user = $user;
    $this->audency = $audency;
    $this->compatibility = $compatibility;
    $this->language = $language;
    $this->cost = $cost;
  }

  function getCodMetadata()
  {
    return $this->cod_metadadata;
  }

  function setCodMetadata($cod_metadadata)
  {
    $this->cod_metadadata = $cod_metadadata;
  }

  function getTypeMetadata()
  {
    return $this->type;
  }

  function setTypeMetadata($type)
  {
    $this->type = $type;
  }

  function getMetadata()
  {
    return $this->metadata;
  }

  function setMetadata($metadata)
  {
    $this->metadata = $metadata;
  }

  function getDateCreated()
  {
    return $this->date_created;
  }

  function setDateCreated($date_created)
  {
    $this->date_created = $date_created;
  }

  function getDateUpdated()
  {
    return $this->date_updated;
  }

  function setDateUpdated($date_updated)
  {
    $this->date_updated = $date_updated;
  }

  function getUser()
  {
    return $this->user;
  }

  function setUser($user)
  {
    $this->user = $user;
  }

  function getAudency()
  {
    return $this->audency;
  }

  function setAudency($audency)
  {
    $this->audency = $audency;
  }

  function getCompatibility()
  {
    return $this->compatibility;
  }

  function setCompatibility($compatibility)
  {
    $this->compatibility = $compatibility;
  }

  function getLanguage()
  {
    return $this->language;
  }

  function setLanguage($language)
  {
    $this->language = $language;
  }

  function getCost()
  {
    return $this->cost;
  }

  function setCost($cost)
  {
    $this->cost = $cost;
  }

}

?>