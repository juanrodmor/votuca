<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Secretario</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!--<link href="<?php echo base_url(); ?>/assets/css/bootstrap.css" rel="stylesheet">-->
    <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

  </head>

  <body>
  <header>
    <!-- MINI MENU BOTONES -->

  <div class="imagen">

    <!-- IMAGEN DEL LOGO -->
    <h1><img src="<?php echo base_url('assets/img/logo_uca_header.png')?>"class="img-fluid" alt="Responsive image"></h1>
</div>
    <!-- MENU PRINCIPAL -->
    
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">VotUCA</a>
      <!-- Boton de diseño adaptable -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
              <a class="nav-link" href="<?= base_url().'secretario/'?>">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Votaciones</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="<?= base_url().'secretario/crearVotacion'?>">Crear</a>
            </div>
          </li>

        </ul>
        <ul class="navbar-nav ">
          <li class="nav-item my-2 my-lg-0 mr-sm-2">
            <a class="nav-link" href="<?= base_url().'login_controller/logout'?>">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
  </header>

<div class="container">

  <div class ="mensaje">
    <?php if(isset($mensaje)): ?>
          <br/><h1><?= $mensaje ?></h1><br/>
      <?php endif; ?>
    </div>

  <div class = "container">
    <table class="display table table-responsive" id="votaciones_admin">
       <thead>
         <tr>
           <th scope="col" class="no-sort">ID</th>
           <th scope="col">Titulo</th>
           <th scope="col">Descripcion</th>
           <th scope="col">Fecha Inicio</th>
           <th scope="col">Fecha Final</th>
           <th scope="col"></th>
           <th scope="col"></th>
           <th scope="col"></th>
         </tr>
       </thead>
     <tbody>
       <?php
        foreach($votaciones as $votacion){?>
          <?php foreach($votacion as $objeto){?>
         <tr>
         <?php
           if($objeto->FechaFinal == date('Y-m-d') || $objeto->FechaFinal < date('Y-m-d') )
           {
              echo "<th scope=row class=table-danger>";  // Ha finalizado
           }
           else{echo "<th scope=row class=table-success>";}
         ?>
         <?php echo $objeto->Id;?>
         </th>
         <td><?php echo $objeto->Titulo;?></td>
         <td><?php echo $objeto->Descripcion;?></td>
         <td><?php echo $objeto->FechaInicio;?></td>
         <td><?php echo $objeto->FechaFinal;?></td>

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
           <!-- BOTON DE MODIFICAR -->
           <?=form_open(base_url().'secretario/modificarVotacion',
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

          <?php } ?> <!-- FIN DEL IF DATE -->
         </tr>
     <?php }?>
     <?php }?>
     </tbody>
    </table>
  </div>
</div>

<footer class="footer">
  <div class="container">
      <div class="row">
      <div class="col-sm-3">
      <img src="<?php echo base_url('assets/img/footer.png')?>"class="img-fluid" alt="Responsive image">
      <!--<div class="row text-center"> © 2019. Hecho por grupo 5 pinf.</div>-->
      </div>


  </footer>



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
