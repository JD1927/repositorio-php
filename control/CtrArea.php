<?
class CtrArea
{
  var $objArea;
  var $recordSet;
  function CtrArea($objArea)
  {
    $this->objArea = $objArea;

  }

  function create()
  {

    $cod = $this->objArea->getCodArea();
    $name = $this->objArea->getName();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

		//--------------Se ejecuta Comando SQL-------------------------

    $select = "INSERT into area (IDAREA,NOMBRE) values (" . $cod . ",'" . $name . "')";
    $recordSet = $objConnection->executeSQL($bd, $select);
    $objConnection->close($enlace);
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
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');
    
    
            //--------------Se ejecuta Comando SQL-------------------------

    $select = "SELECT * FROM area";
            //  echo " Comando SQL : ". $select;
    $recordSet = $objConnection->executeSQL($bd, $select);
    $i = 0;
//$registro = 
    $mat[0][0] = 3;
    while ($registro= mysql_fetch_array($recordSet)) {
      $mat[$i][1] = $registro['IDAREA'];
      $mat[$i][2] = $registro['NOMBRE'];
      $mat[$i][3] = $registro['FKAREA'];
      $i = $i + 1;
    }

    $objConnection->close($enlace);
    return $mat;

  }

  function update()
  {
    $cod = $this->objArea->getCodArea();
    $name = $this->objArea->getName();
    $subarea = $this->objArea->getSubarea();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

    //--------------Se ejecuta Comando SQL-------------------------
    if (is_null($subarea) || $subarea == '') {
      $select = "UPDATE `area` SET `NOMBRE` = '".$name."', `FKAREA` = NULL WHERE `area`.`IDAREA` = ".$cod."";
    }else{
      $select = "UPDATE area set NOMBRE='" . $name . "', FKAREA=" . $subarea . " where IDAREA =" . $cod . "";
    }
    $recordSet = $objConnection->executeSQL($bd, $select);
    
    $objConnection->close($enlace);
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
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

		//--------------Se ejecuta Comando SQL-------------------------

    $select = "DELETE FROM area where IDAREA =" . $cod . "";
    $recordSet = $objConnection->executeSQL($bd, $select);
    
    $objConnection->close($enlace);
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
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

    $select = "SELECT * FROM area WHERE IDAREA =" . $cod . "";
    $recordSet = $objConnection->executeSQL($bd, $select);
        // LA FUNCI�N  mysql_fetch_array   PERMITE RECORRER EL RECORDSET (CURSOR A LA TABLA)
        // AQU� SE ASIGNA EL CONTENIDO DEL PRIMER REGISTRO DEL RECORDSET A UNA VARIABLE IDENTIFICADA COMO:

    $registro = mysql_fetch_array($recordSet);

    $this->objArea->setCodArea($registro['IDAREA']);
    $this->objArea->setName($registro['NOMBRE']);
    $this->objArea->setSubarea($registro['FKAREA']);

    $objConnection->close($enlace);
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