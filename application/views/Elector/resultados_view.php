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
    
    <div style="overflow: inherit;z-index:200;margin-top:11%;position:fixed;width:81%;height:54%;top: -4%;" class="table-wrapper-scroll-y my-custom-scrollbar">
    <table class="display table" id="votaciones_usuario" >
       <thead>
         <tr>
            <th style="border:0px;background-color:#7C9024;color:white;align:left;"><h2 style="padding-left:2%;">Elector</h2></th>
            <th style="border:0px;background-color:#7C9024;color:white;align:left;"></th>
         </tr>
         <tr style="margin-top:-1%;">
            <td style="background-color:#7C9024;color:white;align:left;padding:0%;height:38px;widht:auto;"><h4 style="cursor:pointer;background-color:#425002;padding-left:2%;height: 38px;width: 160px;margin-bottom:0px;margin-left:0%;"><a href="<?= base_url().'Elector_controller/index/'?>" style="text-decoration:none;color:white;">Votaciones</a></h4></td>
            <td style="background-color:#7C9024;color:white;align:left;padding:0%;height:38px;widht:auto;"></td>
         </tr>
       </thead>
    </table>
    </div>
    <div class = "container" style="position:absolute;margin-top:11%;">
      <h2 style="color:black;"><?php echo 'Resultados '.$titulo; ?> </h2>

      <div id="graphic-info">
      <h2 id="title-porcentaje" style="color:black;margin-left:2%">Participación</h2>
      </div>
        <div id="vote-info">
            <div class="c100 p<?php echo (100-($datos[0]->Num_Votos*100)/$censo) ?> big center" style="float:left;color:black;margin-top:2%;">
                <span><?php echo (100-($datos[0]->Num_Votos*100)/$censo).'%'; ?></span>
                <div class="slice">
                  <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
          <div id="vote-card" class="row">
              <div class="card" style="margin-left:5%;margin-top:3%;">
                <div class="card-header" style="color:black;">
                  Número de votos
                </div>
                <div class="card-body">
                  <h3 class="card-text" style="color:black;"><center><?php echo $total; ?></center></h3>
                </div>
              </div>   
              <div class="card" style="margin-left:5%;margin-top:3%;">
                <div class="card-header" style="color:black;">
                  Tamaño del censo
                </div>
                <div class="card-body">
                  <h3 class="card-text" style="color:black;"><center><?php echo $censo; ?></center></h3>
                </div>
              </div>  
              <div class="card" style="margin-left:5%;margin-top:3%;">
                <div class="card-header" style="color:black;">
                  <center>
                    Resultados
                  </center>
                </div>
                <div class="card-body" style="color:black;">
                  <?php 
                  for($i=0; $i<sizeof($datos); ++$i) {
                    echo '<h5 class="card-text" style="color:black;">'.$nomVotos[$i].': '.$datos[$i]->Num_Votos.'</h5>';
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
   <script src="<?php echo base_url()."assets/js/behaviour/resultados_elector.js"?>"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.js"></script>
</html>
