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

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>/assets/js/jquerySlim.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

</body>
</html>
