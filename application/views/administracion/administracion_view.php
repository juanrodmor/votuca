<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Panel de administración - Gestionar roles</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/admin_css.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/behaviour/footer.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">

      <form action="<?= base_url().'administrador_controller/buscador'?>" method="post" id="search_form">
        <div id="user_searcher">
          <input type="text" name="usuario" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Ejemplo: u12345678">
          <small id="passwordHelpBlock" class="form-text text-muted">
          Realice la búsqueda del usuario que desee gestionar sus roles.
          </small>
        </div>
        <input type="submit" name="Buscar" for="search_form" value="Buscar" class="btn btn-primary" id="button-search">
      </form>

      <br>
       <?php
        if(isset($mensaje))
        {
          echo '<div class="alert alert-danger alert-dismissible" role="alert" id="error_alert">' . $mensaje . '</div>';
        }
        else
        {

          if(isset($mensaje_success))
          {
            echo '<div class="alert alert-success" role="alert" id="error_alert">' . $mensaje_success . '</div>';
          }
          else
          {
            if(isset($mensaje_failure))
            {
              echo '<div class="alert alert-danger" role="alert" id="error_alert">' . $mensaje_failure . '</div>'; 
            }
          }

          if(isset($usuario) and isset($rol))
          {
            echo
            /**'<input type="submit" form="role_updating" name="Actualizar roles" value="Actualizar roles" class="btn btn-primary" id="button_update">

            <div class="alert alert-warning alert-dismissible" role="alert" id="error_alert">No olvides actualizar los cambios pulsando el botón <strong>Actualizar roles</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>**/
            '<div class="card" id="search_results">
              <div class="card-body">

                <table class="table">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Nombre de usuario</th>
                      <th scope="col">Permisos</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><input type="text" id="inputUser" readonly class="form-control-plaintext" value="' . $usuario . '"></td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Modificar roles
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="roles_dropdown">
                            <form action="' . base_url().'administrador_controller/nuevoRol' . '" id="role_updating" method="post">
                            <input type="text" name="usuario" value="'. $usuario .'" hidden>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="checkbox" name="checkBoxInput" value="Elector"'; if($rol == "Elector"){echo 'checked disabled';} echo'>
                              <label class="form-check-label" for="checkLogin">Elector</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="checkbox" name="checkBoxInput" value="Secretario"';if($rol == "Secretario"){echo 'checked disabled';} echo'>
                              <label class="form-check-label" for="">Secretario</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="checkbox" name="checkBoxInput" value="Secretario delegado"';if($rol == "Secretario delegado"){echo 'checked disabled';}echo'>
                              <label class="form-check-label" for="">Secretario delegado</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="checkbox" name="checkBoxInput" value="Administrador"';if($rol == "Administrador"){echo 'checked disabled';}echo'>
                              <label class="form-check-label" for="">Administrador</label>
                            </div>
                            </form>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

              </div>
            </div>';
          }
        }
      ?>

    </div>


 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
      $(document).ready(function(){
        $("#role_updating").on("change", "input:checkbox", function()
        {
          $("#role_updating").submit();
        });
      });

    </script>


  </body>


</html>
