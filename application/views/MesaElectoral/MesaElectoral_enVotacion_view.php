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
                }**/
          if (isset($mensajeCierreWait))
          {
            echo '<div class="alert alert-danger alert-dismissible" role="alert" id="error_alert">'. $mensajeCierreWait .'</div>';
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

    <div id="infoVotacion">
        <h3 id=votacionName><span class="votacionH3"><?php echo $titulo ?></span></h3>
        <div id="votacionDesc"><p><?php echo $descripcion ?></p></div>

        <h4><span>Resultados</span></h2>

        <table id="resultTable">
            <tr id="trHeader">
              <th id="thHeaderOption">Opciones</th>
              <?php
                foreach ($grupos as $group)
                {
                  echo '<th id="thHeaderOption">'.$group.'</th>';
                }
              ?>
			  <th id="thHeaderOption">Total</th>
            </tr>
            
              <?php
			  global $votosLocal;
              $votosLocal = array();
                foreach($opciones as $option)
                {
                  echo '<tr id="trBody"><th id="thBodyOption">'.$option.'</th>';
				  $totalIndividual = 0;
                  foreach($grupos as $group)
                  {
                   // $votosLocal[$group] += $matrizVotos[$option][$group];
                    echo '<th id="thBodyOption">'.$matrizVotos[$option][$group].'</th>';
					$totalIndividual += $matrizVotos[$option][$group];
                  }
				  echo '<th id="thBodyOption">'.$totalIndividual.'</th>';
                  echo '</tr>';
                }
              ?>                        
        </table>

        <div id="textInfo">
          <!--<?php global $votosLocal; print_r($votosLocal); ?>-->
          <p class="bold">Número total de electores: <?php echo $censo ?></p>
          <div class="row">
            <p class="col-sm-4">Participación: <?php echo round((($censo-$abstenciones)/$censo*100), 1) ?>%</p>
			<?php $subtotal = 0;
			foreach($opciones as $option) {
				$subtotal += $matrizVotos[$option]['PAS'];
			}
			echo '<p class="col-sm-4">Total votos PAS: '.$subtotal.'</p>'?>
          </div>
          <div class="row">
            <p class="col-sm-4">Abstención: <?php echo $abstenciones ?></p>
			<?php $subtotal = 0;
			foreach($opciones as $option) {
				$subtotal += $matrizVotos[$option]['Alumnos'];
			}
			echo '<p class="col-sm-4">Total votos Alumnos: '.$subtotal.'</p>'?>
          </div>
          <div class="row">
            <p class="col-sm-4">Quorum: <?php echo ($quorum*100).'%' ?> </p>
			<?php $subtotal = 0;
			foreach($opciones as $option) {
				$subtotal += $matrizVotos[$option]['Profesores'];
			}
			echo '<p class="col-sm-4">Total votos Profesores: '.$subtotal.'</p>'?>
          </div>
        </div>

        <div id="actionButtons">
          <form action="<?php echo base_url() . '/MesaElectoral/finalizaVotacion' ?>" method="post">
            <input type="hidden" value="" name="idVotacion">
            <div class="form-group row">
              <div><input type="submit" class="btn-validate form-control" name="boton_finalizar" value="Validar votación"></div>
              <div><input type="submit" class="btn-error form-control" name="boton_finalizar" value="Invalidar votación"></div>
            </div>
            </form>
        </div>
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
