<?php
error_reporting(0);
include("../model/AreaModel.php");
include("../control/CtrArea.php");
include("../control/CtrConnection.php");
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
    $longitud = count($mat);
  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }

}
  //select
if ($_POST["read"] == "read") {

  try {
    //setting values
    $cod = $_POST["cod"];
    $objArea = new AreaModel($cod, $name, $subarea);
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
      echo "<center> <h1>NO SE HA ENCONTRADO EL name INGRESADO</h1></center>";
    }
  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }

}
  //delete
if ($_POST["delete"] == "delete") {

  try {
    $objArea = new AreaModel($cod, $name, $subarea);
    $objCtrArea = new CtrArea($objArea);


    if (!$objCtrArea->delete()) {
      echo "<center> <h1>SE HA BORRADO CON EXITO DE LA BASE DE DATOS</h1></center>";
    } else {
      echo "<center> <h1>NO SE HA ENCONTRADO NADA CON ESTE name</h1></center>";
    }
  } catch (Exception $exp) {
    echo "ERROR ....R " . $exp->getMessage() . "\n";
  }

}

echo "<!doctype html>
<html lang=\"en\">

<head>
  <meta charset=\"utf-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
  <meta name=\"description\" content=\"\">
  <meta name=\"author\" content=\"\">
  <link rel=\"icon\" href=\"../../../../favicon.ico\">

  <title>User</title>

  <!-- Bootstrap core CSS -->
  <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css\" integrity=\"sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO\"
    crossorigin=\"anonymous\">
  <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.2.0/css/all.css\" integrity=\"sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ\"
    crossorigin=\"anonymous\">
  <!-- Custom styles for this template -->
  <link href=\"styles.css\" rel=\"stylesheet\">
</head>

<body>
  

  <div class=\"container-fluid\">
    <div class=\"row\">
      <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
        <!--Form Clients-->
        <a href=\"area.html\" class=\"badge badge-primary\">
          <span>
            <i class=\"fas fa-chevron-circle-left\"></i>
          </span> Go home</a>
        <br>
        <br>
        <div class=\"card\">
          <h1 class=\"card-header\" style=\"text-align: center;\">User</h1>
          <div class=\"card-body\">
            <form method=\"POST\" action=\"Area.php\">
              <div class=\"form\">
                <div class=\"form-group\">
                    <label for=\"lname\">Código Área</label>
                    <input type=\"text\" class=\"form-control\" name=\"cod\" placeholder=\"cod\" autocomplete=\"off\" >
                </div>
                <div class=\"form-group\">
                  <label for=\"lname\">name</label>
                  <input type=\"text\" class=\"form-control\" name=\"name\" placeholder=\"name\" autocomplete=\"off\">
                </div>
                <div class=\"form-group\">
                    <label for=\"tele\">Subárea</label>
                    <input type=\"text\" class=\"form-control\" name=\"subarea\" placeholder=\"subarea\" autocomplete=\"off\">
                </div>
              </div>
              <div class=\"form-group\">
                <div class=\"row\">
                  <div class=\"col-md-6\">
                    <button type=\"submit\" name=\"create\" value=\"create\" class=\"btn btn-success btn-lg btn-block\">
                      <span>
                        <i class=\"fas fa-user-plus\"></i>
                      </span> create</button>
                  </div>
                  <div class=\"col-md-6\">
                    <button type=\"submit\" name=\"read\" value=\"read\" class=\"btn btn-primary btn-lg btn-block\">
                      <span>
                        <i class=\"fas fa-search\"></i>
                      </span> read</button>
                  </div>
                </div>
                <br>
                <div class=\"row\">
                  <div class=\"col-md-6\">
                    <button type=\"submit\" name=\"update\" value=\"update\" class=\"btn btn-dark btn-lg btn-block\">
                      <span>
                        <i class=\"fas fa-wrench\"></i>
                      </span> update</button>
                  </div>
                  <div class=\"col-md-6\">
                    <button type=\"submit\" name=\"delete\" value=\"delete\" class=\"btn btn-danger btn-lg btn-block\">
                      <span>
                        <i class=\"fas fa-trash\"></i>
                      </span> delete</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!--end Form Clients-->";
        // $mat = $objCtrArea->area_list();
for ($i = 1; $i <= $longitud; $i++) {
  echo " <div class=\"table-responsive\">
          <table class=\"table table-striped table-sm\">
              <thead>
                  <tr>
                      <th>Código Área</th>
                      <th>name</th>
                      <th>Subárea</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>" . $mat[$i][1] . "</td>
                      <td> " . $mat[$i][2] . "</td>
                      <td>" . $mat[$i][3] . "</td>
                  </tr>
              </tbody>  
          </table>
      </div>";
}
echo "
      </main>
    </div>
  </div>
  <!-- Bootstrap core JS -->
  <script src=\"https://code.jquery.com/jquery-3.3.1.slim.min.js\" integrity=\"sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo\"
    crossorigin=\"anonymous\"></script>
  <script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js\" integrity=\"sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49\"
    crossorigin=\"anonymous\"></script>
  <script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js\" integrity=\"sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy\"
    crossorigin=\"anonymous\"></script>
</body>

</html>";
display_errors(0);
?>

