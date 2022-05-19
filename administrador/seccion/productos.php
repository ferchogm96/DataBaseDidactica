<?php include("../template/cabecera.php") ?>
<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include ("../config/bd.php");


switch($accion){
    case "Agregar":
        
        $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombres,imagenes) VALUES (:nombre, :imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        //por si se quiere meter imagenes, aqui editar 2:14:00
        
        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"archivo.pdf";

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
        
        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../pdfs/".$nombreArchivo);
        }
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();
    break;

    case "Modificar":

        $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombres=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        
        if($txtImagen!=""){

            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"archivo.pdf";    
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen,"../../pdfs/".$nombreArchivo);

            $sentenciaSQL = $conexion->prepare("SELECT imagenes FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if( isset($libro["imagenes"]) &&($libro["imagenes"]!="archivo.pdf") ){
                
                if(file_exists("../../pdfs/".$libro["imagenes"])){
                    
                    unlink("../../pdfs/".$libro["imagenes"]);
                }
            }
            $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagenes=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
        }
    break;

    case "Cancelar":
        echo "Presionado boton Cancelar";
    break;
    case "Selecionar":

        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$libro['nombre'];
        $txtImagen=$libro['imagen'];
        //echo "Presionado boton Seleccionar";
    break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("SELECT imagenes FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        
        if( isset($libro["imagenes"]) &&($libro["imagenes"]!="archivo.pdf") ){
                
            if(file_exists("../../pdfs/".$libro["imagenes"])){
                
                unlink("../../pdfs/".$libro["imagenes"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
    break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Datos del archivo
            </div>
            <div class="card-body">
                
                <form method="POST" enctype="multipart/form-data">

                    <div class = "form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                    </div>

                    <div class = "form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" class="form-control" value="<?php echo $txtImagen; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Libro">
                    </div>

                    <div class = "form-group">
                    <label for="txtImagen">Imagen:</label>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre del Libro">
                    </div>

                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                        <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
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
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($listaLibros as $libro) { ?>
                <tr>
                    <td><?php echo $libro['id']; ?> </td>
                    <td><?php echo $libro['nombres']; ?></td>
                    <td><?php echo $libro['imagenes']; ?></td>
                    <td>
                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?> "/>

                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                    </form>
                    </td>

                </tr>
             <?php }?>
            </tbody>
        </table>
        
    </div>

<?php include("../template/pie.php") ?>