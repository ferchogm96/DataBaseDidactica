<?php
$host="localhost";
$bd="sitio";
$usuario="root";
$contrasenia="pwdpwd";

//$conexion = mysqli_connect($host,$usuario,$contrasenia,$bd);
//if($conexion){
  //  echo "conectado correctamente";
//}else{
  //  echo "error de conexión";
//}


#try{
    $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia );
    if($conexion){ echo "Conectado... a sistema";}
    else{ echo "error de conexion";}


#}catch( Exception $ex){
 #   echo $ex->getMessage();
#}
?>