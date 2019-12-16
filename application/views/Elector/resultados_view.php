<!doctype html>
<html lang="en">

  <link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/prueba.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/circle.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/mesaElectoral.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/behaviour/footer.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

  <body>

<br><br><br><br>
  <div class="container">
    <div class = "container">
      <h2><?php echo 'Resultados '.$titulo; ?> </h2>

      <div id="graphic-info">
      <h2>Porcentaje de voto</h2>
      </div>
        <div id="vote-info">
            <div class="c100 p<?php ($total*100)/$censo; ?> big center" style="float:left;">
                <span><?php echo ($total*100)/$censo; ?></span>
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
                  <h3 class="card-text"><center><?php echo $total; ?></center></h3>
                </div>
              </div>   
              <div class="card">
                <div class="card-header">
                  Tamaño del censo
                </div>
                <div class="card-body">
                  <h3 class="card-text"><center><?php echo $censo; ?></center></h3>
                </div>
              </div>  
              <div class="card">
                <div class="card-header">
                  Información sobre el voto
                </div>
                <div class="card-body">
                  <?php 
                  for($i=0; $i<sizeof($datos); ++$i) {
                    echo '<h5 class="card-text">'.$nomVotos[$i].': '.$datos[$i]->Num_Votos.'</h5>';
                  } ?>
                </div>
              </div>    
          </div>
        </div>

    </div>
  </div>

</body>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>/assets/js/jquerySlim.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

    <!-- Scripts para la tabla de votaciones -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.js"></script>
</html>
