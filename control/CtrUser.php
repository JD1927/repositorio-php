<?php

class CtrUser
{
  var $objUserModel = null;
  var $recordSet = null;

  function CtrUser($objUserModel)
  {
    $this->objUserModel = $objUserModel;
  }

  function create()
  {

    $password = $this->objUserModel->getPassword();
    $username = $this->objUserModel->getName();
    $rol = $this->objUserModel->getRol();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

		//--------------Se ejecuta Comando SQL-------------------------

    $select = "INSERT INTO usuario VALUES (" . $password . ",'" . $username . "'," . $rol . ")";
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

  function user_list()
  {
    
            //---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');
    
    
            //--------------Se ejecuta Comando SQL-------------------------

    $select = "SELECT u.IDUSUARIO,u.NOMBRE, r.NOMBRE AS ROL 
    FROM usuario u INNER JOIN rol r ON u.IDROL = r.IDROL ";
            //  echo " Comando SQL : ". $select;
    $recordSet = $objConnection->executeSQL($bd, $select);
    $i = 0;
    //$registro = 
    $mat[0][0] = 3;
    while ($search = mysql_fetch_array($recordSet)) {

      $mat[$i][1] = $search['NOMBRE'];
      $mat[$i][2] = $search['IDUSUARIO'];
      $mat[$i][3] = $search['ROL'];
      $i = $i + 1;
    }

    $objConnection->close($enlace);
    return $mat;

  }

  function update()
  {
    $password = $this->objUserModel->getPassword();
    $username = $this->objUserModel->getName();
    $rol = $this->objUserModel->getRol();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

    //--------------Se ejecuta Comando SQL-------------------------

    $select = "UPDATE usuario SET NOMBRE = '" . $username . "', 
    IDROL = ".$rol." 
    WHERE IDUSUARIO = " . $password . "";
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
    $password = $this->objUserModel->getPassword();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

		//--------------Se ejecuta Comando SQL-------------------------

    $select = "DELETE FROM usuario where IDUSUARIO =" . $password . "";
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
    $password = $this->objUserModel->getPassword();

    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

    $select = "SELECT u.IDUSUARIO,u.NOMBRE, r.NOMBRE AS ROL 
    FROM usuario u INNER JOIN rol r 
    ON u.IDROL = r.IDROL 
    WHERE u.IDUSUARIO = ".$password."";

    $recordSet = $objConnection->executeSQL($bd, $select);
        // LA FUNCI�N  mysql_fetch_array   PERMITE RECORRER EL RECORDSET (CURSOR A LA TABLA)
        // AQU� SE ASIGNA EL CONTENIDO DEL PRIMER REGISTRO DEL RECORDSET A UNA VARIABLE IDENTIFICADA COMO:

    $search = mysql_fetch_array($recordSet);

    $this->objUserModel->setPassword($search['IDUSUARIO']);
    $this->objUserModel->setName($search['NOMBRE']);
    $this->objUserModel->setRol($search['ROL']);

    $objConnection->close($enlace);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error()) . "<br>";
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      return $this->objUserModel;

    }

  }

  function validate_user()
  {
    $username = $this->objUserModel->getName();
    $password = $this->objUserModel->getPassword();

    $bd = "repositorio";
    $objCtrConnection = new CtrConnection();
    $link = $objCtrConnection->connect('localhost', $bd, 'root', '');

    $select = "SELECT * FROM usuario WHERE NOMBRE='" . $username . "' AND IDUSUARIO =" . $password . "";

    $recordSet = $objCtrConnection->executeSQL($bd, $select);
    $search = mysql_fetch_array($recordSet);

    $this->objUserModel->setName($search['NOMBRE']);
    $this->objUserModel->setPassword($search['IDUSUARIO']);
    $this->objUserModel->setRol($search['IDROL']);

    $objCtrConnection->close($link);

    if (!$recordSet) {
      die("ERROR CON EL COMANDO SQL: " . mysql_error());

    } else {
      $this->recordSet = $recordSet;
    }
  }
}
	