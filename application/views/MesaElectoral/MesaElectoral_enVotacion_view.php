<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mesa Electoral</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/MesaElectoral.css" rel="stylesheet">
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
              <h2>Miembro de Mesa Electoral</h2>
            </div>
            <hr class="divider">
            <div class="col-xs-12 col-sm-8" id="linkBox">
              <a href="<?php echo base_url() . 'MesaElectoral';?>" class="marked">Votaciones</a>
            </div>
    </div>
 </div>

        <!----- AQUI ACABA EL ENCABEZADO --->


<div class="container">
 
    <?php
        if(isset($votaciones) && count($votaciones) == 0)
        {
          echo '<div class="alert alert-danger alert-dismissible" role="alert" id="error_alert">Usted no tiene votaciones asignadas.</div>';
        }  
        else
        {
          /** 
          if(isset($mensajeAperturaWait))
                {
                  echo '<div class="alert alert-danger alert-dismissible" role="alert" id="error_alert">'. $mensajeAperturaWait .'</div>';
                }
          if (isset($mensajeCierreWait))
          {
            echo '<div class="alert alert-danger alert-dismissible" role="alert" id="error_alert">'. $mensajeCierreWait .'</div>';
          }
          if (isset($mensajeVotacionOK))
          {
            echo '<div class="alert alert-success alert-dismissible" role="alert" id="error_alert">'. $mensajeVotacionOK .'</div>';
          }
          if (isset($mensajeVotacionInvalida))
          {
            echo '<div class="alert alert-success alert-dismissible" role="alert" id="error_alert">'. $mensajeVotacionInvalida .'</div>';
          }
          else
          {
            if(isset($success))
                echo '<div class="alert alert-success alert-dismissible" role="alert" id="error_alert">'. $success .'</div>';
          }
          */
        }
        
    ?>

    <div id="infoVotacion">
        <h3 id=votacionName><span class="votacionH3">$titulo</span></h3>
        <div id="votacionDesc"><p>$descripcion</p></div>
    </div>


</div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  </body>
</html>
