<?php
//Para evitar la muestra de errores
error_reporting(0);
//Inicia la sesión del usuario
session_start();
//Valida si existe un usuario en sesión lo manda al home.
if ($_SESSION["name"]) {
  header('Location: HomeView.php');
}
//Importa el control y el modelo de usuarios
include("../control/CtrUser.php");
include("../model/UserModel.php");
include("../control/CtrConnection.php");

$name = "";
$password = "";

try {
  //Valida que el botón contenga el valor necesario para validar usuario y contraseña
  if ($_POST["sign-in"] == "sign-in") {
    //Recibe los valores del HTTP Post
    $password = $_POST["password"];
    $name = $_POST["user"];

    //Envía usuario y contraseña al modelo de usuario
    $objUserModel = new UserModel($name, $password, null);
    $CtrUser = new CtrUser($objUserModel);

    //Validar usuario
    $CtrUser->validate_user();

    //Obtiene los valores de los campos
    $NOMBRE = $objUserModel->getName();
    $IDUSUARIO = $objUserModel->getPassword();
    $ROL = $objUserModel->getRol();
    //Valida que los valores coincidad exactamente para ingresar
    $name === $NOMBRE ? $name = $NOMBRE : $name = null;
    $password === $IDUSUARIO ? $password = $IDUSUARIO : $password = null;

    //Valida si el usuario y la contraseñas son diferentes de nulo y vacío
    if ((isset($name) && (!empty($name))) && ((!empty($password)) && (isset($password)))) {

      //Agrega al array de sesión el usuario y la contraseña
      $_SESSION["name"] = $name;
      $_SESSION["pass"] = $password;
      $_SESSION["rol"] = $ROL;
      //Envía al usuario a home de la aplicación
      header('Location: HomeView.php');
    } else {
      //Muestra un mensaje de error en caso que no cumpla las condiciones anteriores
      echo "<center> <h1>DATOS INVALIDOS.</h1><br><br></center>";
    }
  }
} catch (Exception $exp) {
  echo "ERROR ....R " . $exp->getMessage() . "\n";
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <title>Login</title>

  <!-- Custom styles for this template -->
  <link href="../styles/sign-in.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      width: 100%;
      padding: inherit;
    }

    .bg {
        /* The image used */
        background-image: url("../images/sign-in.jpg");

        /* Full height */
        height: 100%; 
        width: 100%;
        /* Center and scale the image nicely */
        background-position: auto;
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }
    .title {
      color: #F8F8F8;
      background-color: #A29CAD;
      border-radius: 10px;
    }
  </style>
</head>

<body class="text-center">
  <div class="bg">
  <form class="form-signin" style="margin-top:10%" method="POST" action="index.php">
    <h1 class="h3 mb-3 font-weight-normal title">¡Bienvenido!</h1>
    <div class="form-group">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text"><span><i class="fas fa-user"></i></span></div>
        </div>
        <input type="text" class="form-control" id="user" name="user" placeholder="Usuario" autocomplete="off">
      </div>
    </div>
    <div class="form-group">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text"><span><i class="fas fa-fingerprint"></i></span></div>
        </div>
        <input type="password" class="form-control" id="pwd" name="password" placeholder="Contraseña" autocomplete="off">
      </div>
    </div>
    <button class="btn btn-lg btn-dark btn-block" style="border-radius: 25px;" name="sign-in" type="submit" value="sign-in">Ingresar</button>
  </form>
  <footer style="color:white;"><!--Estudiantes-->
    &copy; Estudiantes<br> 
    Ana María Jaramillo Valiente <br> 
    Kevin Hernandez <br> 
    Juan David Martínez Martínez <br>
    Juan David Aguirre Córdoba
  </footer>
</div>

</body>

</html>