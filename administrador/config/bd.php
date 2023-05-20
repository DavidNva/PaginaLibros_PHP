<?php
    // para conectar a la base de datos
    $host="localhost";
    $bd="sitio";
    $usuario ="root";
    $contrasenia = "";

    try{
        // PDO CREA UNA CONEXION CON LA base de datos, sin el pdo no vamos a poder conectarnos a la base 
        $conexion = new PDO("mysql:host=$host;dbname=$bd",$usuario, $contrasenia);
        if ($conexion) {/*Si la conexion es correcta */
            // echo "Conectado... a sistema ";
        }
    }catch(Exception $ex){
        // en caso de un error muestra el mensaje que se genero
        echo $ex-> getMessage();
    }  

?>  