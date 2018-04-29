<?php 
  require_once('php/conexion.php');   

  if (!isset($_SESSION)) {
    session_start();
  }

  $loginFormAction = $_SERVER['PHP_SELF'];

  if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
  }

  if (isset($_POST['user'])) {
    $loginUsername = $_POST['user'];
    $password = $_POST['password'];
    $MM_fldUserAuthorization = "";
    $MM_redirectLoginSuccess = "php/inicio/inicio.php";
    $MM_redirectLoginFailed = "index.php";
    $MM_redirecttoReferrer = false;

    mysqli_select_db($conexion_usuarios, $database_conexion_usuarios);
  
    $LoginRS__query=sprintf("SELECT user, password FROM usuarios WHERE user='%s' AND password='%s'", get_magic_quotes_gpc() ? 
      $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
    $LoginRS = mysqli_query($conexion_usuarios, $LoginRS__query) or die(mysqli_error());

    $loginFoundUser = mysqli_num_rows($LoginRS);

    if ($loginFoundUser) {
      $loginStrGroup = "";
      
      //declare two session variables and assign them
      $_SESSION['MM_Username'] = $loginUsername;
      $_SESSION['MM_UserGroup'] = $loginStrGroup;       

      if (isset($_SESSION['PrevUrl']) && false) {

        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];  
      }

      header("Location: " . $MM_redirectLoginSuccess );

      }else{
        header("Location: ". $MM_redirectLoginFailed );
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/img/logo-fav.png">
    <title>Beagle</title>
    <link rel="stylesheet" type="text/css" href="assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="assets/css/app.css" type="text/css"/>
  </head>
  <body class="be-splash-screen">
    <div class="be-wrapper be-login">
      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="splash-container">
            <div class="card card-border-color card-border-color-primary">
              <div class="card-header"><img src="media/images/logo_hemusa.png" alt="logo" width="200" height="90" class="logo-img"><span class="splash-description">Porfavor ingresa tu informacion.</span></div>
              <div class="card-body">
                <form action="<?php echo $loginFormAction; ?>" method="POST">
                  <div class="form-group">
                    <input id="user" type="text" placeholder="Usuario" autocomplete="off" class="form-control">
                  </div>
                  <div class="form-group">
                    <input id="password" type="password" placeholder="Contraseña" class="form-control">
                  </div>
                  <div class="form-group row login-tools">
                    <div class="col-6 login-remember">
                      <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input"><span class="custom-control-label">Recuerdame</span>
                      </label>
                    </div>
                    <div class="col-6 login-forgot-password"><a href="pages-forgot-password.html">Olvidaste tu contraseña?</a></div>
                  </div>
                  <div class="form-group login-submit">
                    <button type="submit" name="Submit" class="btn btn-primary btn-xl">Ingresar</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="splash-footer"><span>No tienes una cuenta aún? <a href="pages-sign-up.html">Registrar</a></span></div>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="assets/js/app.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
      });
      
    </script>
  </body>
</html>

