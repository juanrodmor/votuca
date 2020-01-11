<!doctype html>
<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="viewport" content="width=1200px, initial-scale=1.0" />
  <title>SECRETARIO</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/behaviour/secretario.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">

</head>
  <body>
    <!-- Aqui se importa headerSecretario.php de elementos -->
    <!--- FIN ENCABEZADO --->
<div class="containerTabla">
  <!--<div class="table-wrapper-scroll-y my-custom-scrollbar">-->
<table id="tablaSecre" class="table table-striped table-bordered table-sm">
     <tbody>
       <?php
        foreach($votaciones as $votacion){?>
          <?php foreach($votacion as $objeto){?>
         <tr>
         <?php
           if($objeto->FechaFinal < date('Y-m-d') )
           {echo "<th scope=row class=table-danger>";} // Ha finalizado
           if($objeto->FechaFinal == date('Y-m-d')) // Finaliza hoy
           {echo "<th scope=row class=table-warning>";}
            if($objeto->FechaFinal > date('Y-m-d')) // Está disponible
            {echo "<th scope=row class=table-success>";}
         ?>
         </th>
         <?php echo "<br><td scope=row><h4 style='float:left;color:black'><b>".$objeto->Id." ".$objeto->Titulo."</b></h4><br><br><span style='float:left;color:black'>Fecha de inicio: ".$objeto->FechaInicio."</span><br><span style='float:left;color:black'>Fecha de finalización: ".$objeto->FechaFinal."</span></td>";?>
        <?php
          if($objeto->esBorrador == 1){
            echo "<td><br><span style='color:black'> En borrador </span></td>";
          }
          else{echo "<td><br><span style='color:black'> Publicada </span></td>";}
        ?>


          <!-- BOTON DE ELIMINAR -->
          <?=form_open(base_url().'secretario/eliminarVotacion',
         		    array('name'=>'eliminarVotacion'));?>
                <?php
                $atributos = array(
                   'eliminar' => $objeto->Id // ID => Valor
               );
                ?>
          <?= form_hidden($atributos);?>
          <?php $atributos = array(
              'name' => 'boton_eliminar',
              'class' => 'btn btn-primary',
              'type' => 'submit',
              'value' => 'Eliminar',
              'onclick' => "return confirm('¿Estás seguro de que quieres eliminar esta votación?')"
          ); ?>
          <td><?= form_submit($atributos);?></td>
          <?= form_close(); ?>

         <?php if($objeto->FechaFinal >= date('Y-m-d')){?>
            <!-- BOTON DE DELEGAR -->
            <?=form_open(base_url().'secretario/delegarVotacion',
                    array('name'=>'delegarVotacion'));?>
                   <?php
                   $atributos = array(
                      'delegar' => $objeto->Id
                  );
                   ?>
             <?= form_hidden($atributos);?>
             <?php $atributos = array(
                 'name' => 'boton_delegar',
                 'class' => 'btn btn-primary',
                 'type' => 'submit',
                 'value' => 'Delegar'
             ); ?>
             <td><?= form_submit($atributos);?></td>
             <?= form_close(); ?>

          <?php }?> <!-- FIN DEL IF DELEGAR-->
        <?php
          if($objeto->FechaInicio > date('Y-m-d H:i:s') && // S aun no ha empezado
             $objeto->FechaFinal >= date('Y-m-d H:i:s') ){?>

        <!-- BOTON DE MODIFICAR -->
        <?=form_open(base_url().'secretario/modificarVotacion/',
                array('name'=>'modificarVotacion'));?>
               <?php
               $atributos = array(
                  'modificar' => $objeto->Id
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

       	<?php } // FIN IF MODIFICAR?>
		</tr>
     <?php }?>
     <?php }?>
     </tbody>
</table>
<!--</div>-->
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
