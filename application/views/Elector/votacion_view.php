<!doctype html>
<html lang="en">

  <body>
<br><br><br><br><br>
<div class="container">
    <div class="table-wrapper-scroll-y my-custom-scrollbar">
    <table class="table table-responsive" id="votaciones_admin" >
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
              <td><?php echo $objeto->Descripcion;?> hola mamapinga </td>
              <td><?php echo $objeto->FechaInicio;?></td>
              <td><?php echo $objeto->FechaFinal;?></td>
              <td><?php echo $objeto->Nombre;?></td>

        <?php
          if($objeto->FechaFinal >= date('Y-m-d')) {
            echo '<td><a class="btn btn-primary" href='.base_url().'Elector_controller/votar/'.$objeto->Id.'/ role="button">Votar</a></td>';
          }
          else {
            echo '<td><a class="btn btn-primary" href='.base_url().'Elector_controller/verResultados/'.$objeto->Id.'/'.$objeto->Titulo.' role="button">Resultados</a></td>';
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
