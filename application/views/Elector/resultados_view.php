<!doctype html>
<html lang="en">

<head>

  <link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/electorResultados.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

</head>

<body style="margin-bottom: 7%;">

  <div class="container">

      <div id="infoVotacion" style="margin-top:5%;">
          <h3 id=votacionName><span class="votacionH3"><?php echo $titulo ?></span></h3>
          <div id="votacionDesc"><p><?php echo $descripcion ?></p></div>

          <h4 style="color:black;"><span>Resultados</span></h2>

          <table id="resultTable">
              <tr id="trHeader">
                <th id="thHeaderOption">Votos</th>
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
            <p style="font-weight: bold;">Número total de electores: <?php echo $censo ?></p>
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
   <script src="<?php echo base_url()."assets/js/behaviour/resultados_elector.js"?>"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.js"></script>
</html>
