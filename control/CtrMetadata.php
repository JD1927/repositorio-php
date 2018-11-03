<?
class CtrMetadata
{
  var $objMetadata;
  var $objMaterial;
  var $recordSet;
  function CtrMetadata($objMetadata, $objMaterial)
  {
    //Obtiene el objeto de Metadata
    $this->objMetadata = $objMetadata;
    //Obtiene el objeto de MaterialModel
    $this->objMaterial = $objMaterial;
  }

  function create()
  {
    //Obtiene los valores ingresados en la vista
    //$cod_metadata = $this->objMetadata->getCodMetadata();
    $type = $this->objMetadata->getTypeMetadata();
    $metadata = $this->objMetadata->getMetadata();
    $date_created = $this->objMetadata->getDateCreated();
    $date_updated = $this->objMetadata->getDateUpdated();
    $user = $this->objMetadata->getUser();
    $audency = $this->objMetadata->getAudency();
    $compatibility = $this->objMetadata->getCompatibility();
    $language = $this->objMetadata->getLanguage();
    $cost = $this->objMetadata->getCost();
    $cod_material = $this->objMaterial->getCodMaterial();
		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    //--------------Se ejecuta Comando SQL-------------------------
    //Crea un nuevo material
    $sentenceMetadata = "INSERT INTO metadata
    (TIPO, METADATA, FECHAINGRESO, 
    FECHAMODIFICACION, USUARIOINGRESO, 
    AUDIENCIA, COMPATIBILIDAD, IDIOMA, 
    COSTO, IDMATERIAL) 
    VALUES 
    ('" . $type . "','" . $metadata . "','" . $date_created . "', 
    '" . $date_updated . "', '" . $user . "', 
    '" . $audency . "', " . $compatibility . ", '" . $language . "', 
    " . $cost . ", " . $cod_material . ")";
    $recordSet = $objConnection->executeSQL($bd, $sentenceMetadata);

    $objConnection->close($link);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error());
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      $this->recordSet = $recordSet;
      return true;
    }

  }

  function metadata_list()
  {
    //Material
    $cod_material = $this->objMaterial->getCodMaterial();

            //---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');
    
    
            //--------------Se ejecuta Comando SQL-------------------------

    $sentence = "SELECT 
    IDMETADATA,TIPO,METADATA,
    FECHAINGRESO,FECHAMODIFICACION,USUARIOINGRESO,
    AUDIENCIA,COMPATIBILIDAD,
    IDIOMA,COSTO,IDMATERIAL FROM metadata WHERE IDMATERIAL = " . $cod_material . "";

            //  echo " Comando SQL : ". $sentence;
    //Obtiene los registros de la consulta
    $recordSet = $objConnection->executeSQL($bd, $sentence);
    //Inicializa el contador
    $i = 0;
    //Inicializa las dimensiones del array bidimiensional de áreas
    $mat[0][0] = 11;
    //Recorre el array y incrementa el valor de contador
    while ($search = mysql_fetch_array($recordSet)) {
      $mat[$i][1] = $search['IDMETADATA'];
      $mat[$i][2] = $search['TIPO'];
      $mat[$i][3] = $search['METADATA'];
      $mat[$i][4] = $search['FECHAINGRESO'];
      $mat[$i][5] = $search['FECHAMODIFICACION'];
      $mat[$i][6] = $search['USUARIOINGRESO'];
      $mat[$i][7] = $search['AUDIENCIA'];
      $mat[$i][8] = $search['COMPATIBILIDAD'];
      $mat[$i][9] = $search['IDIOMA'];
      $mat[$i][10] = $search['COSTO'];
      $mat[$i][11] = $search['IDMATERIAL'];
      $i = $i + 1;
    }
    //Cierra la conexión con la BD
    $objConnection->close($link);
    //Devuelve el array bidimensional con los registros encontrados en la BD
    return $mat;

  }

  function update()
  {
    //Obtiene los campos ingresados en la vista
    $cod_metadata = $this->objMetadata->getCodMetadata();
    $type = $this->objMetadata->getTypeMetadata();
    $date_updated = $this->objMetadata->getDateUpdated();
    $user = $this->objMetadata->getUser();
    $metadata = $this->objMetadata->getMetadata();
    $audency = $this->objMetadata->getAudency();
    $compatibility = $this->objMetadata->getCompatibility();
    $language = $this->objMetadata->getLanguage();
    $cost = $this->objMetadata->getCost();
    $cod_material = $this->objMaterial->getCodMaterial();
		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    //Consultar zip del metadata
    $sentenceZip = "SELECT METADATA FROM metadata WHERE IDMETADATA =" . $cod_metadata . "";
    $recordSet4 = $objConnection->executeSQL($bd, $sentenceZip);
    $select_metadata = mysql_fetch_array($recordSet4);
    $old_metadata = $select_metadata['METADATA'];
    
    if(!is_null($metadata)){
      if ($old_metadata != $metadata) {
        //Borrando archivo
        if (!unlink('../metadata/' . $old_metadata)) {
          die("Se presentó un error borrando el archivo" . $old_metadata);
        }
      }
      //Actualiza el metadata
      $sentenceMetadata = "UPDATE metadata 
      SET TIPO = '".$type."', 
      FECHAMODIFICACION = '".$date_updated."', 
      AUDIENCIA = '".$audency."', 
      METADATA = '".$metadata."', 
      COMPATIBILIDAD = ".$compatibility.", 
      IDIOMA = '".$language."', COSTO = ".$cost." 
      WHERE IDMETADATA = ".$cod_metadata."";
      $recordSet = $objConnection->executeSQL($bd, $sentenceMetadata);
    }else{
      $sentenceMetadata = "UPDATE metadata 
      SET TIPO = '".$type."', 
      FECHAMODIFICACION = '".$date_updated."', 
      AUDIENCIA = '".$audency."', 
      COMPATIBILIDAD = ".$compatibility.", 
      IDIOMA = '".$language."', COSTO = ".$cost." 
      WHERE IDMETADATA = ".$cod_metadata."";
      $recordSet = $objConnection->executeSQL($bd, $sentenceMetadata);
    }

    //Cierra la conexión con la BD
    $objConnection->close($link);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error());
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      $this->recordSet = $recordSet;
      return true;
    }

  }
  /**Eliminar Metadata */
  function delete()
  {
    //Obtiene los valores ingresados en la vista
    //material
    $cod_metadata = $this->objMetadata->getCodMetadata();
		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    //--------------Se ejecuta Comando SQL-------------------------
    //Consultar el metadata del material
    $sentenceMetadata = "SELECT METADATA FROM metadata WHERE IDMETADATA = " . $cod_metadata . "";
    $recordSet2 = $objConnection->executeSQL($bd, $sentenceMetadata);
    $select_metadata = mysql_fetch_array($recordSet2);
    $metadata = $select_metadata['METADATA'];
    //Elimina el metadata
    $sentenceDeleteMetadata = "DELETE FROM metadata WHERE IDMETADATA =" . $cod_metadata . "";
    $recordSet = $objConnection->executeSQL($bd, $sentenceDeleteMetadata);
    //Cierra la conexión
    $objConnection->close($link);

    //Borrando archivo
    if (!unlink('../metadata/' . $metadata)) {
      die("Se presentó un error borrando el archivo: " . $metadata);
    }

		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$cod_metadata) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error());
    } else {  
      //----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------

      $this->recordSet = $recordSet;
      return true;
    }

  }
  function read()
  {
    $cod_material = $this->objMaterial->getCodMaterial();

    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    $sentence = "SELECT  
    IDMETADATA,TIPO,FECHAINGRESO,FECHAMODIFICACION,
    USUARIOINGRESO,AUDIENCIA,
    COMPATIBILIDAD,IDIOMA,COSTO 
    FROM  metadata  WHERE  IDMATERIAL =" . $cod_material . "";
    $recordSet = $objConnection->executeSQL($bd, $sentence);
        // LA FUNCI�N  mysql_fetch_array   PERMITE RECORRER EL RECORDSET (CURSOR A LA TABLA)
        // AQU� SE ASIGNA EL CONTENIDO DEL PRIMER REGISTRO DEL RECORDSET A UNA VARIABLE IDENTIFICADA COMO:

    $search = mysql_fetch_array($recordSet);

    $this->objMetadata->setCodMetadata($search['IDMETADATA']);
    $this->objMetadata->setTypeMetadata($search['TIPO']);
    $this->objMetadata->setDateCreated($search['FECHAINGRESO']);
    $this->objMetadata->setDateUpdated($search['FECHAMODIFICACION']);
    $this->objMetadata->setUser($search['USUARIOINGRESO']);
    $this->objMetadata->setAudency($search['AUDIENCIA']);
    $this->objMetadata->setCompatibility($search['COMPATIBILIDAD']);
    $this->objMetadata->setLanguage($search['IDIOMA']);
    $this->objMetadata->setCost($search['COSTO']);
    $this->objMaterial->setCodMaterial($cod_material);

    $objConnection->close($link);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error()) . "<br>";
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      return $this->objMaterial;

    }

  }
}


?>