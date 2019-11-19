<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SECRETARIO</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">

  <!-- GOOOGLE FONTS -->

</head>

  <body>

<div class="container">
    <br><br><br><br>
    <table class="display table table-striped"id="votaciones_admin">
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
    <tbody>
      <?php
       foreach($votaciones as $votacion){?>
        <tr>
        <?php
          if($votacion->FechaFinal == date('Y-m-d') || $votacion->FechaFinal < date('Y-m-d') )
          {
             echo "<th scope=row class=table-danger>";  // Ha finalizado
          }
          else{echo "<th scope=row class=table-success>";}
        ?>
        <?php echo $votacion->Id;?>
        </th>
        <td><?php echo $votacion->Titulo;?></td>
        <td><?php echo $votacion->Descripcion;?></td>
        <td><?php echo $votacion->FechaInicio;?></td>
        <td><?php echo $votacion->FechaFinal;?></td>
        <?php if($votacion->FechaFinal > date('Y-m-d')){?>
          <!-- BOTON DE MODIFICAR -->
          <?=form_open(base_url().'secretario/modificarVotacion',
                  array('name'=>'modificarVotacion'));?>
                 <?php
                 $atributos = array(
                    'modificar' => $votacion->Id

                );
                 ?>
           <?= form_hidden($atributos);?>
           <?php $atributos = array(
               'name' => 'boton_modificar',
               'class' => 'btn btn-primary',
               'type' => 'submit',
               'value' => 'Modificar'
           ); ?>
           <td><?= form_submit($atributos);?></td>
           <?= form_close(); ?>
        </tr>
      <?php }?>
    <?php }?>

    </tbody>
    </table>
  
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
   <script src="<?php echo base_url()."assets/js/behaviour/tabla_secretario.js"?>"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.js"></script>

  </body>
</html>
