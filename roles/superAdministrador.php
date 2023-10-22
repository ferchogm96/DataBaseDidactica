<?php include("template/cabecera.php") 
//IMPORTANTE darle persmisos de leer y escribir a la carpeta donde se vayan a guardar los archivos pdfs, del ordenador del servidor a usar.
?>
<?php
//session_start();
if(!isset($_SESSION['rol'])){//validamos que no exista otra sesion abierta para no permitirle acceso
    header('Location:../login.php');
}else{
    if($_SESSION['rol'] != 3){
        header('Location:../login.php'); //en caso de que si exista una que no sea la que queremos, redirige a login
    }
}

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$txtAutor=(isset($_POST['txtAutor']))?$_POST['txtAutor']:"";
$txtAsignatura=(isset($_POST['txtAsignatura']))?$_POST['txtAsignatura']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";


include ("../administrador/config/bd.php");

switch($accion){
    case "Agregar":
        
        $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombres,imagenes,categoria) VALUES (:nombre, :imagen, :categoria);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre); //bindParam vincula la variable al parametro  y en el momento de hacer el execute es cuando se asigna realmente el valor de la variable a ese parámetro
        //por si se quiere meter imagenes, aqui editar 2:14:00
        
        //todo esto es para que se guarde con la fecha del dia + el nombre del archivo.
        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"archivo.pdf";// si el archivo no tiene nombre, se guarda como archivo.pdf.

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
        
        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../pdfs/".$nombreArchivo);//se guarda en la carpeta de pdfs del proyecto, tmpImagen es el nombre que el SO da al archivo, y nosotros lo cambiamos por el original que seria $nombreArchivo
        }
        $sentenciaSQL->bindParam(':imagen', $nombreArchivo);//bindParam vincula la variable al parametro  y en el momento de hacer el execute es cuando se asigna realmente el valor de la variable a ese parámetro
        $sentenciaSQL->bindParam(':categoria', $txtAsignatura);
        $sentenciaSQL->execute();
        header("Location:superAdministrador.php");
    break;

    case "Modificar":
        //con esto se modifica el nombre del material
        $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombres=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);//bindParam vincula la variable al parametro  y en el momento de hacer el execute es cuando se asigna realmente el valor de la variable a ese parámetro
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        
        //aqui se modifica el nombre del archivo, tambien se toma el caso donde no tiene nombre
        if($txtImagen!=""){

            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"archivo.pdf";    
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen,"../pdfs/".$nombreArchivo);

            $sentenciaSQL = $conexion->prepare("SELECT imagenes FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID); //bindParam vincula la variable al parametro  y en el momento de hacer el execute es cuando se asigna realmente el valor de la variable a ese parámetro
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY); //creando los nombres de variable de objeto conforme se accede a los mismos.

            if( isset($libro["imagenes"]) &&($libro["imagenes"]!="archivo.pdf") ){
                
                if(file_exists("../pdfs/".$libro["imagenes"])){
                    
                    unlink("../pdfs/".$libro["imagenes"]);
                }
            }//hasta este punto ya se modifico lo necesario para guardar los archivos en la carpeta pfs y se prepara para modificar en la BD.
            $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagenes=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen',$nombreArchivo); //bindParam vincula la variable al parametro  y en el momento de hacer el execute es cuando se asigna realmente el valor de la variable a ese parámetro
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            
            $sentenciaSQL = $conexion->prepare("UPDATE libros SET categoria=:categoria WHERE id=:id");
            $sentenciaSQL->bindParam(':categoria', $txtAsignatura);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
        }
        header("Location:superAdministrador.php");
    break;

    case "Cancelar":
        header("Location:superAdministrador.php");
    break;

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID); //bindParam vincula la variable al parametro  y en el momento de hacer el execute es cuando se asigna realmente el valor de la variable a ese parámetro
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY); //creando los nombres de variable de objeto conforme se accede a los mismos.

        $txtNombre=$libro['nombres'];
        $txtImagen=$libro['imagenes'];
        $txtAsignatura=$libro['categoria'];

    break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("SELECT imagenes FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID); //bindParam vincula la variable al parametro  y en el momento de hacer el execute es cuando se asigna realmente el valor de la variable a ese parámetro
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY); //creando los nombres de variable de objeto conforme se accede a los mismos.
        
        if( isset($libro["imagenes"]) &&($libro["imagenes"]!="archivo.pdf") ){
                
            if(file_exists("../pdfs/".$libro["imagenes"])){
                
                unlink("../pdfs/".$libro["imagenes"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        header("Location:superAdministrador.php");
    break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$sentenciaSQL = $conexion->prepare("SELECT * FROM categoria");
$sentenciaSQL->execute();
$listaCategorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
    <div class="jumbotron">
        <h1 class="display-3">Bienvenido Super Administrador</h1>
        
    </div>


    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Datos del archivo
            </div>
            <div class="card-body">
                
                <form method="POST" enctype="multipart/form-data">

                    <div class = "form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                    </div>


                    <div class = "form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Archivo">
                    </div>


                    <div class = "form-group">
                    <label for="txtAsignatura" class="form-label">Asignatura:</label><br>
                    <select class="form-select" name="drop-asignatura" id="drop-asignatura">
                    <option value="">Seleccione:</option>
                        <?php
                        #aqui nos conectamos jalamos la tabla categoria de la base de datos.
                        $query = $conexion->prepare("SELECT * FROM categoria");
                        $query->execute();
                        $resultado = $query->fetchAll();
                        #se hace un recorrido de todos los valores de la tabla categoria y se muestra en forma de formulario de opciones.
                        foreach ($resultado as $valores):
                            echo '<option value="'.$valores["id"].'">'.$valores["categoria"].'</option>';
                        endforeach;
                        
                        ?>
                    <!- Se debe quitar el input pero usar el value $txtAsignatura dentro del foreach para que se suba a la base de datos lo seleccionado->
                    <input type="text" required class="form-control" value="<?php echo $txtAsignatura; ?>" name="txtAsignatura" id="txtAsignatura" placeholder="Asignatura">
                    </select> 
                    </div>

                    <div class = "form-group">
                    <label for="txtNombre">Archivo:</label>

                    <?php echo $txtImagen; ?>

                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre del Archivo">
                    </div>

                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"";?> value="Agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"";?> value="Modificar" class="btn btn-warning">Modificar</button>
                        <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"";?> value="Cancelar" class="btn btn-info">Cancelar</button>
                    </div>

                </form>
            </div>
       </div>
    </div>

    <div class="col-md-7">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Archivo</th>
                    <th>Asignatura</th>
                    <th>Acciones</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php foreach($listaLibros as $libro) { ?>
                <tr>
                    <td><?php echo $libro['id']; ?> </td>
                    <td><?php echo $libro['nombres']; ?></td>
                    <td><?php echo $libro['imagenes']; ?></td>
                    <td><?php echo $libro['categoria']; ?></td> <!- Modificar para que no se enliste la asignatura por su ID, sino por su categoria.->
                    <td>
                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?> "/>

                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-secondary"/>

                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>

                        <input type="submit" name="accion" value="Descargar" href="../pdfs/<?php echo $libro['imagenes']; ?>" class="btn btn-primary"/>
                    </form>
                    </td>

                </tr>
            <?php  } ?>
            </tbody>
        </table>
        
    </div>

<?php include("template/pie.php") ?>