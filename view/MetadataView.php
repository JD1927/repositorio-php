<?php
//error_reporting(0);
//Inicia la sesión
session_start();
//Valida que dentro de la sesión estén todos los valores requeridos para acceder a la página
if (!$_SESSION["name"] && !$_SESSION["password"] && !$_SESSION["rol"]) {
  header('Location: index.php');
}
//Incluye código 
include("../model/MetadataModel.php");
include("../control/CtrMetadata.php");

include("../control/CtrConnection.php");

include("../control/CtrMaterial.php");
include("../model/MaterialModel.php");

//Variables
$cod_metadata = "";
$type = "";
$date_created = "";
$date_updated = "";
$user = "";
$audency = "Seleccione la audiencia...";
$compatibility = "Seleccione la compatibilidad...";
$language = "Seleccione el idioma...";
$cost = "";

$cod_material = $_REQUEST['cod_material'];

$id_material = $_REQUEST['cod_m_material'];

$cod_metadata =$_REQUEST['cod_d_metadata'];
//Acciones 
$metadata_msm = null;
$mensaje = null;
//Directorio donde se van a guardar el metadata
$target_dir = "../metadata/";

//Listar metadatas por $cod_material

  //create
if ($_POST["create"] == "create") {
  if ($_FILES['metadata']['type'] == "application/zip") {
    try {
      //Carpeta de destino
      //Archivo
      $metadata = $target_dir . basename($_FILES['metadata']['name']);
      $filename = $_FILES['metadata']['name'];
      if (!file_exists($metadata)) {
        if (move_uploaded_file($_FILES['metadata']['tmp_name'], $metadata)) {

          $type = $_POST['type'];
          $date_created = date('Y-m-d');
          $date_updated = date('Y-m-d');
          $user = $_SESSION["name"];
          $audency = $_POST['audency'];
          $compatibility = $_POST['compatibility'];
          $language = $_POST['language'];
          $cost = $_POST['cost'];

          //Metadata
          $objMetadata = new MetadataModel(null,$type,$filename,$date_created,$date_updated,$user,$audency,$compatibility,$language,$cost);

          $objMaterial = new MaterialModel($cod_material, null, null, null);

          $objCtrMaterial = new CtrMetadata($objMetadata, $objMaterial);

          $objCtrMaterial->create();
          //Esta variable se usa para mostrar un mensaje de alerta
          $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";

          sleep(3);
          
          header('Location: MaterialView.php');
    
          /* $areas = $objCtrArea->area_list();
          $length_areas = count($areas); */
        } else {
          $metadata_msm = "¡El " . $_FILES['metadata']['name'] . " no se pudo subir satisfactoriamente! <span><i class='fas fa-frown'></i></span>";
        }
      } else {
        $metadata_msm = "¡El archivo ya existe! <span><i class='fas fa-frown'></i></span>";
      }


    } catch (Exception $exp) {
      echo "ERROR ....R " . $exp->getMessage() . "\n";
    }
  } else {
    $metadata_msm = "¡El archivo no se pudo subir satisfactoriamente! El tipo de datos es:" . $_FILES['metadata']['type'] . " <span><i class='fas fa-frown'></i></span>";
  }
}
  //select
if ($_REQUEST['cod_m_material'] || ($_REQUEST['read'] == 'read')) {

  try {
    //setting values
    $cod_material = $_REQUEST['cod_m_material'];
    $objMetadata = new MetadataModel(null, null, null, null, null, null, null, null, null, null);
    $objMaterial = new MaterialModel($cod_material, null, null, null);
    $objCtrMetadata = new CtrMetadata($objMetadata, $objMaterial);
    //Se consulta en la base de datos el material $cod_material
    $objCtrMetadata->read();
    //Se obtienen los valores consultados del material
    $cod_metadata = $objMetadata->getCodMetadata();
    $type = $objMetadata->getTypeMetadata();
    $date_created = $objMetadata->getDateCreated();
    $date_updated = $objMetadata->getDateUpdated();
    $user = $objMetadata->getUser();
    $audency = $objMetadata->getAudency();
    $compatibility = $objMetadata->getCompatibility();
    $language = $objMetadata->getLanguage();
    $cost = $objMetadata->getCost();

    if ((!is_null($cod_material) && (!empty($cod_material)))) {
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
 if ($_POST["update"] == "update") { //Falta validar cuando no suben un archivo para actualizar

  if ($_FILES['metadata']['size'] == 0) {
    $filename = null;
    $metadata_msm = null;
  } else {
    if ($_FILES['metadata']['type'] == "application/zip") {
      $metadata = $target_dir . basename($_FILES['metadata']['name']);
      $filename = $_FILES['metadata']['name'];
      if (!file_exists($image)) {
        move_uploaded_file($_FILES['metadata']['tmp_name'], $metadata);
      }
    } else {
      $metadata_msm = "¡El " . $_FILES['metadata']['name'] . " no tiene la extensión correcta! <span><i class='fas fa-frown'></i></span>";
    }
  }

  try {
    $cod_metadata = $_POST['cod_metadata'];
    $type = $_POST['type'];
    $date_updated = date('Y-m-d');
    $user = $_SESSION['name'];
    //$filename
    $audency = $_POST['audency'];
    $compatibility = $_POST['compatibility'];
    $language = $_POST['language'];
    $cost = $_POST['cost'];
    $cod_material = $_POST['cod_material'];
    $objMaterial = new MaterialModel($cod_material, null, null, null);
    $objMetadata = new MetadataModel($cod_metadata,$type,$filename,null,$date_updated,$user,$audency,$compatibility,$language,$cost);

    $objCtrMetadata = new CtrMetadata($objMetadata, $objMaterial);

    if ($objCtrMetadata->update()) {
      $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";
      sleep(3);
      header('Location','MaterialView.php');
    } else {
      $message = "¡La acción no se pudo realizar satisfactoriamente! <span><i class='fas fa-frown'></i></span>";
    }
  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }
}
  //delete
if ($_REQUEST['delete'] == 'delete') {

  try {

    $cod_metadata = $_REQUEST['cod_metadata'];
    
    $objMetadata = new MetadataModel($cod_metadata, null, null, null, null, null, null, null, null, null);
    $objMaterial = new MaterialModel(null, null, null, null);
    $objCtrMetadata = new CtrMetadata($objMetadata, $objMaterial);

    if ($objCtrMetadata->delete()) {
      $message = "¡La acción se realizó exitosamente! <span><i class='fas fa-check-circle'></i></span>";
      sleep(3);
      header('Location: MaterialView.php');
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

      <main role='main' class='col-md-9 ml-sm-auto col-lg-10 px-4'>";
echo "<div class='container'>
          <a href='MaterialView.php' class='btn btn-success btn-block' role='button'>
            <span><i class='fas fa-chevron-circle-left'></i><span> Volver
          </a>
          <br>
          <div class='card'>
            <div class='card-header' style='text-align: center;'>
              <h4>Metadata</h4>
            </div>
            <div class='card-body'>
              <form name='metadataForm' method='POST' action='MetadataView.php' enctype='multipart/form-data'>
                <div class='form'>
                  <div class='form-row'>
                    <div class='form-group col-md-6'>
                      <label for='cod_metadata'>Código</label>
                      <input type='text' class='form-control' value='" . $cod_metadata . "' name='cod_metadata' id='cod_metadata' placeholder='Código del metadata'>
                    </div>
                    <div class='form-group col-md-6'>
                      <label for='type'>Tipo</label>
                      <input type='text' class='form-control' value='" . $type . "' name='type' id='type' placeholder='Tipo de metadata'>
                    </div>
                  </div>";
                  if($_REQUEST['cod_m_material']){
                    echo "<div class='form-row'>
                    <div class='form-group col-md-4'>
                      <label for='date_created'>Fecha de creación</label>
                      <input type='text' class='form-control' value='" . $date_created . "' name='date_created' id='date_created' readonly>
                    </div>
                    <div class='form-group col-md-4'>
                      <label for='date_updated'>Última modificación</label>
                      <input type='text' class='form-control' value='" . $date_updated . "' name='date_updated' id='date_updated' readonly>
                    </div>
                    <div class='form-group col-md-4'>
                      <label for='user'>Usuario</label>
                      <input type='text' class='form-control' value='" . $user . "' name='user' id='user' readonly>
                    </div>
                  </div>";
                  }
                  echo "<div class='form-row'>
                    <div class='form-group col-md-6'>
                      <label for='audency'>Audiencia</label>
                      <select id='audency' name='audency' class='form-control custom-select'>
                        <option selected>" . $audency . "</option>
                        <option value='Docentes'>Docentes</option>
                        <option value='Estudiantes'>Estudiantes</option>
                      </select>
                    </div>
                    <div class='form-group col-md-6'>
                      <label for='compatibility'>Compatibilidad</label>
                      <select id='compatibility' name='compatibility' class='form-control custom-select'>";
                        if($_REQUEST['cod_m_material']){
                          echo "<option value='".$compatibility."' selected>" . (($compatibility == true || $compatibility == 1)?'Compatible':'No Compatible') . "</option>";
                        }else{
                          echo "<option selected>" . $compatibility . "</option>";
                        }
                        
                        echo "<option value='1'>Compatible</option>
                        <option value='0'>No compatible</option>
                      </select>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label for='metadata'>Metadata del material</label>
                    <input type='file' class='form-control-file' value='" . $metadata . "' name='metadata' id='metadata'>";
            if ($_REQUEST['cod_m_material']) {
              echo "<span><summary>Los metadatos se pueden visualizar regresando a la opción de <b>materiales</b> y luego en <b>ver metadatos</b></summary><span>";
            }
            echo "</div>
                  
                  <div class='form-row'>
                  <div class='form-group col-md-6'>
                    <label for='language'>Idioma</label>
                    <select id='language' name='language' class='form-control custom-select'>
                      <option selected>" . $language . "</option>
                      <option value='Español'>Español</option>
                      <option value='Inglés'>Inglés</option>
                      <option value='Francés'>Francés</option>
                      <option value='Alemán'>Alemán</option>
                    </select>
                  </div>
                  <div class='form-group col-md-6'>
                      <label for='cost'>Costo</label>
                      <input type='text' class='form-control' value='" . $cost . "' name='cost' id='cost' placeholder='Costo del material'>
                  </div>
                  <div hidden class='form-group col-md-6'>
                      <label for='cod_material'>Código del material</label>
                      <input type='text' class='form-control' value='" . $cod_material . "' name='cod_material' id='cod_material' placeholder='Código del material'>
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
          if (!is_null($metadata_msm)) {
            echo "<div class='alert alert-dark' role='alert'>
                  " . $metadata_msm . "
                  </div>";
          }
          echo "</main>
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