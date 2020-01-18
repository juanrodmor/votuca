<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Panel de administración - Desbloquear usuarios</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/admin_css.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/behaviour/footer.css" rel="stylesheet">

  </head>

  <body>
    
  <div id="header">
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand">
            <img id="logo-btn" src="<?php echo base_url('assets/img/logo_menus.png')?>" style="height:5em;" alt="">
          </a>
          <span id="cerrar-ses" class="nav-link" onclick="location='<?= base_url().'login_controller/logout'?>'">Cerrar sesión</span>
      </nav>
      <div class="row is-flex see-overflow fixed" id="title-container"> 
            <div class="col-xs-12 col-sm-8">
              <h2>Administrador</h2>
            </div>
            <hr class="divider">
            <div class="col-xs-12 col-sm-8" id="linkBox">
              <a href="<?= base_url().'administrador_controller/monitoring'?>" class="unmarked">Auditoría</a>
              <a href="<?= base_url().'administrador_controller/gestionusuarios'?>" class="unmarked">Modificar rol</a>
              <a href="#" class="marked">Desbloquear usuarios</a>
            </div>
        </div>
    </div>

        <!----- AQUI ACABA EL ENCABEZADO --->

<div class="container">
    <br>
    <?php

        if(isset($mensajeDesbloqueadoOK))
        {
          echo '<div class="alert alert-success alert-dismissible" role="alert" id="error_alert">'.$mensajeDesbloqueadoOK.'</div>';
        }

        if(!isset($bloqueados) || count($bloqueados) == 0)
        {
            echo '<div class="alert alert-info alert-dismissible" role="alert" id="error_alert">No hay usuarios bloqueados en el sistema. </div>';
        }
        else
        {
            echo
            '   <table id="resultTable">
                <tr id="trHeader">
                    <th id="thHeaderOption">Usuario</th>
                    <th id="thHeaderOption">Desbloquear</th>
                </tr>
            ';
            foreach($bloqueados as $bloqueado)
            {
                  echo '<tr id="trBody">
                          
                            
                            <th id="thBodyOption">'.$bloqueado.'</th>
                            <th id="thBodyOption">
                            <div>
                              <form id="unBlockForm" action="' . base_url().'administrador_controller/desbloquearUsuario' . '" method="post">
                              <input type=hidden name="usuario" value="'.$bloqueado.'">
                              <input type="checkbox" name="checkBoxInput" style="margin: -2%;" value="'.$bloqueado.'">
                              </form>
                            </div>
                            
                            </th>
                        </tr>
                  ';
            }
            echo
            '
                </table>
            ';
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
        $("#unBlockForm").on("change", "input:checkbox", function()
        {
          $("#unBlockForm").submit();
        });
      });

    </script>

  </body>


</html>
