<?php
include("../control/CtrConnection.php");

class ctrUser
{
	var $objUserModel = null;
	var $recordSet = null;

	function ctrUser($objUserModel)
	{
		$this->objUserModel = $objUserModel;
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
	