<?php
//Inicia la sesión
session_start();
//Valida que dentro de la sesión estén todos los valores requeridos para acceder a la página
if (!$_SESSION["name"] && !$_SESSION["password"] && !$_SESSION["rol"]) {
  header('Location: index.php');
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

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
    crossorigin="anonymous">
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
              <a class="nav-link active" href="HomeView.php">
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
            <li class="nav-item">
              <a class="nav-link" href="MaterialView.php">
                <span><i class='fas fa-box'></i></span>
                Materiales
              </a>
            </li>
            <?
              if($_SESSION['rol'] == 1){
                echo "
                <li class='nav-item'>
                  <a class='nav-link' href='UserView.php'>
                    <span><i class='fas fa-user-shield'></i></span>
                    Usuarios
                  </a>
                </li>";
              }
            ?>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Repositorio</h1>
        </div>
        <div class="container">
          <div class="jumbotron">
            <h1 class="display-3">¡Contenidos de aprendizaje!</h1>
            <hr class="my-4">
            <p class="lead">
              Es una plataforma interactiva donde podrás utilizar excelentes contenidos de aprendizaje
              y usar algunos materiales de estudio tales como: archivos de texto, sitios web, imágenes, videos, entre
              otros.
            </p>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
    feather.replace()
  </script>

</body>

</html>