<?php



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
?>

