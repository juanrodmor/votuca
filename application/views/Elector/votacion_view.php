<!doctype html>
<html lang="en">
<title>Votaciones</title>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/behaviour/listar_votaciones.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

  </head>

  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <!-- PARTE IZQUIERDA DEL MENU -->
       <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="navbar-brand" href="#">VotUCA > Elector</a>
            </li>
            <li>
              <a class="nav-link" href="<?= base_url().'Elector_controller/'?>">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
      </div>
        <!-- PARTE DERECHA DEL MENU -->
      <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
          <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url().'login_controller/logout'?>">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </nav>

<div class="container">

  <div class = "container">
    <table id="votaciones_usuario" class="display table table-striped table-bordered">
       <thead>
         <tr>
           <th scope="col">Titulo</th>
           <th scope="col">Descripcion</th>
           <th scope="col">Fecha Inicio</th>
           <th scope="col">Fecha Final</th>
           <th scope="col">Voto</th>
         </tr>
       </thead>
      <tbody>

      <?php
        if($datos == NULL)
        {
          echo '<h2> No tienes votaciones pendientes</h2>';
        }
        else {
          foreach($datos as $objeto) { ?>
            <tr>
              <?php
                if($objeto->FechaFinal == date('Y-m-d') || $objeto->FechaFinal < date('Y-m-d') )
                {
                  echo "<th scope=row class=table-danger>";  // Ha finalizado
                }
                else{echo "<th scope=row class=table-success>";}
              ?>
              <?php echo $objeto->Titulo;?>
              </th>
              <td><?php echo $objeto->Descripcion;?></td>
              <td><?php echo $objeto->FechaInicio;?></td>
              <td><?php echo $objeto->FechaFinal;?></td>
              <td><?php echo $objeto->Nombre;?></td>

        <?php
          if($objeto->FechaFinal >= date('Y-m-d')) {
            echo '<td><a class="btn btn-primary" href='.base_url().'Elector_controller/votar/'.$objeto->Id.'/'.$objeto->Titulo.' role="button">Votar</a></td>';
          }
          else {
            echo '<td><a class="btn btn-primary" href='.base_url().'Elector_controller/verResultados/'.$objeto->Id.'/'.$objeto->Titulo.' role="button">Ver resultados</a></td>';
          }
        ?>
        </tr>
          <?php }?>
        <?php }?>
      </tbody>
    </table>

</div>
</div>

  <br>
  <footer class="footer">
  <div class="footer-container">

      <div class="row text-center">&nbsp;&nbsp;&nbsp;&nbsp; © 2019. Hecho por grupo 5 pinf.</div>
      </div>


  </footer>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>/assets/js/jquerySlim.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

    <!-- Scripts para la tabla de votaciones -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
   <script src="<?php echo base_url()."assets/js/behaviour/votacion_elector.js"?>"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.js"></script>

  </body>
</html>
