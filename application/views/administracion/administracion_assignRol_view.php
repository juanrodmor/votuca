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

<div id="header">
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand">
            <img id="logo-btn" src="<?php echo base_url('assets/img/logo_menus.png')?>" style="height:5em;" alt="">
          </a>
          <span id="cerrar-ses" class="nav-link" href="<?= base_url().'login_controller/logout'?>">Cerrar sesión</span>
      </nav>
      <div class="row is-flex see-overflow fixed" id="title-container"> 
            <div class="col-xs-12 col-sm-8">
              <h2>Administrador</h2>
            </div>
            <hr class="divider">
            <div class="col-xs-12 col-sm-8" id="linkBox">
              <a href="#" class="unmarked">Auditoría</a>
              <a href="<?= base_url().'administrador_controller/gestionusuarios'?>" class="marked">Modificar rol</a>
            </div>
        </div>
    </div>

        <!----- AQUI ACABA EL ENCABEZADO --->

    <div class="container">
        <?php
        
        if(isset($Id_Votacion))
        {
            echo '
            <div class="card" id="card-options">
                <ul class="list-group list-group-flush">';
                    $cont = 0;
                    foreach($Id_Votacion as $votation)
                    {
                        echo'
                        <li id="single-option" class="list-group-item"> 
                            <form action="asignaVotaciones" method="post">
                                <div id="data-option">
                                    <h4 style="color:black; font-weight: bold;">'.$Titulo[$cont].'</h4>
                                    <p style="margin: 0;">Fecha de inicio:</p>
                                    <p style="margin: 0;">Fecha de fin:</p>
                                    <input type="hidden" id="votacionId" name="votacionId" value="'.$votation.'">
                                    <input type="hidden" name="userId" value="'.$Id_Usuario.'">
                                </div>
                                <div>
                                    <input type="submit" class="btn-custom-for-options" name="Asignar" value="Asignar">
                                </div>
                            </form>
                        </li>
                        ';
                        $cont = $cont + 1;
                    }
            echo'
                </ul>
            </div>
            ';

        }else
        {
            echo '<p>No hay votaciones disponibles</p>';
        }
        ?>
    </div>


 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>


</html>
