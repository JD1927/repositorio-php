<?
class CtrMaterial
{
  var $objMaterial;
  var $objArea;
  var $objAuthor;
  var $recordSet;
  
  function CtrMaterial($objMaterial, $objArea, $objAuthor)
  {
    //Obtiene el objeto de MaterialModel
    $this->objMaterial = $objMaterial;
    //Obtiene el objeto de AreaModel
    $this->objArea = $objArea;
    //Obtiene el objeto de AuthorModel
    $this->objAuthor = $objAuthor;
  }

  function create()
  {
    //Obtiene los valores ingresados en la vista
    //material
    $title = $this->objMaterial->getTitle();
    $description = $this->objMaterial->getDescription();
    $image = $this->objMaterial->getImage();
    
    //relacionmaterialautor -->$cod_material
    $cod_author = $this->objAuthor->getIdAuthor();
    //relacionareamaterial -->$cod_material
    $cod_area = $this->objArea->getCodArea();
		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    //--------------Se ejecuta Comando SQL-------------------------
    //Crea un nuevo material
    $sentenceMaterial = "INSERT into material (TITULO,DESCRIPCION,IMAGEN) values ('" . $title . "','" . $description . "','" . $image . "')";
    $recordSet = $objConnection->executeSQL($bd, $sentenceMaterial);

    //Consultar ID del Material
    $sentenceSelectIdMaterial = "SELECT IDMATERIAL FROM material WHERE TITULO = '".$title."'";
    $recordSet4 = $objConnection->executeSQL($bd, $sentenceSelectIdMaterial);
    $select_material = mysql_fetch_array($recordSet4);
    $cod_material = $select_material['IDMATERIAL'];

    //Relaciona Material con Autor
    $sentenceRelationMA = "INSERT into relacionmaterialautor (IDMATERIAL, IDAUTOR) values (" . $cod_material . "," . $cod_author . ")";
    $recordSet2 = $objConnection->executeSQL($bd, $sentenceRelationMA);
    
    //Relacion Area con Material
    $sentenceRelationAM = "INSERT into relacionareamaterial (IDMATERIAL, IDAREA) values (" . $cod_material . "," . $cod_area . ")";
    $recordSet3 = $objConnection->executeSQL($bd, $sentenceRelationAM);

    $objConnection->close($link);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$cod_material) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error());
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      $this->recordSet = $recordSet;
      return true;
    }

  }

  function material_list()
  {
    
            //---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');
    
    
            //--------------Se ejecuta Comando SQL-------------------------

    $sentence = "SELECT m.IDMATERIAL, m.TITULO, m.DESCRIPCION, m.IMAGEN,au.IDAUTOR, au.NOMBRE AS AUTHOR,ar.IDAREA, ar.NOMBRE AS AREA 
     FROM material m INNER JOIN relacionmaterialautor rma 
     ON m.IDMATERIAL = rma.IDMATERIAL 
     INNER JOIN autor au 
     ON rma.IDAUTOR = au.IDAUTOR 
     INNER JOIN relacionareamaterial ram 
     ON m.IDMATERIAL = ram.IDMATERIAL 
     INNER JOIN area ar 
     ON ram.IDAREA = ar.IDAREA ";
            //  echo " Comando SQL : ". $sentence;
    //Obtiene los registros de la consulta
    $recordSet = $objConnection->executeSQL($bd, $sentence);
    //Inicializa el contador
    $i = 0;
    //Inicializa las dimensiones del array bidimiensional de áreas
    $mat[0][0] = 8;
    //Recorre el array y incrementa el valor de contador
    while ($search = mysql_fetch_array($recordSet)) {
      $mat[$i][1] = $search['IDMATERIAL'];
      $mat[$i][2] = $search['TITULO'];
      $mat[$i][3] = $search['DESCRIPCION'];
      $mat[$i][4] = $search['IMAGEN'];
      $mat[$i][5] = $search['IDAUTOR'];
      $mat[$i][6] = $search['AUTHOR'];
      $mat[$i][7] = $search['IDAREA'];
      $mat[$i][8] = $search['AREA'];
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
    $cod_author = $this->objAuthor->getIdAuthor();
		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    //Consultar imagen del material
    $sentenceImage = "SELECT IMAGEN FROM material WHERE IDMATERIAL =" . $cod_material . "";
    $recordSet4 = $objConnection->executeSQL($bd, $sentenceImage);
    $select_material = mysql_fetch_array($recordSet4);
    $old_image = $select_material['IMAGEN'];
    
    if(!is_null($image)){
      if ($old_image != $image) {
        //Borrando archivo
        if (!unlink('../material_images/' . $old_image)) {
          die("Se presentó un error borrando el archivo" . $old_image);
        }
      }
      //Actualiza el material
      $sentenceMaterial = "UPDATE material SET TITULO='" . $title . "',DESCRIPCION='" . $description . "',IMAGEN='" . $image . "' WHERE IDMATERIAL = " . $cod_material . "";
      $recordSet = $objConnection->executeSQL($bd, $sentenceMaterial);
    }else{
      $sentenceMaterial = "UPDATE material SET TITULO='" . $title . "',DESCRIPCION='" . $description . "' WHERE IDMATERIAL = " . $cod_material . "";
      $recordSet = $objConnection->executeSQL($bd, $sentenceMaterial);
    }

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

    //Elimina el metadata
    $sentenceMetadata = "DELETE FROM metadata WHERE IDMATERIAL =" . $cod_material . "";
    $recordSet5 = $objConnection->executeSQL($bd, $sentenceMetadata);

    //Elimina el material
    $sentenceMaterial = "DELETE FROM material WHERE IDMATERIAL =" . $cod_material . "";
    $recordSet = $objConnection->executeSQL($bd, $sentenceMaterial);
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
    $this->objAuthor->setIdAuthor($search['IDAUTOR']);
    $this->objAuthor->setName($search['AUTHOR']);
    
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