<!doctype html>
<html lang="en">
  <body style="overflow:hidden;">
  <div class="container">
  <div style="overflow: inherit;z-index:200;margin-top:8%;position:fixed;width:85%;height:54%;top: -4%;" class="table-wrapper-scroll-y my-custom-scrollbar">
    <table class="table" id="voto_usuario" >
       <thead>
         <tr>
            <th style="border:0px;background-color:#7C9024;color:white;align:left;"><h2 style="padding-left:2%;">Elector</h2></th>
         </tr>
         <tr style="">
            <td style="background-color:#7C9024;color:white;align:left;padding:0%;height:38px;widht:auto;"><h4 style="cursor:pointer;background-color:#425002;padding-left:2%;height: 38px;width: 160px;margin-bottom:0px;margin-left:1%;">Votaciones</h4></td>
         </tr>
       </thead>
      <tbody>
        <tr>
          <th>
            <?php echo "<h2 style='padding-left:2%;'>".$titulo."</h2>";?>
          </th>
          <hr style="background-color: #7C9024;position: relative;top: 53%;width: 50%;float: left;height: 1%;border-style: hidden;">
        </tr>
        <!-- <hr style="width: 50%;color: red;z-index: 200;float: left;background-color: #7C9024;position: relative;top: 56%;border-top-width: 3px;"> -->
        <tr>
          <td>
            <?php echo "<span style='padding-left:2%;'>".$descrip."</span>";?>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo "<span style='padding-left:2%;'><b>Fecha de cierre: </b>".$descrip."</span>";?>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo "<h4 style='padding-left:2%;'>Opciones: </h4>";?>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo "<span style='padding-left:2%;'>Puede marcar un maximo de 1</span>";?>
          </td>
        </tr>
        <tr>
          <td>
          <form action="<?= base_url().'Elector_controller/guardarVoto/'?>" method="post">
      <center>
        <?php
          if(form_error('voto') != NULL)
            echo '<div class="alert alert-primary" role="alert">' . form_error('voto') . '</div>'; 
        ?>
        
          <?php foreach($votos as $voto) { ?>
            
              <input type="hidden" name="id_votacion" value="<?php echo $id_votacion; ?>"/>
              <input type="hidden" name="titulo" value="<?php echo $titulo; ?>"/>
              <input type="hidden" name="descrip" value="<?php echo $descrip; ?>"/>
              <input type="radio" name="voto" value="<?php echo $voto->Nombre?>"> <?php echo $voto->Nombre ?>
            
          <?php } ?>
        
        <br><br>
        <input style="background-color:#455a64;border-color:#455a64;" class="btn btn-primary" type="submit" value="Votar">
      </center>
    </form>
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
    <script src="<?php echo base_url(); ?>/assets/js/jquerySlim.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

    <!-- Scripts para la tabla de votaciones -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
   <script src="<?php echo base_url()."assets/js/behaviour/voto.js"?>"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.js"></script>

</html>
