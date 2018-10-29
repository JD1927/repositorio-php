<?php 
class UserModel
{
	var $password;
	var $name;
	var $rol;
	var $nationality;

	function UserModel($name, $password,$rol)
	{
		$this->password = $password;
		$this->name = $name;
		$this->rol = $rol;
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
		return $this->rol;
	}

	function setRol($rol){
		$this->rol = $rol;
	}
}
?>