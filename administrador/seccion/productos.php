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
            $sentenciaSQL ->bindParam(':nombre',$txtNombre);
            $sentenciaSQL ->bindParam(':imagen',$txtImagen);
            $sentenciaSQL->execute();/*Ejecutamos este sentencia*/
            
            // echo "Presionando botón de agregar"; fue para verificar que si se estaba haciendo caso al pulsar en el boton de agregar
            break; 
        case "Modificar":
            //UPDATE `libros` SET `imagen` = 'imagen.jpg' WHERE `libros`.`id` = 1;
            // echo "Presionando botón de modificar";
            break;
        case "Cancelar":
            echo "Presionando botón de cancelar";
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
                    <input type="text" class="form-control" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class = "form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre del libro">
                </div>
                
                <div class = "form-group">
                    <label for="txtImagen">Imagen:</label>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen del libro">
                </div>

                <!--Usamos bt-bgrpup-default que coloca varios botones, para las acciones a realizar-->
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar"  class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar"  class="btn btn-info">Cancelar</button>
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
                <td><?php echo $libro['imagen']; ?></td>
                <td>Seleccionar | Borrar </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php include("../template/pie.php"); ?> <!-- Hace referencia al pie de cabecera de administrador -->
