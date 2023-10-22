<?php


  $host="localhost"; //o poner direccion ip del servidor donde se encuentre la DB con phpMyAdmin
  $db="sitio";
  $user="root";
  $password="pwdpwd";
 
  try{
      //usamos la forma de conexion de PhpDataObjects(PDO)
      $dsn = "mysql:host=$host;dbname=$db"; // Data Source Name 
      $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                  PDO::ATTR_EMULATE_PREPARES => false];
      $conexion = new PDO($dsn, $user, $password); //Data Base Handle

      
 
  }catch(PDOException $e){
    print_r("Error de conexión: " . $e->getMessage());
  }
  
/*
class Database{

  private $host;
  private $db;
  private $user;
  private $password;
  private $charset;

  public function __construct(){
    $this ->host   ='localhost';
    $this ->db     ='sitio';
    $this ->user   ='root';
    $this ->password='pwdpwd';
    $this ->charset ='utf8mb4';
  }



  //funcion para conectar a la base de datos
  public function connect(){
    try{
      //usamos la forma de conexion de PhpDataObjects(PDO)
      $conexion = "mysql:host=" . $this->host . ";dbname" . $this->db . ";charset=" . $this->charset;
      $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                  PDO::ATTR_EMULATE_PREPARES => false];
      $pdo = new PDO($conexion, $this->user, $this->password, $options);

    }catch(PDOException $e){
      print_r("Error de conexión: " . $e->getMessage());
    }
  }

}  */
?>

