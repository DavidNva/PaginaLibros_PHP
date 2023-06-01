<?php include("template/cabecera.php"); ?>

            <div class="col-md-12"> 
                <!-- la pantalla - el div se divide en 12-->
                <!-- usamos b4-jumbotron-default para este diseño -->
                <div class="jumbotron">
                    <h1 class="display-3">Bienvenido <?php echo $nombreUsuario;?></h1>
                    <p class="lead">Vamos a administrar nuestros libros en el sitio web</p>
                    <hr class="my-2">
                    <p>Mas información</p>
                    <p class="lead"></p>
                    <a class="btn btn-primary btn-lg" href="seccion/productos.php" role="button">Administrar Libros</a>
                </div>
            </div>
<?php include("template/pie.php"); ?>