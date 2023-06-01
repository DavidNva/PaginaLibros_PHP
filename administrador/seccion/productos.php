<?php include("../template/cabecera.php"); ?> <!-- Hace referencia a la cabecera de administrador -->

<?php
// print_r($_POST);
// print_r($_FILES);
// si hay datos (con isset EN EL txt, entonces txtID = a lo que el valor se haya escrito, y si no, el valor es "" (vacio)
// usando el ?  y los dos :)
    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtNombre = (isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
    $txtImagen = (isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
    // si existe el archivo tomamos el name e imagen y si no seria vacio
    $accion = (isset($_POST['accion']))?$_POST['accion']:"";
    // si hay un accion la enviamos

    include("../config/bd.php"); /*Conexiona  la base de datos */

    switch($accion) {   // dependiendo de que accion, será el procedimiento, como en C#
        case "Agregar":
            //INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'Libro de php', 'imagen3.jpg');
            //prueba de insercion con la conexion a php
            /*Con los dos puntos indicamos los parametros a usar */
            $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombre, imagen) VALUES (:nombre, :imagen);");
           

            //------------------------------------------------------------------------
            /*Para que al guardar los nombres de imagen no se repitan, hacemos una concatenacion de fecha y el nombre del archivo
            primero comprobamos que exista una imagen al registrar, si es asi procede a colocar el nombreArchivo y si no, le da una imagen.jpg
            solo como nombre*/
            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
            
            if($tmpImagen!=""){ /*Si hay imagen,mueve el archivo de imagen a la siguiente carpeta*/
                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
            }
            //----------------------------------------------------------------------------
            $sentenciaSQL ->bindParam(':nombre',$txtNombre);
            $sentenciaSQL ->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->execute();/*Ejecutamos este sentencia*/
            
            header(("Location:productos.php"));//Redireccion a productos
            // echo "Presionando botón de agregar"; fue para verificar que si se estaba haciendo caso al pulsar en el boton de agregar
            break; 
        case "Modificar":
            
            $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
            $sentenciaSQL ->bindParam(':nombre',$txtNombre);
            $sentenciaSQL ->bindParam(':id',$txtID);
            $sentenciaSQL->execute();/*Ejecutamos este sentencia*/
            //UPDATE `libros` SET `imagen` = 'imagen.jpg' WHERE `libros`.`id` = 1;
            // echo "Presionando botón de modificar";

            //Para actualizar la imagen
            if ($txtImagen!="") { /*sI HAY IMAGEN, hace esto igual */
                $fecha = new DateTime();
                $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
                $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                /*Se copia el archivo a esta carpeta */
                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

                //Borrar imagen(si ya no se va a usar y se va a actualizar por otra)
                //Borra la imagen antigua
                $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                $sentenciaSQL ->bindParam(':id',$txtID); /*Paso de parametros, el $txtID se pasa por el method POST  */
                $sentenciaSQL->execute();
                $libro = $sentenciaSQL -> fetch(PDO::FETCH_LAZY);

                if(isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg")){ /*Si existe la imagen */
                    if(file_exists("../../img/".$libro["imagen"])){/*Busca la imagen y si existe pues la borramos */
                        unlink("../../img/".$libro["imagen"]);/*Si existe la elimina */
                    }
                }

                $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL ->bindParam(':imagen',$nombreArchivo);
                $sentenciaSQL ->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                header(("Location:productos.php"));//Redireccion a productos
            }
            header(("Location:productos.php"));//Redireccion a productos
            break;
        case "Cancelar":
            // echo "Presionando botón de cancelar";
            //Redireccion
            header(("Location:productos.php"));
            break;
        case "Seleccionar":
            $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
            $sentenciaSQL ->bindParam(':id',$txtID); /*Paso de parametros, el $txtID se pasa por el method POST  */
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL -> fetch(PDO::FETCH_LAZY);
            $txtNombre=$libro['nombre'];
            $txtImagen=$libro['imagen']; /*Asigna los valores que se recueraron de la bd */
             // echo "Presionando botón de seleccionar";

            break;
        case "Borrar":
            //Borrar imagen
            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL ->bindParam(':id',$txtID); /*Paso de parametros, el $txtID se pasa por el method POST  */
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL -> fetch(PDO::FETCH_LAZY);

            if(isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg")){ /*Si existe la imagen */
                if(file_exists("../../img/".$libro["imagen"])){/*Busca la imagen y si existe pues la borramos */
                    unlink("../../img/".$libro["imagen"]);/*Si existe la elimina */
                }
            }

            //Borra registro
            $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL ->bindParam(':id',$txtID); /*Paso de parametros, el $txtID se pasa por el method POST  */
            $sentenciaSQL->execute();
            //echo "Presionando botón de borrar";
            header(("Location:productos.php"));//Redireccion a productos
            break;
    }
    $sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();/*Ejecutamos este sentencia*/
    $listaLibros = $sentenciaSQL -> fetchAll(PDO::FETCH_ASSOC);/*Cuando la ejecutemos, con la estruccion o metodo
    fetchAll lo que hace es recuperar todos los registros para mostrar en esa variable $listaLibros*/




?>


<div class="col-md-5"> <!--De la pantalla que equivale a 12 tomamors 5-->
    <div class="card">
        <!--Usamo b4-card-head-foot, solo usamos el header y body creados-->
        <div class="card-header">
            Datos de Libro
        </div>
        <!--Formulario de libros-->
        <div class="card-body"><!--Dentro del body colocamos el formulario-->
            <!--Creamos el form con !crt-form-login-->
            <form method="POST" enctype="multipart/form-data"><!--Para recepcionar todo tipo de archivos-->
                <div class = "form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID;?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class = "form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre;?>" name="txtNombre" id="txtNombre" placeholder="Nombre del libro">
                </div>
                
                <div class = "form-group">
                    <label for="txtImagen">Imagen:</label>
                    <!-- <?php echo $txtImagen;?>  -->
                    <br>
                    <?php //<!--para ver imagen si se da en seleccionar-->
                        if($txtImagen!=""){ ?><!--Si hay imagen -->
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen ?> " width="100" alt=""> 
                    <?php   }?>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen del libro">
                </div>

                <!--Usamos bt-bgrpup-default que coloca varios botones, para las acciones a realizar-->
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo($accion =="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo($accion !="Seleccionar")?"disabled":""; ?> value="Modificar"  class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo($accion !="Seleccionar")?"disabled":""; ?> value="Cancelar"  class="btn btn-info">Cancelar</button>
                </div>
            </form>
        
        </div>
    </div>
</div>
<!--Tabla de libros-->
<div class="col-md-7"> <!--De la pantalla que equivale a 12 tomamos los 7 restantes-->
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
            <?php
            foreach($listaLibros as $libro){ ?>
            <tr>
                <td> <?php echo $libro['id']; ?></td> <!--Los datos tienen que coincidir con la base de datos,la tabla de bd -->
                <td><?php echo $libro['nombre']; ?></td> <!--Mismos nombre de las columnas de la bd de la tabla libros -->
                <td>
                   <img class="img-thumbnail rounded"  src="../../img/<?php echo $libro['imagen']; ?> " width="100" alt=""> 
                    
                    <!-- <?php echo $libro['imagen']; ?> -->
                </td>
                <td>
                    <!-- Seleccionar | Borrar  -->
                    <form method="POST">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                        <!--El name debe ser identico (accion) Para el boton de borrar-->
                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php include("../template/pie.php"); ?> <!-- Hace referencia al pie de cabecera de administrador -->
