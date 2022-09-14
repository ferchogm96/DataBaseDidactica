<?php 
require ("config/bd.php");
session_start();

$correo= $_POST['correo'];
$contrasenia= $_POST['contrasenia'];

$q = "SELECT COUNT(*) as contar FROM logins WHERE correo = '$correo' and contrasenia = '$contrasenia' ";
$consulta = mysqli_query($conexion,$q);
$array = mysqli_fetch_array($consulta);

if($array['contar']>0){
    $_SESSION['correo'] = $correo;
    header("location:inicio.php");
}else{
    echo "Error: El usuario o contraseña son incorrectos";
}
//if($_POST){
  //      $sentenciaSQL = $conexion->prepare("SELECT * FROM logins WHERE correo=:correo && contrasenia=:contrasenia");
    //    $sentenciaSQL->bindParam(':correo',$txtCorreo);
      //  $sentenciaSQL->bindParam(':contrasenia',$txtContrasenia);
        //$sentenciaSQL->execute();
        //$usuario=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        //$txtCorreo=$usuario['correo'];
        //$txtContrasenia=$usuario['contrasenia'];
        //if($txtCorreo!=='' && $txtContrasenia!==''){
            //header("Location:inicio.php");
        //}else{
          //  $mensaje = "Error: El usuario o contraseña son incorrectos";
       // }


   // $_SESSION['usuario']="ok";
    //$_SESSION['nombreUsuario']="Develoteca";  
//}
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Administrador</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        </head>
    <body>

      <div class="container">
          <div class="row">
            <div class="col-md-4">
            </div>

              <div class="col-md-4">
                <br> <br>
                  <div class="card">
                      <div class="card-header">
                          Iniciar Sesión
                      </div>
                      <div class="card-body">

                        <?php if(isset($mensaje)){?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje;?>
                        </div>
                        <?php }?>
                      <form method="POST">

                          <div class = "form-group">
                          <label for="exampleInputEmail1">Correo Electrónico</label>
                          <input type="email" class="form-control" name="correo"id="exampleInputEmail1"  placeholder="Enter email">
                          </div>
                          <div class="form-group">
                          <label for="exampleInputPassword1">Contraseña</label>
                          <input type="password" class="form-control" name="contrasenia" placeholder="Password">
                          </div>
                    
                          
                          <button type="submit" class="btn btn-primary">Entrar</button>
                          </form>
                          
                          
                      </div>
                    
                  </div>
              </div>
              
          </div>
      </div>

    </body>
</html>