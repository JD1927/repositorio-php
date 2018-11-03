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

//Variables
$name = "";
$subarea = "";
$cod = "";
$message = null;

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
    //Esta variable se usa para mostrar un mensaje de alerta
    $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";
    //Vacia los variables correspondientes al área
    $name = "";
    $subarea = "";
    $cod = "";

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
    $objArea = new AreaModel($cod, null, null);
    $objCtrArea = new CtrArea($objArea);

    $objCtrArea->read();

    $cod = $objArea->getcodArea();
    $name = $objArea->getName();
    $subarea = $objArea->getSubarea();

    if ((!is_null($cod) && (!empty($cod)))) {
      //Esta variable se usa para mostrar un mensaje de alerta
      $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";
    } else {
      $message = "¡La acción no se pudo realizar satisfactoriamente! <span><i class='fas fa-frown'></i></span> <span><i class='fas fa-frown'></i></span> <span><i class='fas fa-frown'></i></span> <span><i class='fas fa-frown'></i></span>";
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

    if ($objCtrArea->update()) {
      $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";
      //Vacia los variables correspondientes al área
      $name = "";
      $subarea = "";
      $cod = "";
    } else {
      $message = "¡La acción no se pudo realizar satisfactoriamente! <span><i class='fas fa-frown'></i></span> <span><i class='fas fa-frown'></i></span> <span><i class='fas fa-frown'></i></span> <span><i class='fas fa-frown'></i></span>";
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

    if ($objCtrArea->delete()) {
      $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";
            //Vacia los variables correspondientes al área
      $name = "";
      $subarea = "";
      $cod = "";
    } else {
      $message = "¡La acción no se pudo realizar satisfactoriamente! <span><i class='fas fa-frown'></i></span> <span><i class='fas fa-frown'></i></span> <span><i class='fas fa-frown'></i></span> <span><i class='fas fa-frown'></i></span>";
    }
    $mat = $objCtrArea->area_list();
    $length = count($mat);

  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }

}

echo "<!DOCTYPE html>
<html lang='en'>

<head>

  <meta name='author' content='>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta name='description' content='>
  <meta http-equiv='X-UA-Compatible' content='ie=edge'>

  <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO'
    crossorigin='anonymous'>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css' integrity='sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU'
    crossorigin='anonymous'>
  <link rel='stylesheet' href='../styles/utilities.css'>
  <title>Repositorio - PHP</title>

  <link href='../styles/dashboard.css' rel='stylesheet'>
</head>

<body>
  <nav class='navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow'>
    <a class='navbar-brand col-sm-3 col-md-2 mr-0' href='HomeView.php'>Repositorio</a>
    <ul class='navbar-nav'>
      <li class='nav-item'>
        <a href='logout.php' class='btn btn-danger' role='button'>Cerrar sesión</a>
      </li>
    </ul>
  </nav>

  <div class='container-fluid'>
    <div class='row'>
      <nav class='col-md-2 d-none d-md-block bg-light sidebar'>
        <div class='sidebar-sticky'>
          <ul class='nav flex-column'>
            <li class='nav-item'>
              <a class='nav-link' href='HomeView.php'>
                <span><i class='fas fa-home'></i></span>
                Inicio
              </a>
            </li>
            <li class='nav-item'>
              <a class='nav-link active' href='AreaView.php'>
                <span><i class='fas fa-square-root-alt'></i></span>
                Áreas
              </a>
            </li>
            <li class='nav-item'>
              <a class='nav-link' href='MaterialView.php'>
                <span><i class='fas fa-box'></i></span>
                Materiales
              </a>
            </li>
            <li class='nav-item'>
              <a class='nav-link' href='AuthorView.php'>
                <span><i class='fas fa-users'></i></span>
                Autores
              </a>
            </li>";
            if($_SESSION['rol'] == 1){
              echo "
              <li class='nav-item'>
                <a class='nav-link' href='UserView.php'>
                  <span><i class='fas fa-user-shield'></i></span>
                  Usuarios
                </a>
              </li>";
            }
          echo "</ul>
        </div>
      </nav>

      <main role='main' class='col-md-9 ml-sm-auto col-lg-10 px-4'>
        <div class='container'>
          <div class='card'>
          <div class='card-header' style='text-align: center;'><h4>Área</h4></div>
            <div class='card-body'>
              <form name='areaForm' method='POST' action='AreaView.php'>
                <div class='row'>
                  <div class='col-md-6'>
                  <div class='form'>
                  <div class='input-group mb-3'>
                    <div class='input-group-prepend'>
                      <span class='input-group-text' id='cod'>Código</span>
                    </div>
                    <input type='text' class='form-control' value='" . $cod . "' name='cod' placeholder='Código de área' autocomplete='off'>
                  </div>
                  <div class='input-group mb-3'>
                    <div class='input-group-prepend'>
                      <span class='input-group-text' id='name'>Nombre</span>
                    </div>
                    <input type='text' class='form-control' value='" . $name . "' name='name' placeholder='Nombre del área' autocomplete='off'>
                  </div>
                  <div class='input-group mb-3'>
                    <div class='input-group-prepend'>
                      <span class='input-group-text' id='subarea'>Subárea</span>
                    </div>
                    <input type='text' class='form-control' value='" . $subarea . "' name='subarea' placeholder='Subárea' autocomplete='off'>
                  </div>
                </div>
                  </div>
                  <div class='col-md-6'>
                    <div class='form-group'>
                      <div class='row'>
                        <br><br>
                          <button type='submit' name='create' value='create' class='btn btn-dark btn-block'>
                            <span>
                              <i class='fas fa-user-plus'></i>
                            </span> Crear</button>
                        
                          <button type='submit' name='read' value='read' class='btn btn-dark btn-block'>
                            <span>
                              <i class='fas fa-search'></i>
                            </span> Consultar</button>
                        
                          <button type='submit' name='update' value='update' class='btn btn-dark btn-block'>
                            <span>
                              <i class='fas fa-wrench'></i>
                            </span> Actualizar</button>
                        
                          <button type='submit' name='delete' value='delete' class='btn btn-dark btn-block'>
                            <span>
                              <i class='fas fa-trash'></i>
                            </span> Eliminar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>";
          if (!is_null($message)) {
            echo "<div class='alert alert-dark' role='alert'>
                                          " . $message . "
                  </div>";
          }
            echo "<div class='container'>  
                              <div>
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
                                      <td scope='row'>" . (is_null($mat[$i][3]) ? 'No tiene' : $mat[$i][3]) . "</td>
                                    </tr>";
}
                            echo "</tbody>  
                                </table>
                              </div>
                            </div>
                        </main>
                      </div>
                  </div>

  <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo'
    crossorigin='anonymous'></script>
  <script src='https://unpkg.com/feather-icons/dist/feather.min.js'></script>
  <script>
    feather.replace()
  </script>

</body>

</html>";

?>