<?php
error_reporting(0);
session_start();
if (!$_SESSION["name"]) {
  header('Location: index.php');
}
//Incluye código 
include("../model/AreaModel.php");
include("../control/CtrArea.php");
include("../control/CtrConnection.php");
 
//Listar áreas
$objArea = new AreaModel(null, null, null);
$objCtrArea = new CtrArea($objArea);
$mat = $objCtrArea->area_list();
$length = count($mat);

  //create
if ($_POST["create"] == "create") {

  try {
    //setting values
    $name = $_POST["name"];
    $subarea = $_POST["subarea"];
    $cod = $_POST["cod"];

    $objArea = new AreaModel($cod, $name, $subarea);
    $objCtrArea = new CtrArea($objArea);

    $objCtrArea->create();
    $mat = $objCtrArea->area_list();
    $length = count($mat);
  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }

}
  //select
if ($_POST["read"] == "read") {

  try {
    //setting values
    $cod = $_POST["cod"];
    $objArea = new AreaModel($cod, null, $null);
    $objCtrArea = new CtrArea($objArea);


    if ($objCtrArea->read()) {
      echo "<center> <h1>SE HA REALIZADO LA CONSULTA</h1></center>";
      echo $objArea->getcodArea() . "\n";
      echo $objArea->getname() . "\n";
      echo $objArea->getsubarea() . "\n";


    } else {
      echo "<center> <h1>NO SE HA PODIDO REALIZAR LA CONSULTA</h1></center>";
    }
  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }

}
  //update
if ($_POST["update"] == "update") {
  try {
    //setting values
    $name = $_POST["name"];
    $subarea = $_POST["subarea"];
    $cod = $_POST["cod"];

    $objArea = new AreaModel($cod, $name, $subarea);
    $objCtrArea = new CtrArea($objArea);



    if (!$objCtrArea->update()) {
      echo "<center> <h1>SE HA MODIFICADO CON EXITO</h1></center>";
    } else {
      echo "<center> <h1>NO SE HA ENCONTRADO EL AREA INGRESADA</h1></center>";
    }

    $mat = $objCtrArea->area_list();
    $length = count($mat);

  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }

}
  //delete
if ($_POST["delete"] == "delete") {

  try {

    $cod = $_POST["cod"];

    $objArea = new AreaModel($cod, null, null);
    $objCtrArea = new CtrArea($objArea);

    if (!$objCtrArea->delete()) {
      echo "<div class='alert alert-success' role='alert'>
              El área ".$cod." ha sido eliminado exitosamente!
            </div>";
    } else {
      echo "<center> <h1>NO SE HA ENCONTRADO NADA CON ESTE AREA</h1></center>";
    }
    $mat = $objCtrArea->area_list();
    $length = count($mat);

  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta name="author" content="">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
    crossorigin="anonymous">
  <link rel="stylesheet" href="../styles/utilities.css">
  <title>Repositorio - PHP</title>

  <!-- Custom styles for this template -->
  <link href="../styles/dashboard.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="HomeView.php">Repositorio</a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="logout.php" class="btn btn-danger" role="button">Cerrar sesión</a>
      </li>
    </ul>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="HomeView.php">
                <span><i class="fas fa-home"></i></span>
                Inicio
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="AreaView.php">
                <span><i class="fas fa-square-root-alt"></i></span>
                Áreas
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="container">
          <div class="card">
          <div class="card-header" style="text-align: center;"><h4>Áreas</h4></div>
            <div class="card-body">
              <form name="areaForm" method="POST" action="AreaView.php">
                <div class="row">
                  <div class="col-md-6">
                  <div class="form">
                  <div class="form-group">
                    <label for="cod">Código</label>
                    <input type="text" class="form-control" name="cod" placeholder="Código de área" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" name="name" placeholder="Nombre del área" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="subarea">Subárea</label>
                    <input type="text" class="form-control" name="subarea" placeholder="Subárea" autocomplete="off">
                  </div>
                </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="row">
                        <br><br>
                          <button type="submit" name="create" value="create" class="btn btn-success btn-block">
                            <span>
                              <i class="fas fa-user-plus"></i>
                            </span> Crear</button>
                        
                          <button type="submit" name="read" value="read" class="btn btn-primary btn-block">
                            <span>
                              <i class="fas fa-search"></i>
                            </span> Consultar</button>
                        
                          <button type="submit" name="update" value="update" class="btn btn-dark btn-block">
                            <span>
                              <i class="fas fa-wrench"></i>
                            </span> Actualizar</button>
                        
                          <button type="submit" name="delete" value="delete" class="btn btn-danger btn-block">
                            <span>
                              <i class="fas fa-trash"></i>
                            </span> Eliminar</button>
                        
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="container">
            <?php

            echo "<div>
                  <table class='table table-hover table-response'>
                    <thead class='thead-dark'>
                      <tr>
                          <th scope='col'>Código Área</th>
                          <th scope='col'>Nombre</th>
                          <th scope='col'>Subárea</th>
                      </tr>
                    </thead>
                    <tbody>";
            for ($i = 0; $i < $length; $i++) {
              echo "<tr>
                        <td scope='row'>" . $mat[$i][1] . "</td>
                        <td scope='row'> " . $mat[$i][2] . "</td>
                        <td scope='row'>" . (is_null($mat[$i][3])?'No tiene':$mat[$i][3]) . "</td>
                      </tr>";
            }
            echo "</tbody>  
                </table>
                </div>";

            ?>
        </div>

      </main>
    </div>
  </div>


  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
  <script src="../../assets/js/vendor/popper.min.js"></script>
  <script src="../../dist/js/bootstrap.min.js"></script>

  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
    feather.replace()
  </script>

</body>

</html>