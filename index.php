<?php
session_start();

  if($_POST){

    $mensaje='Usuario o Contraseña incorrectos';

    if($_POST['usuario']=='Leonardo' && $_POST['password']=='admin'){
      $_SESSION['usuario']=$_POST['usuario'];
      header('Location: secciones/index.php');
    }
  }

?>
<!doctype html>
<html lang="en">
  <head>
    <title>LOGIN</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"  integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

  </head>
  <body>

    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <br><br><br><br><br>
                <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        <b><center>Inicio Sesion</center></b>
                    </div>
                    <div class="card-body">
                    <?php if(isset($mensaje)){?>

                      <div class="alert alert-danger" role="alert">
                        <strong> <?php echo $mensaje; ?> </strong>
                      </div>
                      <?php } ?>
                      
                        <div class="mb-3">
                          <label for="" class="form-label">Usuario</label>
                          <input type="text"
                            class="form-control" required name="usuario" id="usuario" aria-describedby="helpId" placeholder="Escriba su Usuario">
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Contraseña</label>
                          <input type="password"
                            class="form-control" required name="password" id="contraseña" aria-describedby="helpId" placeholder="Escriba su Contraseña">
                        </div>

                        <center><button type="submit" class="btn btn-success">Ingresar</button></center>

                    </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    
  </body>
</html>