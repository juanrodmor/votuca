<!doctype html>
<html lang="en">

  <body style="overflow:hidden;">
  <div class="container">
    <?php
      if($mensaje == "correcto"){ //mensaje de exito al votar
        echo '<div id="alerta" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">';
        echo '<div style="margin-top:10%;" class="modal-dialog modal-lg">';
        echo '<div style="background-color:#9BDF99;" class="modal-content">';
        echo '<center>La votacion se ha hecho correctamente.</center>';
        echo '<br>';
        echo '<center>Haz click para continuar.</center>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      if($mensaje == "mal"){  //mensaje de error al votar
        echo '<div id="alerta" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">';
        echo '<div style="margin-top:10%;" class="modal-dialog modal-lg">';
        echo '<div style="background-color:#DF8566;" class="modal-content">';
        echo '<center>La votacion no se ha podido realizar.</center>';
        echo '<br>';
        echo '<center>Haz click para continuar.</center>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      if($mensaje != NULL){ //imprime los mensajes de error de acceder mal por la URL
        echo '<div id="alerta" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">';
        echo '<div style="margin-top:10%;" class="modal-dialog modal-lg">';
        echo '<div style="background-color:#DF8566;" class="modal-content">';
        echo '<center>'.$mensaje.'</center>';
        echo '<br>';
        echo '<center>Haz click para continuar.</center>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
    ?>
    <div style="overflow: inherit;z-index:200;margin-top:8%;" class="table-wrapper-scroll-y my-custom-scrollbar">
    <table class="display table" id="votaciones_usuario" >
       <thead>
         <tr>
            <th style="border:0px;background-color:#7C9024;color:white;align:left;"><h2 style="padding-left:2%;">Elector</h2></th>
            <th style="border:0px;background-color:#7C9024;color:white;align:left;"></th>
         </tr>
         <tr style="margin-top:-1%;">
            <td style="background-color:#7C9024;color:white;align:left;padding:0%;height:38px;widht:auto;"><h4 style="cursor:pointer;background-color:#425002;padding-left:2%;height: 38px;width: 160px;margin-bottom:0px;margin-left:1%;">Votaciones</h4></td>
            <td style="background-color:#7C9024;color:white;align:left;padding:0%;height:38px;widht:auto;"></td>
         </tr>
       </thead>
      <tbody>
      <?php
        if($datos == NULL)
          echo '<h2> No tienes votaciones pendientes</h2>';
        else {
          foreach($datos as $objeto) { ?>
            <tr align="center">
              <?php echo "<td scope=row><h5 style='float:left;'><b>".$objeto->Titulo."</b></h5><br><br><span style='float:left;'>fecha de inicio: ".$objeto->FechaInicio."</span><br><span style='float:left;'>fecha de finalización: ".$objeto->FechaFinal."</span></td>";?>

        <?php
          if($objeto->FechaInicio <= date('Y-m-d H:i:s') AND $objeto->FechaFinal >= date('Y-m-d H:i:s')) {
            if($objeto->VotoModificable == '1') {
              ?>
              <td>
                <form action="<?= base_url().'Elector_controller/votar/'?>" method="post">
                  <input type="hidden" name="id_votacion" value="<?php echo $objeto->Id; ?>"/>
                  <input type="hidden" name="titulo" value="<?php echo $objeto->Titulo; ?>"/>
                  <input type="hidden" name="descrip" value="<?php echo $objeto->Descripcion; ?>"/>
                  <input type="hidden" name="fch" value="<?php echo $objeto->FechaFinal; ?>"/>
                  <input type="hidden" name="modif" value="<?php echo $objeto->VotoModificable; ?>"/>
                  <br><input style="background-color:#455a64;border-color:#455a64;" class="btn btn-primary" type="submit" value="Votar">
                </form>
              </td>
              <?php
            }
            else {
              if( $this->Voto_model->_haVotado($objeto->Id) )
                echo '<td> Ya votado </td>';
              else {
                ?>
                <td>
                  <form action="<?= base_url().'Elector_controller/votar/'?>" method="post">
                    <input type="hidden" name="id_votacion" value="<?php echo $objeto->Id; ?>"/>
                    <input type="hidden" name="titulo" value="<?php echo $objeto->Titulo; ?>"/>
                    <input type="hidden" name="descrip" value="<?php echo $objeto->Descripcion; ?>"/>
                    <input type="hidden" name="fch" value="<?php echo $objeto->FechaFinal; ?>"/>
                    <input type="hidden" name="modif" value="<?php echo $objeto->VotoModificable; ?>"/>
                    <br><input style="background-color:#455a64;border-color:#455a64;" class="btn btn-primary" type="submit" value="Votar">
                  </form>
                </td>
                <?php
              }
            }
          }
          if($objeto->FechaFinal < date('Y-m-d H:i:s')) {
            ?>
            <td>
              <form action="<?= base_url().'Elector_controller/verResultados/'?>" method="post">
                <input type="hidden" name="id_votacion" value="<?php echo $objeto->Id; ?>"/>
                <input type="hidden" name="titulo" value="<?php echo $objeto->Titulo; ?>"/>
                <br><input style="background-color:#455a64;border-color:#455a64;" class="btn btn-primary" type="submit" value="Resultados">
              </form>
            </td>
            <?php
          }
          if($objeto->FechaInicio > date('Y-m-d H:i:s')) {
            echo '<td> Proximamente </td>';
          }
        ?>
        </tr>
          <?php }?>
        <?php }?>
      </tbody>
    </table>
    
  </div>
</div>


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



  </body>
</html>
