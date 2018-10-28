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
    //$cod_metadadata = $this->objMetadata->getCodMetadata();
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
    IDIOMA,COSTO FROM metadata WHERE IDMATERIAL = ".$cod_material."";

            //  echo " Comando SQL : ". $sentence;
    //Obtiene los registros de la consulta
    $recordSet = $objConnection->executeSQL($bd, $sentence);
    //Inicializa el contador
    $i = 0;
    //Inicializa las dimensiones del array bidimiensional de áreas
    $mat[0][0] = 10;
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
    //Material
    $cod_material = $this->objMaterial->getCodMaterial();
    $title = $this->objMaterial->getTitle();
    $description = $this->objMaterial->getDescription();
    $image = $this->objMaterial->getImage();
    //Area
    $cod_area = $this->objArea->getCodArea();
    //Author
    $cod_author = 1036685232;
		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    //Consultar imagen del material
    $sentenceImage = "SELECT IMAGEN FROM material WHERE IDMATERIAL =" . $cod_material . "";
    $recordSet4 = $objConnection->executeSQL($bd, $sentenceImage);
    $select_material = mysql_fetch_array($recordSet4);
    $old_image = $select_material['IMAGEN'];

    if ($old_image != $image) {
      //Borrando archivo
      if (!unlink('../material_images/' . $old_image)) {
        die("Se presentó un error borrando el archivo" . $old_image);
      }
    }
        
    //Actualiza el material
    $sentenceMetadata = "UPDATE material SET TITULO='" . $title . "',DESCRIPCION='" . $description . "',IMAGEN='" . $image . "' WHERE IDMATERIAL = " . $cod_material . "";
    $recordSet = $objConnection->executeSQL($bd, $sentenceMetadata);

    //Relaciona Material con Autor
    $sentenceRelationMA = "UPDATE relacionmaterialautor SET IDAUTOR=" . $cod_author . " WHERE IDMATERIAL = " . $cod_material . "";
    $recordSet2 = $objConnection->executeSQL($bd, $sentenceRelationMA);
    
    //Relacion Area con Material
    $sentenceRelationAM = "UPDATE relacionareamaterial SET IDAREA=" . $cod_area . " WHERE IDMATERIAL=" . $cod_material . "";
    $recordSet3 = $objConnection->executeSQL($bd, $sentenceRelationAM);
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

  function delete()
  {
    //Obtiene los valores ingresados en la vista
    //material
    $cod_material = $this->objMaterial->getCodMaterial();
		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    //--------------Se ejecuta Comando SQL-------------------------
    //Consultar imagen del material
    $sentenceImage = "SELECT IMAGEN FROM material WHERE IDMATERIAL =" . $cod_material . "";
    $recordSet4 = $objConnection->executeSQL($bd, $sentenceImage);
    $select_material = mysql_fetch_array($recordSet4);
    $image = $select_material['IMAGEN'];

    //Elimina la relacion Material con Autor
    $sentenceRelationMA = "DELETE FROM relacionmaterialautor WHERE IDMATERIAL =" . $cod_material . "";
    $recordSet2 = $objConnection->executeSQL($bd, $sentenceRelationMA);
    
    //Elimina la relacion Area con Material
    $sentenceRelationAM = "DELETE FROM relacionareamaterial WHERE IDMATERIAL =" . $cod_material . "";
    $recordSet3 = $objConnection->executeSQL($bd, $sentenceRelationAM);

    //Elimina el material
    $sentenceMetadata = "DELETE FROM material WHERE IDMATERIAL =" . $cod_material . "";
    $recordSet = $objConnection->executeSQL($bd, $sentenceMetadata);
    //Cierra la conexión
    $objConnection->close($link);

    //Borrando archivo
    if (!unlink('../material_images/' . $image)) {
      die("Se presentó un error borrando el archivo" . $image);
    }

		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$cod_material) {
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

    $sentence = "SELECT m.IDMATERIAL, m.TITULO, m.DESCRIPCION, m.IMAGEN,au.IDAUTOR, au.NOMBRE AS AUTHOR,ar.IDAREA, ar.NOMBRE AS AREA 
     FROM material m INNER JOIN relacionmaterialautor rma 
     ON m.IDMATERIAL = rma.IDMATERIAL 
     INNER JOIN autor au 
     ON rma.IDAUTOR = au.IDAUTOR 
     INNER JOIN relacionareamaterial ram 
     ON m.IDMATERIAL = ram.IDMATERIAL 
     INNER JOIN area ar 
     ON ram.IDAREA = ar.IDAREA  
     WHERE m.IDMATERIAL = " . $cod_material . "";
    $recordSet = $objConnection->executeSQL($bd, $sentence);
        // LA FUNCI�N  mysql_fetch_array   PERMITE RECORRER EL RECORDSET (CURSOR A LA TABLA)
        // AQU� SE ASIGNA EL CONTENIDO DEL PRIMER REGISTRO DEL RECORDSET A UNA VARIABLE IDENTIFICADA COMO:

    $search = mysql_fetch_array($recordSet);

    $this->objMaterial->setCodMaterial($search['IDMATERIAL']);
    $this->objMaterial->setTitle($search['TITULO']);
    $this->objMaterial->setDescription($search['DESCRIPCION']);
    $this->objMaterial->setImage($search['IMAGEN']);
    $this->objArea->setCodArea($search['IDAREA']);
    $this->objArea->setName($search['AREA']);
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