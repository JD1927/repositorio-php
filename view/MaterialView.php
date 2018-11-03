<?php

error_reporting(0);
//Inicia la sesión
session_start();
//Valida que dentro de la sesión estén todos los valores requeridos para acceder a la página
if (!$_SESSION["name"] && !$_SESSION["password"] && !$_SESSION["rol"]) {
  header('Location: index.php');
}
//Incluye código 
//include("../model/AreaModel.php");
include("../control/CtrArea.php");
include("../control/CtrConnection.php");
include("../control/CtrMaterial.php");
include("../model/MaterialModel.php");
include("../model/AreaModel.php");
include("../model/AuthorModel.php");
include("../control/CtrAuthor.php");
//Variables
$image = "";
$title = "";
$description = "";
$cod_material = "";

$author = "Seleccione un autor...";
$cod_author = "";

$cod_area = "area";
$area = "Seleccione un área...";

$message = null;
$image_msm = null;
$target_dir = "../material_images/";

//Acciones 

//Listar autores
$objAuthor = new AuthorModel(null, null, null);
$objCtrAuthor = new CtrAuthor($objAutor);
$authors = $objCtrAuthor->autor_list();
$author_length = count($authors);

//Listar áreas
$objArea = new AreaModel(null, null, null);
$objCtrArea = new CtrArea($objArea);
$areas = $objCtrArea->area_list();
$area_length = count($areas);
//Listar materiales
$objMaterial = new MaterialModel(null, null, null, null);
$objCtrMaterial = new CtrMaterial($objMaterial, $objArea, $objAuthor);
$materials = $objCtrMaterial->material_list();
$material_length = count($materials);

  //create
if ($_POST["create"] == "create") {

  if ($_FILES['image']['type'] == "image/jpeg" ||
    $_FILES['image']['type'] == "image/png") {
    try {
      
      //Carpeta de destino
      //Archivo
      $image = $target_dir . basename($_FILES['image']['name']);
      $filename = $_FILES['image']['name'];
      if (!file_exists($image)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
          $title = $_POST["title"];
          $description = $_POST["description"];
          $cod_author = $_POST["cod_author"];
          $cod_area = $_POST["cod_area"];

          $objMaterial = new MaterialModel(null, $title, $description, $filename);
          $objArea = new AreaModel($cod_area, null, null);
          $objAuthor = new AuthorModel($cod_author, null, null);
          $objCtrMaterial = new CtrMaterial($objMaterial, $objArea, $objAuthor);

          $objCtrMaterial->create();
          //Esta variable se usa para mostrar un mensaje de alerta
          $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";
          //Vacia los variables correspondientes al área

          $objMaterial = new MaterialModel(null, null, null, null);
          $objCtrMaterial = new CtrMaterial($objMaterial, $objArea, $objAuthor);
          $materials = $objCtrMaterial->material_list();
          $material_length = count($materials);
        } else {
          $image_msm = "¡El " . $_FILES['image']['name'] . " no se pudo subir satisfactoriamente! <span><i class='fas fa-frown'></i></span>";
        }
      } else {
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
    $cod_material = $_POST['cod_material'];
    $objArea = new AreaModel(null, null, null);
    $objMaterial = new MaterialModel($cod_material, null, null, null);
    $objAuthor = new AuthorModel(null, null, null);
    $objCtrMaterial = new CtrMaterial($objMaterial, $objArea, $objAuthor);
    //Se consulta en la base de datos el material $cod_material
    $objCtrMaterial->read();
    //Se obtienen los valores consultados del material
    $cod_material = $objMaterial->getCodMaterial();
    $image = $objMaterial->getImage();
    $title = $objMaterial->getTitle();
    $description = $objMaterial->getDescription();
    //Se obtienen los valores consultados del área
    $cod_area = $objArea->getCodArea();
    $area = $objArea->getName();
    //Se obtienen los valores consultados del autor
    $cod_author = $objAuthor->getIdAuthor();
    $author = $objAuthor->getName();

    if ((!is_null($cod_material) && (!empty($cod_material)))) {
      //Esta variable se usa para mostrar un mensaje de alerta
      $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";

      $objMaterial = new MaterialModel(null, null, null, null);
      $objCtrMaterial = new CtrMaterial($objMaterial, $objArea, $objAuthor);
      $materials = $objCtrMaterial->material_list();
      $material_length = count($materials);
    } else {
      $message = "¡La acción no se pudo realizar satisfactoriamente! <span><i class='fas fa-frown'></i></span>";
    }
  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }

}
  //update
if ($_POST["update"] == "update") { //Falta validar cuando no suben un archivo para actualizar

  if ($_FILES['image']['size'] == 0) {
    $filename = null;
    $image_msm = null;
  } else {
    if ($_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/png") {
      $image = $target_dir . basename($_FILES['image']['name']);
      $filename = $_FILES['image']['name'];
      if (!file_exists($image)) {
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
      }
    } else {
      $image_msm = "¡El " . $_FILES['image']['name'] . " no tiene la extensión correcta! <span><i class='fas fa-frown'></i></span>";
    }
  }

  try {
    $cod_material = $_POST['cod_material'];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $cod_author = $_POST["cod_author"];
    $cod_area = $_POST["cod_area"];

    $objArea = new AreaModel($cod_area, null, null);
    $objMaterial = new MaterialModel($cod_material, $title, $description, $filename);
    $objAuthor = new AuthorModel($cod_author, null, null);
    $objCtrMaterial = new CtrMaterial($objMaterial, $objArea, $objAuthor);

    if ($objCtrMaterial->update()) {
      $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";
      $image = "";
      $title = "";
      $description = "";
      $cod_material = "";
    } else {
      $message = "¡La acción no se pudo realizar satisfactoriamente! <span><i class='fas fa-frown'></i></span>";
    }
    $objMaterial = new MaterialModel(null, null, null, null);
    $objCtrMaterial = new CtrMaterial($objMaterial, $objArea, $objAuthor);
    $materials = $objCtrMaterial->material_list();
    $material_length = count($materials);
  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }
}
  //delete
if ($_POST["delete"] == "delete") {

  try {

    $cod_material = $_POST["cod_material"];
    $cod_area = $_POST["cod_area"];

    $objArea = new AreaModel($cod_area, null, null);
    $objMaterial = new MaterialModel($cod_material, null, null, null);
          //$objAuthor = new AuthorModel()
    $objCtrMaterial = new CtrMaterial($objMaterial, $objArea);

    if ($objCtrMaterial->delete()) {
      $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";
    } else {
      $message = "¡La acción no se pudo realizar satisfactoriamente! <span><i class='fas fa-frown'></i></span>";
    }

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
            Materiales
          </a>
        </li>
        <li class='nav-item'>
          <a class='nav-link' href='AuthorView.php'>
            <span><i class='fas fa-users'></i></span>
            Autores
          </a>
        </li>";
        if ($_SESSION['rol'] == 1) {
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
          <div class='card-header' style='text-align: center;'>
          <h4>Material</h4>
          </div>";
          if($image != '' || $image != null){
            echo "<img class='card-img-top' src='../material_images/".$image."'>";
          }
            echo "<div class='card-body'>
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
                    <textarea class='form-control' name='description' id='description' rows='1'>" . $description . "</textarea>
                  </div>
                  <div class='form-group'>
                    <label for='image'>Imagen del material</label>
                    <input type='file' class='form-control-file' value='" . $image . "' name='image' id='image'>";
            if ($_POST['read'] == 'read') {
              echo "<span><summary>Las imágenes se pueden visualizar en oprimiendo el enlace de la lista de materiales</summary><span>";
            }
          echo "</div>
                  <div class='form-row'>
                    <div class='form-group col-md-6'>
                      <label for='cod_area'>Área</label>
                      <select id='cod_area' name='cod_area' class='form-control'>
                        <option selected value='" . $cod_area . "'>" . $area . "</option>";
                for ($i = 0; $i < $area_length; $i++) {
                  echo "<option value='" . $areas[$i][1] . "'>" . $areas[$i][2] . "</option>";
                }
            echo "</select>
                    </div>
                    <div class='form-group col-md-6'>
                      <label for='cod_author'>Autor</label>
                      <select id='cod_author' name='cod_author' class='form-control'>
                        <option selected value='" . $cod_author . "'>" . $author . "</option>";
                for ($i = 0; $i < $author_length; $i++) {
                  echo "<option value='" . $authors[$i][1] . "'>" . $authors[$i][2] . "</option>";
                }
                echo "</select>
                    </div>
                  </div>
                </div>
                <br><br>
                <div class='form-group'>
                  <div class='row'>
                    <div class='col-md-6'>
                      <button type='submit' name='create' value='create' class='btn btn-dark btn-block'>
                      <span><i class='fas fa-user-plus'></i></span> Crear</button>

                      <button type='submit' name='read' value='read' class='btn btn-dark btn-block'>
                      <span><i class='fas fa-search'></i></span> Consultar</button>
                    </div>
                    <div class='col-md-6'>
                      <button type='submit' name='update' value='update' class='btn btn-dark btn-block'>
                      <span><i class='fas fa-wrench'></i></span> Actualizar</button>
                          
                      <button type='submit' name='delete' value='delete' class='btn btn-dark btn-block'>
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
        if ($material_length > 0) {
          echo "<div class='container'>  
                  <div>
                  <br>
                    <table class='table table-hover table-response'>
                      <thead class='thead-dark'>
                        <tr>
                            <th scope='col'>Código Material</th>
                            <th scope='col'>Título</th>
                            <th scope='col'>Descripcion</th>
                            <th scope='col'>Imagen</th>
                            <th scope='col'>Nombre Autor</th>
                            <th scope='col'>Área</th>
                            <th scope='col' style='text-align:center;'>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>";

                for ($i = 0; $i < $material_length; $i++) {
                  echo "<tr>
                          <td scope='row'>" . $materials[$i][1] . "</td>
                          <td scope='row'>" . $materials[$i][2] . "</td>
                          <td scope='row' title='" . $materials[$i][3] . "'>" . substr($materials[$i][3], 0, 10) . "...</td>
                          <td scope='row'><a href='../material_images/" . $materials[$i][4] . "' target='_blank' download class='alert-link'>" . $materials[$i][4] . " <span><i class='fas fa-download'></i></span></a></td>
                          <td scope='row' title='" . $materials[$i][6] . "'>" . substr($materials[$i][6], 0, 10) . "...</td>
                          <td scope='row'>" . $materials[$i][8] . "</td>
                          <td scope='row' title='Realizar acciones'>
                            <div class='row'>
                              <div class='col col-md-6'>
                                <form name='metadataForm' method='GET' title='Agregar metadata del material' action='MetadataView.php'>
                                  <input type='hidden' id='cod_material' name='cod_material' value='" . $materials[$i][1] . "'>
                                  <button type='submit' class='btn btn-dark btn-block'>
                                    <span title='Crear metadata del material'><i class='fas fa-folder-plus'></i><span>
                                  </button>
                                </form>
                              </div>
                              <div class='col col-md-6'>
                                <form name='metadataListForm' method='GET' title='Ver lista de metadata del material' action='MetadataListView.php'>
                                  <input type='hidden' id='cod_m_metadata' name='cod_m_metadata' value='" . $materials[$i][1] . "'>
                                  <button type='submit' class='btn btn-dark btn-block'>
                                    <span title='Consultar metadata del material'><i class='fas fa-list-alt'></i><span>
                                  </button>
                                </form>
                              </div>
                            </div>
                          </td>
                        </tr>";
                }
                echo "</tbody>  
                    </table>
                  </div>
                </div>";
      } else {
        echo "<div class='container'><h3>No hay materiales disponibles. Crea un nuevo material</h3></div>";
      }
              echo "
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