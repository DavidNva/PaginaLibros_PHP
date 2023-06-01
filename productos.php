<?php include("template/cabecera.php");?> <!--Jala o incluye el diseño de cabecera principal-->
<!--Lo unico que cambia es el contenedor
El total de col-md- es 12--> 
<?php 
    include("administrador/config/bd.php"); /*Inclute la base de datos */
    $sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();/*Ejecutamos este sentencia*/
    $listaLibros = $sentenciaSQL -> fetchAll(PDO::FETCH_ASSOC);/*Cuando la ejecutemos, con la estruccion o metodo
    fetchAll lo que hace es recuperar todos los registros para mostrar en esa variable $listaLibros*/

?>

<?php foreach($listaLibros as $libro){?>
    <div class="col-md-3">
        <div class="card">
            <img class="card-img-top" src="./img/<?php echo $libro['imagen'];  ?>" alt="">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $libro['nombre'];  ?></h4>
                    <a name="" id="" class="btn btn-primary" href="https://goalkicker.com/" target="_blank" role="button">Ver más</a>
                </div>
        </div> 
    </div>            

<?php } ?>
<!-- 
<?php include("template/pie.php");?>Jala el diseño de pie de pagina -->
