<!doctype html>
<html lang="en">

<script type="text/javascript">
  function checkBoxLimit(limit) {
    var checkBoxGroup = document.forms['votosdisp']['voto[]'];     
    var limit = limit;
    for (var i = 0; i < checkBoxGroup.length; i++) {
      checkBoxGroup[i].onclick = function() {
        var checkedcount = 0;
        for (var i = 0; i < checkBoxGroup.length; i++) {
          checkedcount += (checkBoxGroup[i].checked) ? 1 : 0;
        }
        if (checkedcount > limit) {
          alert("Solo puedes seleccionar un maximo de " + limit + " votos.");           
          this.checked = false;
        }
      }
    }
  }
</script>

  <body style="overflow:hidden;">
  <div class="container">
  <div style="overflow: inherit;z-index:200;margin-top:11%;position:fixed;width:81%;height:54%;top: -4%;" class="table-wrapper-scroll-y my-custom-scrollbar">
    <table class="table" id="voto_usuario" >
       <thead>
         <tr>
            <th style="border:0px;background-color:#7C9024;color:white;align:left;"><h2 style="padding-left:2%;">Elector</h2></th>
         </tr>
         <tr style="">
            <td style="background-color:#7C9024;color:white;align:left;padding:0%;height:38px;widht:auto;"><h4 style="cursor:pointer;background-color:#425002;padding-left:2%;height: 38px;width: 160px;margin-bottom:0px;margin-left:0%;"><a href="<?= base_url().'Elector_controller/index/'?>" style="text-decoration:none;color:white;">Votaciones</a></h4></td>
         </tr>
       </thead>
      <tbody>
        <tr>
          <th>
            <?php echo "<h2 style='padding-left:5%;'>".$titulo."</h2>";?>
          </th>
        </tr>
        <!-- <hr style="width: 50%;color: red;z-index: 200;float: left;background-color: #7C9024;position: relative;top: 56%;border-top-width: 3px;"> -->
        <tr>
          <td style="border-style:none;">
            <?php echo "<span style='padding-left:2%;'>".$descrip."</span>";?>
          </td>
        </tr>
        <tr>
          <td style="border-style:none;">
            <?php echo "<span style='padding-left:2%;'><b>Fecha de cierre: </b>".$fch."</span>";?>
          </td>
        </tr>
        <tr>
          <td style="border-style:none;">
            <?php echo "<h4 style='padding-left:2%;'> Información: </h4>";?>
          </td>
        </tr>

        <td style="border-style:none;">
        <form action="<?= base_url().'Elector_controller/guardarVoto/'?>" method="post" name="votosdisp">
          <?php if(isset($grupos)) { ?> 
              <span style='padding-left:2%;'> Debe elegir cómo desea votar. </span> <br><br>
              <select name="grupo" style="margin-left:5%;">
                <?php foreach($grupos as $grupo) { ?>
                  <option value="<?php echo $grupo->Nombre; ?>"> <?php echo $grupo->Nombre; ?></option>
                <?php } ?>
              </select> <br><br>
          <?php } ?>

          <?php if($opc > 1) echo "<span style='padding-left:2%;'> Puede seleccionar hasta ".$opc." opciones. </span> <br><br>";
                else echo "<span style='padding-left:2%;'> Debe seleccionar 1 opcion. </span> <br><br>"; 
          ?>
          
          <?php 
            if($modif == 1)
              echo "<span class='alert alert-info' role='alert' style='padding-left:2%;margin-left:2%;'> El voto es rectificable </span><br>";
            if($modif != 1)
              echo "<span class='alert alert-warning' role='alert' style='padding-left:2%;margin-left:2%;'> El voto NO es rectificable </span><br>";
          ?>
      <center>
        <?php
          if(form_error('voto') != NULL)
            echo '<div class="alert alert-danger" role="alert">' . form_error('voto') . '</div>'; 
          if(form_error('voto[]') != NULL)
            echo '<div class="alert alert-danger" role="alert">' . form_error('voto[]') . '</div>';
        ?>
          <?php foreach($votos as $voto) { ?>
            
              <input type="hidden" name="id_votacion" value="<?php echo $id_votacion; ?>"/>
              <input type="hidden" name="titulo" value="<?php echo $titulo; ?>"/>
              <input type="hidden" name="descrip" value="<?php echo $descrip; ?>"/>
              <input type="hidden" name="fch" value="<?php echo $fch; ?>"/>
              <input type="hidden" name="modif" value="<?php echo $modif; ?>"/>
              <input type="hidden" name="opc" value="<?php echo $opc; ?>"/>
              <?php if(isset($grupos)) { ?>
                <input type="hidden" name="id_tipoVotacion" value="<?php echo $id_tipoVotacion; ?>"/>
              <?php } ?>
              <!-- <div style=""> -->
                <?php 
                  if($opc > 1) {  //votacion compleja 
                    echo '<input class="single-checkbox" type="checkbox" name="voto[]" value="'.$voto.'" style="margin-left:3%;margin-right:0.2em;">'.$voto;
                  }
                  else echo '<input type="radio" name="voto" value="'.$voto.'" style="margin-left:3%;margin-right:0.2em;">'.$voto; // votacion simple
                ?>
              <!-- </div> -->

          <?php } ?>
        
        <br><br>
        <input style="background-color:#455a64;border-color:#455a64;" class="btn btn-primary" type="submit" value="Votar">
      </center>
    </form>
    <script type="text/javascript">   // controlador de checkbox de votos -> como maximo $opc opciones
      checkBoxLimit(<?php echo $opc; ?>) 
    </script>
          </td>
        </tr>
      </tbody>
    </table>
    
  </div>
  </div>
</body>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url()."assets/js/jquerySlim.js"?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url()."assets/js/bootstrap.min.js"?>"></script>

    <!-- Scripts para la tabla de votaciones -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
   <script src="<?php echo base_url()."assets/js/behaviour/voto.js"?>"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url()."assets/js/bootstrap-datepicker.js"?>"></script>

</html>
