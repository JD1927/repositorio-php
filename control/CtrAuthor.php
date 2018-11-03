<?
class CtrAuthor
{
  var $objAutor;
  var $recordSet;
  function CtrAuthor($objAutor)
  {
    $this->objAutor = $objAutor;

  }

  function create()
  {

    $idAuthor = $this->objAutor->getIdAuthor();
    $name = $this->objAutor->getName();
    $nacionality = $this->objAutor->getNacionality();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

		//--------------Se ejecuta Comando SQL-------------------------

    $select = "INSERT into autor (IDAUTOR,NOMBRE,NACIONALIDAD) values (" . $idAuthor . ",'" . $name . "','" . $nacionality . "')";
    $recordSet = $objConnection->executeSQL($bd, $select);
    $objConnection->close($enlace);
		//--------------VERIFICAMOS SI SE REALIZO EL select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error());
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      $this->recordSet = $recordSet;
      return true;
    }

  }

  function autor_list()
  {
    
            //---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');
    
    
            //--------------Se ejecuta Comando SQL-------------------------
    $select = "SELECT * FROM autor";
            //  echo " Comando SQL : ". $select;
    $recordSet = $objConnection->executeSQL($bd, $select);
    $i = 0;
//$registro = 
    $mat[0][0] = 3;
    while ($registro= mysql_fetch_array($recordSet)) {
      $mat[$i][1] = $registro['IDAUTOR'];
      $mat[$i][2] = $registro['NOMBRE'];
      $mat[$i][3] = $registro['NACIONALIDAD'];
      $i = $i + 1;
    }

    $objConnection->close($enlace);
    return $mat;

  }

  function update()
  {
    $idAuthor = $this->objAutor->getIdAuthor();
    $name = $this->objAutor->getName();
    $nacionality = $this->objAutor->getNacionality();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

    //--------------Se ejecuta Comando SQL-------------------------
    
    $select = "UPDATE `autor` SET `NOMBRE` = '".$name."', `NACIONALIDAD` = '".$nacionality."' WHERE `autor`.`IDAUTOR` = ".$idAuthor."";
      //  echo " Comando SQL : ". $select;
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
    $idAuthor = $this->objAutor->getIdAuthor();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

		//--------------Se ejecuta Comando SQL-------------------------

    $select = "DELETE FROM autor where IDAUTOR =" . $idAuthor . "";
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
    $idAuthor = $this->objAutor->getIdAuthor();

    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

    $select = "SELECT * FROM autor WHERE IDAUTOR =" . $idAuthor . "";
    $recordSet = $objConnection->executeSQL($bd, $select);
        // LA FUNCI�N  mysql_fetch_array   PERMITE RECORRER EL RECORDSET (CURSOR A LA TABLA)
        // AQU� SE ASIGNA EL CONTENIDO DEL PRIMER REGISTRO DEL RECORDSET A UNA VARIABLE IDENTIFICADA COMO:

    $registro = mysql_fetch_array($recordSet);

    $this->objAutor->setIdAutor($registro['IDAUTOR']);
    $this->objAutor->setName($registro['NOMBRE']);
    $this->objAutor->setNacionality($registro['NACIONALIDAD']);

    $objConnection->close($enlace);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error()) . "<br>";
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      return $this->objAutor;

    }

  }
}


?>