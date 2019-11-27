<!doctype html>
<html lang="en">

  <body>
<br><br><br><br><br>
  <div class="container">
    <?php
      if($mensaje != FALSE) 
        echo '<div class="alert alert-primary" role="alert">' . $mensaje . '</div>';
    ?>
    <div class="table-wrapper-scroll-y my-custom-scrollbar">
    <table class="display table table-striped" id="votaciones_admin" >
       <thead>
         <tr align="center">
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
          echo '<h2> No tienes votaciones pendientes</h2>';
        else {

          foreach($datos as $objeto) { ?>
            <tr align="center">
              <?php
                if($objeto->FechaInicio <= date('Y-m-d H:i:s') AND $objeto->FechaFinal >= date('Y-m-d H:i:s'))
                  echo "<th scope=row class=table-success>";
                //if($objeto->FechaFinal == date('Y-m-d'))
                  //echo "<th scope=row class=table-warning>";
                if($objeto->FechaFinal < date('Y-m-d H:i:s'))
                  echo "<th scope=row class=table-danger>";
                if($objeto->FechaInicio > date('Y-m-d H:i:s'))
                  echo "<th scope=row class=table-secondary>";
              ?>
              <?php echo $objeto->Titulo;?>
              </th>
              <td align="center"><?php echo $objeto->Descripcion;?></td>
              <td align="center"><?php echo $objeto->FechaInicio;?></td>
              <td align="center"><?php echo $objeto->FechaFinal;?></td>
              <td align="center"><?php echo $objeto->Nombre;?></td>

        <?php
          if($objeto->FechaInicio <= date('Y-m-d H:i:s') AND $objeto->FechaFinal >= date('Y-m-d H:i:s')) {
            ?>
            <td>
              <form action="<?= base_url().'Elector_controller/votar/'?>" method="post">
                <input type="hidden" name="id_votacion" value="<?php echo $objeto->Id; ?>"/>
                <input type="hidden" name="titulo" value="<?php echo $objeto->Titulo; ?>"/>
                <input type="hidden" name="descrip" value="<?php echo $objeto->Descripcion; ?>"/>
                <input class="btn btn-primary" type="submit" value="Votar">
              </form>
            </td>
            <?php
            //echo '<td><a class="btn btn-primary" href='.base_url().'Elector_controller/votar/ role="button">Votar</a></td>';
          }
          if($objeto->FechaFinal < date('Y-m-d H:i:s')) {
            ?>
            <td>
              <form action="<?= base_url().'Elector_controller/verResultados/'?>" method="post">
                <input type="hidden" name="id_votacion" value="<?php echo $objeto->Id; ?>"/>
                <input type="hidden" name="titulo" value="<?php echo $objeto->Titulo; ?>"/>
                <input class="btn btn-primary" type="submit" value="Resultados">
              </form>
            </td>
            <?php
            //echo '<td><a class="btn btn-primary" href='.base_url().'Elector_controller/verResultados/ role="button">Resultados</a></td>';
          }
          if($objeto->FechaInicio > date('Y-m-d H:i:s')) {
            //echo '<td><div class="alert alert-info" role="alert"> Proximamente </div></td>';
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
   <!--<script src="<?php echo base_url()."assets/js/behaviour/tabla_secretario.js"?>"></script>-->



  </body>
</html>
