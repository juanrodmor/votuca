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
          <span id="cerrar-ses" class="nav-link" onclick="location='<?= base_url().'login_controller/logout'?>'">Cerrar sesión</span>
      </nav>
      <div class="row is-flex see-overflow fixed" id="title-container"> 
            <div class="col-xs-12 col-sm-8">
              <h2>Administrador</h2>
            </div>
            <hr class="divider">
            <div class="col-xs-12 col-sm-8" id="linkBox">
              <a href="#" class="marked">Auditoría</a>
              <a href="<?= base_url().'administrador_controller/gestionusuarios'?>" class="unmarked">Modificar rol</a>
            </div>
        </div>
    </div>

        <!----- AQUI ACABA EL ENCABEZADO --->

    <div class="container">
          <form action="<?php base_url() . 'administrador_controller/monitoring'?>" id="monitoring_search" method='post'>
          <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Opciones
      </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="options_dropdown">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="checkLogin" name="cLogin" value="true" checked>
              <label class="form-check-label" for="checkLogin">Login</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="checkLogout" name="cLogout" value="true" checked>
              <label class="form-check-label" for="checkLogout">Logout</label>
            </div>
			<div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="checkUrna" name="cUrna" value="true" checked>
              <label class="form-check-label" for="checkUrna">Urnas</label>
            </div>
			<div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="checkConfirm" name="cConfirm" value="true" checked>
              <label class="form-check-label" for="checkConfirm">Responsabilidades</label>
            </div>
            <!--- DE MOMENTO VIOLARIA LA PRIVACIDAD -->
            <!--<div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="checkVotos" name="cVote" value="true" checked>
              <label class="form-check-label" for="checkVotos">Votos</label>
            </div>-->
          </form>
        </div>
        <div class="form-check form-check-inline">
              <input class="btn-custom" id="submitButton" type="submit" name="Filtrar" value="Consultar">
        </div>
      </div>

    <div class="card" id="card_monitoringView">
        <p class="card-header bold">Se han encontrado los siguientes resultados:</p>
        <div class="card-body" style="text-align: left;">
          <?php
          if(isset($loginfo))
          {
            foreach($loginfo as $string)
            {
              echo $string . ' <br> ';
            }
          }
          ?>
        </div>
    </div>


  </div>

 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
      $(document).ready(function(){
        $("#checkLogin").click(function(){
            if($(this).val() == 'true')
            {
              $(this).val('false');
            }
            else
            {
              $(this).val('true');
            }
        });

        $("#checkLogout").click(function(){
            if($(this).val() == 'true')
            {
              $(this).val('false');
            }
            else
            {
              $(this).val('true');
            }
        });

        $("#checkVotos").click(function(){
            if($(this).val() == 'true')
            {
              $(this).val('false');
            }
            else
            {
              $(this).val('true');
            }
        });
		
		$("#checkUrna").click(function(){
            if($(this).val() == 'true')
            {
              $(this).val('false');
            }
            else
            {
              $(this).val('true');
            }
        });
		
		$("#checkConfirm").click(function(){
            if($(this).val() == 'true')
            {
              $(this).val('false');
            }
            else
            {
              $(this).val('true');
            }
        });

        $("#submitButton").click(function()
        {
          $("#monitoring_search").submit();
        });
      });

    </script>


  </body>


</html>
