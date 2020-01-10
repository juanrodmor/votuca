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
           
          if(isset($mensajeAperturaWait))
                {
                  echo '<div class="alert alert-success alert-dismissible" role="alert" id="error_alert">'. $mensajeAperturaWait .'</div>';
                }
          
          if (isset($mensajeCierreWait))
          {
            echo '<div class="alert alert-success alert-dismissible" role="alert" id="error_alert">'. $mensajeCierreWait .'</div>';
          }
          /** 
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

    <?php
    if(isset($votaciones) && count($votaciones) != 0)
    {
      echo'
      <div class="card" id="card-options">
       <ul class="list-group list-group-flush">';
        foreach($votaciones as $objeto){
          echo'
            <li id="single-option" class="list-group-item"> 
            <form action="'. base_url('MesaElectoral/recuentoVotos') . '" method="post">
                <div id="data-option">
                    <h4 style="color:black; font-weight: bold;">'.$objeto->Titulo.'</h4>
                    <p style="margin: 0;">Fecha de inicio: '.$objeto->FechaInicio.'</p>
                    <p style="margin: 0;">Fecha de fin: '.$objeto->FechaFinal.'</p>
                    <input type="hidden" id="votacionId" name="recuento" value="'.$objeto->Id.'">
                </div>
                <div id="btn-div">';
                    if($objeto->FechaFinal == date('Y-m-d H:i:s') || $objeto->FechaFinal < date('Y-m-d H:i:s'))
                      echo '<input type="submit" class="btn-custom" name="boton_recuento" value="Abrir urna">';
                    else
                      echo '<input type="submit" class="btn-custom" name="boton_recuento" value="Abrir urna" disabled';
                echo'
                </div>
            </form>
            </li>';
          }
          echo '
            </ul></div>
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

    <!-- Scripts para la tabla de votaciones -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
   <!--<script src="<?php echo base_url()."assets/js/behaviour/tabla_secretario.js"?>"></script>-->
   <script src="<?php echo base_url()."assets/js/behaviour/mesa_electoral.js"?>"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>

  </body>
</html>
