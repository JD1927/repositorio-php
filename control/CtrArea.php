<?
class CtrArea
{
  var $objArea;
  var $recordSet;
  function CtrArea($objArea)
  {
    //Obtiene el objeto de ÁreaModel
    $this->objArea = $objArea;

  }

  function create()
  {
    //Obtiene los valores ingresados en la vista
    $cod = $this->objArea->getCodArea();
    $name = $this->objArea->getName();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

		//--------------Se ejecuta Comando SQL-------------------------

    $select = "INSERT into area (IDAREA,NOMBRE) values (" . $cod . ",'" . $name . "')";
    $recordSet = $objConnection->executeSQL($bd, $select);
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

  function area_list()
  {
    
            //---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');
    
    
            //--------------Se ejecuta Comando SQL-------------------------

    $select = "SELECT * FROM area";
            //  echo " Comando SQL : ". $select;
    //Obtiene los registros de la consulta
    $recordSet = $objConnection->executeSQL($bd, $select);
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
    $cod = $this->objArea->getCodArea();
    $name = $this->objArea->getName();
    $subarea = $this->objArea->getSubarea();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    //Valida si el campo de subárea está nulo o vacío para ejecutar una sentencia
    if (is_null($subarea) || $subarea == '') {
      $select = "UPDATE `area` SET `NOMBRE` = '".$name."', `FKAREA` = NULL WHERE `area`.`IDAREA` = ".$cod."";
    }else{
      $select = "UPDATE area set NOMBRE='" . $name . "', FKAREA=" . $subarea . " where IDAREA =" . $cod . "";
    }
    //Obtiene si el resultado de la operación fue exitoso
    $recordSet = $objConnection->executeSQL($bd, $select);
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
    $cod = $this->objArea->getCodArea();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

		//--------------Se ejecuta Comando SQL-------------------------

    $select = "DELETE FROM area where IDAREA =" . $cod . "";
    $recordSet = $objConnection->executeSQL($bd, $select);
    
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
    $cod = $this->objArea->getCodArea();

    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $link = $objConnection->connect('localhost', $bd, 'root', '');

    $select = "SELECT * FROM area WHERE IDAREA =" . $cod . "";
    $recordSet = $objConnection->executeSQL($bd, $select);
        // LA FUNCI�N  mysql_fetch_array   PERMITE RECORRER EL RECORDSET (CURSOR A LA TABLA)
        // AQU� SE ASIGNA EL CONTENIDO DEL PRIMER REGISTRO DEL RECORDSET A UNA VARIABLE IDENTIFICADA COMO:

    $search = mysql_fetch_array($recordSet);

    $this->objArea->setCodArea($search['IDAREA']);
    $this->objArea->setName($search['NOMBRE']);
    $this->objArea->setSubarea($search['FKAREA']);

    $objConnection->close($link);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error()) . "<br>";
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      return $this->objArea;

    }

  }
}


?>