<?

class CtrConnection
{
	var $link;
	function connect($server, $db, $user, $password)
	{

		try {
			$link = mysql_connect($server, $user, $password);
		} catch (Exception $e) {
			echo "ERROR AL connectSE AL server " . $e->getMessage() . "\n";

		}
		try {
			mysql_select_db($db, $link);

		} catch (Exception $e) {
			echo "ERROR SELECCIONANDO LA BASE DE DATOS" . $e->getMessage() . "\n";
		}
		return $link;
	}

	function close($link)
	{
		try {
			mysql_close($link);
		} catch (Exception $e) {
			echo "No se ha podido close la base de datos revisa la ruta de conexión" . $e->getMessage() . "\n";
		}

	}

	function executeSQL($db, $select)
	{
		try {
			$recordSet = mysql_db_query($db, $select);
		} catch (Exception $e) {
			echo " NO SE AFECTARON LOS REGISTROS: " . $e->getMessage() . "\n";
		}
		return $recordSet;
	}
}
?>
