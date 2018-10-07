<?php 
class UserModel
{
	var $password;
	var $name;
	var $rol;

	function UserModel($name, $password)
	{
		$this->password = $password;
		$this->name = $name;
	}

	function getPassword()
	{
		return $this->password;
	}

	function setPassword($password)
	{
		$this->password = $password;
	}

	function getName()
	{
		return $this->name;
	}

	function setName($name)
	{
		$this->name = $name;
	}

	function getRol()
	{
		return this->rol;
	}

	function setRol($rol){
		$this->rol = $rol;
	}
}
?>