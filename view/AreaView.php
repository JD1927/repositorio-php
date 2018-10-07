<?php
session_start();
if (!$_SESSION["name"]) {
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

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Áreas</h1>
        </div>
        <div class="container">
          <a href="AreaView.php" class="badge badge-dark">
            <span>
              <i class="fas fa-chevron-circle-left"></i>
            </span> Volver</a>
          <br>
          <br>
          <div class="card">
            <h1 class="card-header" style="text-align: center;">Área</h1>
            <div class="card-body">
              <form name="areaForm" method="POST" action="Area.php">
                <div class="form">
                  <div class="form-group">
                    <label for="lname">Código</label>
                    <input type="text" class="form-control" name="cod" placeholder="Código de área" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="lname">name</label>
                    <input type="text" class="form-control" name="name" placeholder="name" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="tele">Subárea</label>
                    <input type="text" class="form-control" name="subarea" placeholder="Subárea" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <button type="submit" name="create" value="create" class="btn btn-success btn-lg btn-block">
                        <span>
                          <i class="fas fa-user-plus"></i>
                        </span> Crear</button>
                    </div>
                    <div class="col-md-6">
                      <button type="submit" name="read" value="read" class="btn btn-primary btn-lg btn-block">
                        <span>
                          <i class="fas fa-search"></i>
                        </span> Consultar</button>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-6">
                      <button type="submit" name="update" value="update" class="btn btn-dark btn-lg btn-block">
                        <span>
                          <i class="fas fa-wrench"></i>
                        </span> Actualizar</button>
                    </div>
                    <div class="col-md-6">
                      <button type="submit" name="delete" value="delete" class="btn btn-danger btn-lg btn-block">
                        <span>
                          <i class="fas fa-trash"></i>
                        </span> Eliminar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
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