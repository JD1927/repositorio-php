<?
class CtrMaterial
{
  var $objMaterial;
  var $objArea;
  var $recordSet;
  function CtrMaterial($objMaterial,$objArea)
  {
    //Obtiene el objeto de MaterialModel
    $this->objMaterial = $objMaterial;
    //Obtiene el objeto de AreaModel
    $this->objArea = $objArea;
  }

  function create()
  {
    //Obtiene los valores ingresados en la vista
    //material
    $cod_material = $this->objMaterial->getCodMaterial();
    $title = $this->objMaterial->getTitle();
    $description = $this->objMaterial->getDescription();
    $image = $this->objMaterial->getImage();
    //relacionmaterialautor -->$cod_material
    $cod_author = 1036685232; //$this->objMaterial->getAuthor();
    //relacionareamaterial -->$cod_material
    $cod_area = 10;//$this->objMaterial->getCodArea();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    //--------------Se ejecuta Comando SQL-------------------------
    //Crea un nuevo material
    $sentenceMaterial = "INSERT into material (TITULO,DESCRIPCION,IMAGEN) values ('" . $title . "','".$description."','.$image.')";
    $recordSet = $objConnection->executeSQL($bd, $sentenceMaterial);

    //Consultar ID del Material
    $sentenceSelectIdMaterial = "SELECT IDMATERIAL FROM MATERIAL WHERE TITULO = '".$title."'";
    $cod_material = $objConnection->executeSQL($bd, $sentenceSelectIdMaterial);

    //Relaciona Material con Autor
    $sentenceRelationMA = "INSERT into relacionmaterialautor (IDMATERIAL, IDAUTOR) values (".$cod_material.",".$cod_author.")";
    $recordSet2 = $objConnection->executeSQL($bd, $sentenceRelationMA);
    
    //Relacion Area con Material
    $sentenceRelationAM = "INSERT into relacionareamaterial (IDMATERIAL, IDAREA) values (".$cod_material.",".$cod_area.")";
    $recordSet3 = $objConnection->executeSQL($bd, $sentenceRelationAM);

    $objConnection->close($link);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet || !$recordSet2 || !$recordSet3 || !$cod_material) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error());
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      $this->recordSet = $recordSet;
      return true;
    }

  }

  function area_list()
  {
    
            //---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');
    
    
            //--------------Se ejecuta Comando SQL-------------------------

    $sentence = "SELECT * FROM area";
            //  echo " Comando SQL : ". $sentence;
    //Obtiene los registros de la consulta
    $recordSet = $objConnection->executeSQL($bd, $sentence);
    //Inicializa el contador
    $i = 0;
    //Inicializa las dimensiones del array bidimiensional de áreas
    $mat[0][0] = 3;
    //Recorre el array y incrementa el valor de contador
    while ($search= mysql_fetch_array($recordSet)) {
      $mat[$i][1] = $search['IDAREA'];
      $mat[$i][2] = $search['NOMBRE'];
      $mat[$i][3] = $search['FKAREA'];
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
    $cod_material = $this->objMaterial->getCodArea();
    $title = $this->objMaterial->getName();
    $subarea = $this->objMaterial->getSubarea();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    //Valida si el campo de subárea está nulo o vacío para ejecutar una sentencia
    if (is_null($subarea) || $subarea == '') {
      $sentence = "UPDATE `area` SET `NOMBRE` = '".$title."', `FKAREA` = NULL WHERE `area`.`IDAREA` = ".$cod_material."";
    }else{
      $sentence = "UPDATE area set NOMBRE='" . $title . "', FKAREA=" . $subarea . " where IDAREA =" . $cod_material . "";
    }
    //Obtiene si el resultado de la operación fue exitoso
    $recordSet = $objConnection->executeSQL($bd, $sentence);
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
    $cod_material = $this->objMaterial->getCodArea();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

		//--------------Se ejecuta Comando SQL-------------------------

    $sentence = "DELETE FROM area where IDAREA =" . $cod_material . "";
    $recordSet = $objConnection->executeSQL($bd, $sentence);
    
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
  function read()
  {
    $cod_material = $this->objMaterial->getCodArea();

    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    $sentence = "SELECT * FROM area WHERE IDAREA =" . $cod_material . "";
    $recordSet = $objConnection->executeSQL($bd, $sentence);
        // LA FUNCI�N  mysql_fetch_array   PERMITE RECORRER EL RECORDSET (CURSOR A LA TABLA)
        // AQU� SE ASIGNA EL CONTENIDO DEL PRIMER REGISTRO DEL RECORDSET A UNA VARIABLE IDENTIFICADA COMO:

    $search = mysql_fetch_array($recordSet);

    $this->objMaterial->setCodArea($search['IDAREA']);
    $this->objMaterial->setName($search['NOMBRE']);
    $this->objMaterial->setSubarea($search['FKAREA']);

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