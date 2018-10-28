<?php
//error_reporting(0);
//Inicia la sesión
session_start();
//Valida que dentro de la sesión estén todos los valores requeridos para acceder a la página
if (!$_SESSION["name"] && !$_SESSION["password"] && !$_SESSION["rol"]) {
  header('Location: index.php');
}
//Incluye código 
include("../control/CtrConnection.php");
include("../control/CtrMaterial.php");
include("../model/MaterialModel.php");
include("../control/CtrMetadata.php");
include("../model/MetadataModel.php");

$objMaterial = new MaterialModel($_REQUEST['cod_m_metadata'], null, null, null);

$cod_material = $objMaterial->getCodMaterial();

//Listar metadata
$objCtrMetadata = new CtrMetadata(null, $objMaterial);
$metadata = $objCtrMetadata->metadata_list();
$metadata_length = count($metadata);

echo "<!DOCTYPE html>
<html lang='en'>

<head>

  <meta name='author' content=''>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta name='description' content=''>
  <meta http-equiv='X-UA-Compatible' content='ie=edge'>

  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css' integrity='sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU'
    crossorigin='anonymous'>
  <title>Repositorio - PHP</title>

  <!-- Custom styles for this template -->
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
              <a class='nav-link active' href='HomeView.php'>
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
              <a class='nav-link' href='MaterialView.php'>
                <span><i class='fas fa-box'></i></span>
                Material
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main role='main' class='col-md-9 ml-sm-auto col-lg-10 px-4'>
        <div class='container'>
          <form name='metadataListForm' method='GET' title='Ver tabla de materiales' action='MaterialView.php'>
              <button type='submit' class='btn btn-success btn-block' value='materialActions' name='materialActions'>
                Ver lista de materiales <span><i class='fas fa-table'></i><span>
              </button>
          </form>
          <br>
          <table class='table table-hover table-response'>
            <thead class='thead-dark'>
              </tr>
                <th scope='col'>Código</th>
                <th scope='col'>Tipo</th>
                <th scope='col'>Metadato</th>
                <th scope='col' title='Fecha de creación'>Fecha...</th>
                <th scope='col' title='Última modificación'>Última...</th>
                <th scope='col' title='Usuario que ingresó el material'>Usuario</th>
                <th scope='col'>Audiencia</th>
                <th scope='col' title='Compatibilidad con otros dispositivos'>Compatibilidad</th>
                <th scope='col'>Idioma</th>
                <th scope='col'>Costo</th>
                <th scope='col'>Acciones</th>
              </tr>
            </thead>
            <tbody>";
            for($i = 0; $i< $metadata_length; $i++){
              echo "
              <tr>
                <td scope='row'>".$metadata[$i][1]."</td>
                <td scope='row'>".$metadata[$i][2]."</td>
                <td scope='row'><a href='../metadata/".$metadata[$i][3]."' target='_blank' download class='alert-link'>".$metadata[$i][3]." <span><i class='fas fa-download'></i></span></a></td>
                <td scope='row'>".$metadata[$i][4]." <span><i class='fas fa-calendar-plus'></i></span></td>
                <td scope='row'>".$metadata[$i][5]." <span><i class='fas fa-calendar-check'></i></span></td>
                <td scope='row'>".$metadata[$i][6]." <span><i class='fas fa-user-cog'></i></span></td>
                <td scope='row'>".$metadata[$i][7]."</td>
                <td scope='row'>".((($metadata[$i][8] == true) || ($metadata[$i][8] == '1'))? 'Compatible' : 'No compatible')."</td>
                <td scope='row'>".$metadata[$i][9]."</td>
                <td scope='row'>$".$metadata[$i][10]."</td>
                <td>
                  
                </td>
              </tr>";
            }
            echo "</tbody>
          </table>
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>

  <!-- Icons -->
  <script src='https://unpkg.com/feather-icons/dist/feather.min.js'></script>
  <script>
    feather.replace()
  </script>

</body>

</html>";
?>