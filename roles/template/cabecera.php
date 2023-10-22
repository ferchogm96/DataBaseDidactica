<?php
session_start();

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Didáctica</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="node_modules/open-iconic/font/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="node_modules/open-iconic/font/css/open-iconic-bootstrap.css">
    
  </head>
<body>

    <?php $url="http://".$_SERVER['HTTP_HOST']."/DataBaseDidactica" ?>

   

  <!-- Inicia barra de navegacion -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
			<div class="container-fluid">
		    	
		    	
        <!--	
        SE HA QUITADO EL BOTON RESPONSIVO PORQUE SE CRUZAN LAS FUNCIONALIDADES Y HACE QUE DEJE DE FUNCIONAR  
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      		<span class="navbar-toggler-icon"></span>
	    		</button>
			  -->
		    	<!--<div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
		    	
		    		<ul class="navbar-nav me-auto">
		    			<li class="nav-item"><a class="nav-link active" href="#">Administrador del sitio <span class="sr-only">(current)</span></a></li>
              
		    			<li class="nav-item"><a class= "nav-link" href="<?php echo $url;?>/login.php">Material</a></li>
              <li class="nav-item"><a class= "nav-link" href="<?php echo $url;?>">Didáctica</a></li>
              <li class="nav-item"><a class= "nav-link" href="<?php echo $url;?>/administrador/seccion/cerrar.php">Cerrar Sesión</a></li>
		      	</ul>
		      <!-- </div> -->

	    </div>
	</nav>
	    <!--Termina barra de navegacion-->


    <div class="container">
    <br/>
        <div class="row">