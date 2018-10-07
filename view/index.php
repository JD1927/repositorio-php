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
include("../control/ctrUser.php");
include("../model/UserModel.php");
$name = "";
$password = "";

try {
  //Valida que el botón contenga el valor necesario para validar usuario y contraseña
  if ($_POST["sign-in"] == "sign-in") {
    //Recibe los valores del HTTP Post
    $password = $_POST["password"];
    $name = $_POST["user"];

    //Envía usuario y contraseña al modelo de usuario
    $objUserModel = new UserModel($name, $password);
    $ctrUser = new ctrUser($objUserModel);

    //Validar usuario
    $ctrUser->validate_user();

    //Obtiene los valores de los campos
    $NOMBRE = $objUserModel->getName();
    $IDUSUARIO = $objUserModel->getPassword();
    $ROL = $objUserModel->getRol();
    //Valida que los valores coincidad exactamente para ingresar
    $name === $NOMBRE ? $name = $NOMBRE : $name = null;
    $password === $IDUSUARIO ? $password = $IDUSUARIO : $password = null;

    //Valida si el usuario y la contraseñas son diferentes de nulo y vacío
    if ((isset($name) && (!empty($name))) && 
    ((!empty($password)) && (isset($password)))) {

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
</head>

<body class="text-center">
  <form class="form-signin" method="POST" action="index.php">
    <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>
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
        <input type="text" class="form-control" id="pwd" name="password" placeholder="Contraseña" autocomplete="off">
      </div>
    </div>
    <button class="btn btn-lg btn-success btn-block" name="sign-in" type="submit" value="sign-in">Ingresar</button>
  </form>
</body>

</html>