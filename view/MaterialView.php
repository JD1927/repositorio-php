<?php
error_reporting(0);
//Inicia la sesión
session_start();
//Valida que dentro de la sesión estén todos los valores requeridos para acceder a la página
if (!$_SESSION["name"] && !$_SESSION["password"] && !$_SESSION["rol"]) {
  header('Location: index.php');
}
//Incluye código 
include("../model/AreaModel.php");
include("../control/CtrArea.php");
include("../control/CtrConnection.php");

//Variables
$image = "";
$title = "";
$description = "";
$cod_material = "";
$cod_author = "Seleccione un autor";
$cod_area = "Seleccione un área";
$message = null;
$image_msm = null;
$target_dir = "../material_images/";

//Listar áreas
$objArea = new AreaModel(null, null, null);
$objCtrArea = new CtrArea($objArea);
$areas = $objCtrArea->area_list();
$length_areas = count($areas);

  //create
if ($_POST["create"] == "create") {

  if ($_FILES['image']['type'] == "image/jpeg" ||
    $_FILES['image']['type'] == "image/png") {
    try {
      
      //Carpeta de destino
      //Archivo
      $image = $target_dir . basename($_FILES['image']['name']);
      $image_msm = $_FILES['image']['tmp_name'];
      if (!file_exists($image)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
          $image_msm = $_FILES['image']['tmp_name'];
          $title = $_POST["title"];
          $description = $_POST["description"];
          $cod_material = $_POST["cod_material"];
    
          $cod_author = $_POST["cod_author"];
          $cod_area = $_POST["cod_area"];
    
          $objArea = new AreaModel($cod_area, null, null);
          $objMaterial = new MaterialModel(null, $title, $description, $image);
          //$objAuthor = new AuthorModel()
          $objCtrMaterial = new CtrMaterial($objMaterial,$objArea);

          $objCtrMaterial->create();
          //Esta variable se usa para mostrar un mensaje de alerta
          $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";
          //Vacia los variables correspondientes al área
          $name = "";
          $subarea = "";
          $cod = "";
    
          /* $areas = $objCtrArea->area_list();
          $length_areas = count($areas); */
          }else{
            $image_msm = "¡El ".$_FILES['image']['name']." no se pudo subir satisfactoriamente! <span><i class='fas fa-frown'></i></span>";
          }
      }else{
        $image_msm = "¡El archivo ya existe! <span><i class='fas fa-frown'></i></span>";
      }
      

    } catch (Exception $exp) {
      echo "ERROR ....R " . $exp->getMessage() . "\n";
    }
  } else {
    $image_msm = "¡El archivo no se pudo subir satisfactoriamente! El tipo de datos es:" . $_FILES['image']['type'] . " <span><i class='fas fa-frown'></i></span>";
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
      $message = "¡La acción no se pudo realizar satisfactoriamente! <span><i class='fas fa-frown'></i></span>";
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
      $message = "¡La acción no se pudo realizar satisfactoriamente! <span><i class='fas fa-frown'></i></span>";
    }

    $areas = $objCtrArea->area_list();
    $length_areas = count($areas);

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
      $message = "¡La acción no se pudo realizar satisfactoriamente! <span><i class='fas fa-frown'></i></span>";
    }
    $areas = $objCtrArea->area_list();
    $length_areas = count($areas);

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
              <a class='nav-link' href='AreaView.php'>
                <span><i class='fas fa-square-root-alt'></i></span>
                Áreas
              </a>
            </li>
            <li class='nav-item'>
              <a class='nav-link active' href='MaterialView.php'>
                <span><i class='fas fa-box'></i></span>
                Material
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main role='main' class='col-md-9 ml-sm-auto col-lg-10 px-4'>
        <div class='container'>
          <div class='card'>
          <div class='card-header' style='text-align: center;'><h4>Material</h4></div>
            <div class='card-body'>
              <form name='materialForm' method='POST' action='MaterialView.php' enctype='multipart/form-data'>
                <div class='form'>
                  <div class='form-row'>
                    <div class='form-group col-md-6'>
                      <label for='cod_material'>Código</label>
                      <input type='text' class='form-control' value='" . $cod_material . "' name='cod_material' id='cod_material' placeholder='Código del material'>
                    </div>
                    <div class='form-group col-md-6'>
                      <label for='title'>Título</label>
                      <input type='text' class='form-control' value='" . $title . "' name='title' id='title' placeholder='Título del material'>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label for='description'>Descripción</label>
                    <textarea class='form-control' value='" . $description . "' name='description' id='description' rows='1'></textarea>
                  </div>
                  <div class='form-group'>
                    <label for='image'>Imagen del material</label>
                    <input type='file' class='form-control-file' style='border: 2px solid #26292D; border-radius: 25px;' value='" . $image . "' name='image' id='image'>
                  </div>
                  <div class='form-row'>
                    <div class='form-group col-md-6'>
                      <label for='cod_area'>Área</label>
                      <select id='cod_area' name='cod_area' class='form-control'>
                        <option selected>".$cod_area."</option>";
                        for ($i = 0; $i < $length_areas; $i++) {
                  echo "<option value'".$areas[$i][1]."'>".$areas[$i][1]." - ".$areas[$i][2]."</option>";
                        }
                echo "</select>
                    </div>
                    <div class='form-group col-md-6'>
                      <label for='cod_area'>Autor</label>
                      <select id='cod_area' name='cod_area' class='form-control'>
                        <option selected>".$cod_author."</option>
                        <option value='1036685232'>JUAN DAVID AGUIRRE CÓRDOBA</option>
                        <option value='1036685233'>DAVID CÓRDOBA</option>
                      </select>
                    </div>
                  </div>
                </div>
                <br><br>
                <div class='form-group'>
                  <div class='row'>
                    <div class='col-md-6'>
                      <button type='submit' name='create' value='create' class='btn btn-success btn-block'>
                      <span><i class='fas fa-user-plus'></i></span> Crear</button>

                      <button type='submit' name='read' value='read' class='btn btn-primary btn-block'>
                      <span><i class='fas fa-search'></i></span> Consultar</button>
                    </div>
                    <div class='col-md-6'>
                      <button type='submit' name='update' value='update' class='btn btn-dark btn-block'>
                      <span><i class='fas fa-wrench'></i></span> Actualizar</button>
                          
                      <button type='submit' name='delete' value='delete' class='btn btn-danger btn-block'>
                      <span><i class='fas fa-trash'></i></span> Eliminar</button>
                    </div>
                    
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
              if (!is_null($image_msm)) {
                echo "<div class='alert alert-dark' role='alert'>
                                                        " . $image_msm . "
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
                            for ($i = 0; $i < $length_areas; $i++) {
                              echo "<tr>
                                      <td scope='row'>" . $areas[$i][1] . "</td>
                                      <td scope='row'> " . $areas[$i][2] . "</td>
                                      <td scope='row'>" . (is_null($areas[$i][3]) ? 'No tiene' : $areas[$i][3]) . "</td>
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