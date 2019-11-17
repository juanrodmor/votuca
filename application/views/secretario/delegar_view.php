<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Delegar Votacion</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">


  </head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

  </head>

  <body>
    <header>
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
  	</header>

  <div class="container">
    <main role="main" class="container">
      <div class="jumbotron">
            <center><h1>Secretario</h1></center>
      </div>
    </main>

    <?php if(isset($mensaje)): ?>
          <h2><?= $mensaje ?></h2>
      <?php endif; ?>

<div class = "container">
    <table class="display table table-striped table-bordered" style="width:100%" id="votaciones_admin">
      <thead>
        <tr>
          <th scope="col" class="no-sort">ID</th>
          <th scope="col">Nombre Usuario</th>
          <th scope="col"> </th>
        </tr>
      </thead>
    <tbody>

      <?php
       foreach($secretarios as $secretario){?>
         <?php foreach($secretario as $objeto){?>
      <tr>
        <td><?php echo $objeto->Id?></td>
        <td><?php echo $objeto->NombreUsuario?></td>

        <!-- EXTRAYENDO LA INFORMACION -->
        <?=form_open(base_url().'secretario/aceptarDelegacion');?>
               <?php
               $atributos = array(
                  'idSecretario' => $objeto->Id,
                  'idVotacion' => $idVotacion
                );
               ?>
         <?= form_hidden($atributos);?>
         <?php $atributos = array(
             'name' => 'boton_finalizar',
             'class' => 'btn btn-primary',
             'type' => 'submit',
             'onclick' => "return confirm('¿Estás seguro de que quieres delegar en este secretario esta votación?')",
             'value' => 'Delegar Secretario'
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
    <script src="<?php echo base_url()."assets/js/behaviour/administracion_votaciones.js"?>"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.js"></script>


  </body>
</html>
