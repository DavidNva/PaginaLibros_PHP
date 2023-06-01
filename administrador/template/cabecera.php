<?php
session_start();
  if(!isset($_SESSION['usuario'])){ /*Session es una variable no creada hasta ahorita, si tiene informacion */
    header("Location:../index.php"); /*Redirige al index si no hay usuario logeado */
  }else{

    if($_SESSION['usuario']=="ok"){
      $nombreUsuario=$_SESSION["nombreUsuario"]; /*Hasta el momento no existen las variables nombre de usuario ni usuario */
    }
  }
  

?>


<!-- Usamos el b4-$ par aque ya venga incluido boostrap y eliminamos la parte de javascript -->
<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href=".../css/bootsrap.min.css">
  </head>
  <body>
    <!--El $ declara una variable
    El punto (.) sirve para separar textos como concatenacion-->
    <?php $url = "http://".$_SERVER['HTTP_HOST']."/sitioweb"?> <!-- Para redireccion, para poner la redireccion
  Creacion de redireccion a:  "http://".$_SERVER['HTTP_HOST']."/sitioweb"
 el .$_SERVER es el servidor, en este caso local host, tiene un dato HTTP_HOST, QUE DEVUELVE LA URL
AL FINAL se incluye sitio web, que es donde se encuentra este proyecto-->

    <nav class="navbar navbar-expand navbar-light bg-light">
      <!-- b4-navbar-minimal-a, para crea la navegacion -->
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="#">Administrador del Sitio Web <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="<?php echo $url."/administrador/inicio.php"?>">Inicio</a>
            <a class="nav-item nav-link" href="<?php echo $url."/administrador/seccion/productos.php"?>">Administrador de Libros</a>
            <a class="nav-item nav-link" href="<?php echo $url."/administrador/seccion/cerrar.php"?>">Cerrar Sesión</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>">Ver sitio web</a> 
            <!-- el link de referencia se forma con la concatenacin de url creada en las lineas anteriores, 
            con la respectiva carpeta y pagina a acceder (inicio, cerrar sesion, libros, etc. ) -->
        </div>
    </nav>
<!-- usamos para crear el contaniner b4-grid-default -->
    <div class="container">
        <br/> <!--bajar un espacio-->
        <div class="row">