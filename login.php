<?php include("template/cabecera.php"); ?>
<?php
include("administrador/config/bd.php");
session_start();

//creamos una serie de roles para cada tipo de usuario que puede iniciar sesion, cambian sus privilegios.
if(isset($_SESSION['rol'])){
    switch($_SESSION['rol']){
        case 1:
            header('Location: roles/colaborador.php');
        break;
        case 2:
            header('Location: roles/coordinador.php');
        break;
        case 3:
            header('Location: roles/superAdministrador.php');
        break;

        default;
    }
}

//validamos si existe un correo y un password
if(isset($_POST['correo']) && isset($_POST['contrasenia'])){
    $correo = $_POST['correo'];//creamos variable
    $contrasenia = $_POST['contrasenia'];//creamos variable
    
    //se crea un objeto db
    $query = $conexion->prepare('SELECT * FROM usuarios WHERE correo=:correo AND contrasenia=:contrasenia');//con esto conectamos y preparamos la sentencia
    $query->execute(['correo' => $correo, 'contrasenia' => $contrasenia]);//por ultimo ejecutamos usando un arreglo para los valores.

    $row = $query ->fetch(PDO::FETCH_NUM);//lo transformamos en un arreglo lo de la sentencia anterior.
    //validamos si existe contenido en el rol.
    if($row == true){
        //validar rol
        $rol = $row[3]; //ponemos 3 porque en nuestra BD nuestra 3er columna es la de roles
        $_SESSION['rol'] = $rol;
        switch($_SESSION['rol']){
            case 1:
                header('Location: roles/colaborador.php');
            break;
            case 2:
                header('Location: roles/coordinador.php');
            break;
            case 3:
                header('Location: roles/superAdministrador.php');
            break;
    
            default;
        }
    }else{
        //no existe el usuario
        echo 'El usuario o contraseña son incorrectos';
    }
}
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

<?php include("template/pie.php"); ?>