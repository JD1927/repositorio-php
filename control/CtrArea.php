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

    $cod = $this->objArea->getCod_Area();
    $name = $this->objArea->getName();
    $subarea = $this->objArea->getSubarea();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

		//--------------Se ejecuta Comando SQL-------------------------

    $select = "INSERT into area (IDAREA,NOMBRE,FKIDAREA) values (" . $cod . ",'" . $name . "',NULL)";
    $recordSet = $objConnection->executeSQL($bd, $select);
    $objConnection->close($enlace);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error());
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      $this->recordSet = $recordSet;

    }

  }

  function area_list()
  {
    
            //---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');
    
    
            //--------------Se ejecuta Comando SQL-------------------------

    $select = "SELECT * FROM AREA";
            //  echo " Comando SQL : ". $select;
    $recordSet = $objConnection->executeSQL($bd, $select);
    $i = 0;
    $registro = mysql_fetch_array($recordSet);
    $mat[0][0] = 3;
    while ($registro) {
      $mat[$i][1] = $registro['IDAREA'];
      $mat[$i][2] = $registro['NOMBRE'];
      $mat[$i][3] = $registro['FKIDAREA'];

      $registro = mysql_fetch_array($recordSet);
      $i = $i + 1;
    }

    $objConnection->close($enlace);
    return $mat;

  }
  function update()
  {
    $cod = $this->objArea->getCod_Area();
    $name = $this->objArea->getName();
    $subarea = $this->objArea->getSubarea();
        


		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');


    //--------------Se ejecuta Comando SQL-------------------------
    if ($subarea == '') {
      $subarea = null;
    }
    $select = "UPDATE AREA set NOMBRE='" . $name . "', FKIDAREA=" . $subarea . " where IDAREA =" . $cod . "";
    $recordSet = $objConnection->executeSQL($bd, $select);
    $objConnection->close($enlace);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error());
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      $this->recordSet = $recordSet;
    }

  }
  function delete()
  {
    $cod = $this->objArea->getCod_Area();

		//---------NOS CONECTAMOS A LA BASE DE DATOS-----------------------------------------------------------
    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');


		//--------------Se ejecuta Comando SQL-------------------------


    $select = "DELETE from AREA where IDAREA ='" . $cod . "'";
    echo " Comando SQL : " . $select;
    $recordSet = $objConnection->executeSQL($bd, $select);
    $objConnection->close($enlace);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error());
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      $this->recordSet = $recordSet;

    }

  }
  function read()
  {
    $cod = $this->objArea->getCod_Area();

    $bd = "repositorio";
    $objConnection = new CtrConnection();
    $enlace = $objConnection->connect('localhost', $bd, 'root', '');

    $select = "SELECT * from AREA where IDAREA ='" . $cod . "'";
        // echo " Comando SQL : ". $select."<br>";
    $recordSet = $objConnection->executeSQL($bd, $select);

        // LA FUNCI�N  mysql_fetch_array   PERMITE RECORRER EL RECORDSET (CURSOR A LA TABLA)
        // AQU� SE ASIGNA EL CONTENIDO DEL PRIMER REGISTRO DEL RECORDSET A UNA VARIABLE IDENTIFICADA COMO:

    $registro = mysql_fetch_array($recordSet);

    $this->objArea->setCod_Area($registro['IDAREA']);
    $this->objArea->setname($registro['name']);
    $this->objArea->setsubarea($registro['IDFKAREA']);

    $objConnection->close($enlace);
		//--------------VERIFICAMOS SI SE REALIZO LA select--------------------------------------------------
    if (!$recordSet) {
      die(" ERROR CON EL COMANDO SQL: " . mysql_error()) . "<br>";
    } else {
			//----------AL RESULTADO QUE SE VA A RETORNAR = RESULTADO DE LA select---------------
      return $this->objArea;

    }

  }



        // function area_list(){

        // $bd="facturas";
        // $objConnection=new CtrConnection();
        // $enlace=$objConnection->connect('localhost',$bd,'root','');
        // $select="select * from Usuarios";
        //       $recordSet=$objConnection->executeSQL($bd,$select);

        // // LA FUNCI�N  mysql_num_rows DEVUELVE EL N�MERO DE REGISTROS DEL RECORDSET
        //       $numRegistros = mysql_num_rows($recordSet);

        // //SE ASIGNA EN UNA POSICI�N DESOCUPADA (EN ESTE CASO LA $mat[0][0], EL VALOR CON EL N�MERO DE REGISTROS
        //       $mat[0][0]= $numRegistros;
        //       $i=0;

        // // LA FUNCI�N  mysql_fetch_array   PERMITE RECORRER EL RECORDSET (CURSOR A LA TABLA Usuario)
        // // AQU� SE ASIGNA EL CONTENIDO DEL PRIMER REGISTRO DEL RECORDSET A UNA VARIABLE IDENTIFICADA COMO:
        // //  $registro
        // //CON EL CICLO MIENTRAS SE ASIGNA CADA REGISTRO DEL RECORDSET A CADA FILA DE LA MATRIZ
        //       while ($registro = mysql_fetch_array($recordSet)){
	    //       $i=$i+1;
        //       $mat[$i][0]=  $registro['usuario'];
        //       $mat[$i][1]=  $registro['contrasena'];

        //        }

        // //SE LIBERA MEMORIA DEL CURSOR ($recordSet) CON LA FUNCI�N  mysql_free_result
        //       mysql_free_result($recordSet);
        //       $objConnection->close($enlace);

        // //RETORNA LA MATRIZ CON LOS REGISTROS, PARA SER RECORRIDA EN LA VISTA (VistaUsuario.php)
        //       return $mat;
        // }

//        function  validarIngreso(){
//             $esValido=false;
//             $objUsuario1 = new Usuario('','');
// 	        $objConnection=new CtrConnection();
//             $bd="facturas";
//             $enlace=$objConnection->connect('localhost',$bd,'root','');

//             $select= "select * from Usuarios where usuarios.Usuario='" . $this->objUsuario->getNomUsuario().
//              "' and usuarios.contrasena= '" . $this->objUsuario->getContrasena(). "'";

//              try{
//                  $recordSet=$objConnection->executeSQL($bd,$select);
//                  $registro = mysql_fetch_array($recordSet);
//                  $objUsuario1->setNomUsuario($registro['usuario']);
//                  $objUsuario1->setContrasena($registro['contrasena']);
// ;
//                 }
//          	catch (Exception $e)
//             	{
//             	echo "ERROR SELECCIONANDO EN LA BASE DE DATOS".$e->getMessage()."\n";
//                 }
//                  $objConnection->close($enlace);

//             if ($this->objUsuario->getNomUsuario()==$objUsuario1->getNomUsuario() &&
//                $this->objUsuario->getContrasena()==$objUsuario1->getContrasena()  &&
//                $this->objUsuario->getNomUsuario() != "" &&
//                $this->objUsuario->getContrasena() != ""){
//                  $esValido = true;
//             }
//             else
//                 {
//                 $esValido = false;
//                 }
//              return $esValido;

//       }
}


?>