<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>EDICION DE VOTACIONES</title>
	<!-- Bootstrap core CSS -->
	<link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
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

<br><br><br><br>
<div class = "container">
	  <?=form_open(base_url().'secretario/updateVotacion/');?>
		<div class="form-group">
			<?php
			 $atributos = array(
					'name' => 'id',
					'class' => 'form-control',
					'id' => 'id',
					'readonly'=> 'readonly',
					'value' => $votaciones->Id
			); ?>
			<?= form_label('ID','id'); ?>
			<?= form_input($atributos) ?> <br/><br/>
		</div>

		<!-- TITULO -->
		<div class="form-group">
			<?php
			 $atributos = array(
				  'name' => 'titulo',
					'class' => 'form-control',
					'id' => 'titulo',
					'required' => true,
					'value' => $votaciones->Titulo
			); ?>
			<?= form_label('Titulo','titulo'); ?>
			<?= form_input($atributos) ?> <br/><br/>
		</div>
		<div class="form-group">
			<?php
			 $atributos = array(
				 'name' => 'descripcion',
					'class' => 'form-control',
					'id' => 'descripcion',
					'required' => true,
					'value' => $votaciones->Descripcion
			); ?>
			<?= form_label('Descripcion','descripcion'); ?>
			<?= form_input($atributos) ?> <br/><br/>
		</div>
		<div class="form-group">
			<?php
			 $atributos = array(
					'name' => 'fecha_inicio',
					'class' => 'form-control',
					'data-provide' => 'datepicker',
					'data-date-format' => "dd-mm-yyyy",
					'data-date-start-date'=>"0d",
					'id' => 'fecha_inicio',
					'required' => true,
					'value' => $votaciones->FechaInicio
			); ?>
			<?= form_label('Fecha Inicio','fecha_inicio'); ?>
			<?= form_input($atributos) ?> <br/><br/>
		</div>
		<div class="form-group">
			<?php $atributos = array(
					'name' => 'fecha_final',
					'class' => 'form-control',
					'data-provide' => 'datepicker',
					'data-date-format' => "dd-mm-yyyy",
					'id' => 'fecha_final',
					'required' => true,
					'value' => $votaciones->FechaFinal
			); ?>
			<?= form_label('Fecha Final','fecha_final'); ?>
			<?= form_input($atributos) ?> <br/><br/>
		</div>

		<?php $atributos = array(
				'name' => 'submit_reg',
				'class' => 'btn btn-primary',
				'type' => 'submit',
				'value' => 'Enviar'
		); ?>
		<center><?= form_submit($atributos);?></center>
	<?= form_close(); ?>
</div>

<br>
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

</body>
</html>
