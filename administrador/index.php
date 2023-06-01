<?php
session_start();
if($_POST){ #Si hay un envio tipo post, al dar clic en el boton
    if(($_POST['usuario']=="david") && ($_POST['contrasenia']=="sistema")){/*Si existe el user u contraseña */
        
        $_SESSION['usuario']="ok"; /*Porque en cabecera al confirmar, debe llevar la variable session un "ok" */
        $_SESSION['nombreUsuario']="David";
        header('Location:inicio.php'); /*Hace la redireccion a esta pagina de inicio.php */
    }else{
        $mensaje="Error: El usuario o contraseña son incorrectos";
    }

}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-4"> <!--Para mandar en div de login-->
                
            </div>

            <div class="col-md-4"> <!--medida del contenedor del div-->
                <br/> <br/> <br/> <br/> <br/><br/> <!--Para centrar el login en medio verticalmente-->
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <?php if(isset($mensaje)){?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php } ?>
                        
                        <!-- !crt-form-login, escribiendo esto se aplica el codigo de diseño de login -->
                        <form method="POST"> <!--El tipo Envio de datos-->
                            <div class = "form-group">
                                <label>Usuario</label>
                                <!-- la propiedad name sirve para obtener informacion de la interfaz grafica y poder mostrarla -->
                                <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">
                            
                            </div>

                            <div class="form-group">
                                <label >Contraseña</label>
                                <input type="password" class="form-control" name="contrasenia" placeholder="Escribe tu contraseña">
                            </div>

                            <button type="submit" class="btn btn-primary">Entrar al administrador</button>
                        </form>
                        
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
  </body>
</html>