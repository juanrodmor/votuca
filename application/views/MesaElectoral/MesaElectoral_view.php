<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mesa Electoral</title>
    <!-- Bootstrap core CSS -->
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/mesaElectoral.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/behaviour/footer.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/circle.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

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
              <a href="#" class="marked">Votaciones</a>
            </div>
        </div>
    </div>

        <!----- AQUI ACABA EL ENCABEZADO --->


<div class="container">
 
    <?php
        if(isset($votaciones) && count($votaciones) == 0)
        {
          echo '<div class="alert alert-danger alert-dismissible" role="alert" id="error_alert">No hay votaciones asignadas.</div>';
        }  
        else
        {
           if(isset($mensaje) && $mensaje != '')
            {
              echo '<div class="alert alert-danger alert-dismissible" role="alert" id="error_alert">'. $mensaje .'</div>';
            }
            else
            {
              if(isset($success))
                  echo '<div class="alert alert-success alert-dismissible" role="alert" id="error_alert">'. $success .'</div>';
            }
        }
        
    ?>

<br><br>
  <div class = "container">
    <div id="data-div">
    <?php
    if(isset($cantidad)){
    echo'
      <div id="graphic-info">
      <h2>Porcentaje de voto</h2>
      </div>
        <div id="vote-info">
            <div class="c100 p'.$totalVotos*100/$censo.' big center" style="float:left;">
                <span>'.$totalVotos*100/$censo.'</span>
                <div class="slice">
                  <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
          <div id="vote-card" class="row">
              <div class="card" >
                <div class="card-header">
                  Número de votos
                </div>
                <div class="card-body">
                  <h3 class="card-text">'.$totalVotos.'</h3>
                </div>
              </div>   
              <div class="card">
                <div class="card-header">
                  Tamaño del censo
                </div>
                <div class="card-body">
                  <h3 class="card-text">'.$censo.'</h3>
                </div>
              </div>  
              <div class="card">
                <div class="card-header">
                  Información sobre el voto
                </div>
                <div class="card-body">
                  '; 
                  for($i = 0 ; $i < count($opciones) ; $i = $i + 1)
                  {
                    echo '<h5 class="card-text">'.$opciones[$i].': '.$cantidad[$i].'</h5>';
                  } 
                echo'
                </div>
              </div>    
          </div>

              <div>
                <form action="finalizaVotacion" method="post">
                  <input type="hidden" name="idVotacion" value="'.$votacion.'">
                  <input id="endButton" type="submit" name="boton_finalizar" value="Finalizar" class="btn btn-primary">
                </form>
              </div>

        </div>
    ';
    }
    ?>

    <?php
    if(!isset($mensaje))
    {
      echo'
        <table id="result-table" class="display table table-striped table-bordered">
        <thead>
          <tr>
            <th scope="col" class="no-sort">ID</th>
            <th scope="col">Titulo</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Fecha Inicio</th>
            <th scope="col">Fecha Final</th>
            <th scope="col"></th>
          </tr>
        </thead>
      <tbody>';
        foreach($votaciones as $objeto){
          echo'
            <tr>
            <td scope="row" class="table-danger">'.$objeto->Id.'</td>
            <td>'.$objeto->Titulo.'</td>
            <td>'.$objeto->Descripcion.'</td>
            <td>'.$objeto->FechaInicio.'</td>
            <td>'.$objeto->FechaFinal.'</td>
            '; echo form_open(base_url().'MesaElectoral/recuentoVotos');
                  $atributos = array(
                      'recuento' => $objeto->Id

                  );
                echo form_hidden($atributos);
                  if($objeto->FechaFinal == date('Y-m-d H:i:s') || $objeto->FechaFinal < date('Y-m-d H:i:s'))  
                    echo '<td><input class="btn btn-primary" type="submit" value="Recuento" name="boton_recuento"></td>';
                echo form_close(); 
              echo'
          </tr>';
          }
          echo'
      </tbody>
      </table>';
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

    <!-- Scripts para la tabla de votaciones -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
   <!--<script src="<?php echo base_url()."assets/js/behaviour/tabla_secretario.js"?>"></script>-->

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>

  </body>
</html>
