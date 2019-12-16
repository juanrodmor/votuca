<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>MODIFICAR</title>
	<!-- Bootstrap core CSS -->
	<link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">

	<!-- DATETIME PICKER -->
	<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/bootstrap-datetimepicker.min.css">
</head>
<body>

	<div class="container">
	  <div class ="mensaje">
	    <h3><?=   validation_errors();  ?></h3>
	    <?php if(isset($mensaje)): ?>
	          <br/><h1><?= $mensaje ?></h1><br/>

	      <?php endif; ?>

	  </div>
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

		<?php
		 $atributos = array(
				'Id_TipoVotacion' => $votaciones->Id_TipoVotacion
		); ?>
		<?= form_hidden($atributos) ?> <br/><br/>
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
			<?= form_textarea($atributos) ?> <br/><br/>
		</div>

		 <div class="form-group">
		  <div class="row">
		   <div class="col-sm-6">
		    <?php
		    $atributos = array(
		 		         'id' => 'fecha_inicio',
		              'name' => 'fecha_inicio',
		              'class' => 'form-control datetimepicker-input',
		              'data-toggle' => 'datetimepicker',
		              'placeholder' =>'Selecciona una fecha de inicio',
		              'setEndDate' => date('Y-m-d'),
		              'required' => true,
		              'value' => $votaciones->FechaInicio
		          	); ?>
		    <?= form_label('Fecha Inicio','fecha_inicio'); ?>
		    <?= form_input($atributos) ?> <br/><br/>
				</div>
		  </div>
		</div>

		<div class="form-group">
		  <div class="row">
		    <div class="col-sm-6">
		          <?php $atributos = array(
		              'id' => 'fecha_final',
		              'name' => 'fecha_final',
		              'class' => 'form-control datetimepicker-input',
		              'data-toggle' => 'datetimepicker',
		              'placeholder' =>'Selecciona una fecha de finalizacion',
		              'required' => true,
		              'value' => $votaciones->FechaFinal
		        	  ); ?>
		 		<?= form_label('Fecha Final','fecha_final'); ?>
		    <?= form_input($atributos) ?> <br/><br/>
		    </div>
		  </div>
		</div>

		<div class="form-group">
			<?php
			 $atributos = array(
					'name' => 'quorum',
					'class' => 'form-control',
					'id' => 'quorum',
					'placeholder' =>'Introduzca el quorum de esta votación',
					'required' => true,
					'value' => $votaciones->Quorum // Mantiene el valor en el form
			); ?>
			<?= form_label('Quorum','quorum'); ?>
			<!-- Igual a: <label for="titulo">Titulo</label> -->
			<?= form_input($atributos) ?> <br/><br/>
		</div>
			<?php
			 $atributos = array(
					'NumOpciones' => $votaciones->NumOpciones
			); ?>
  		<?= form_hidden($atributos) ?> <br/><br/>


		<div class="form-check">
		<?php	if(isset($pulsadoModificar) && $pulsadoModificar == true) $check = 'checked';
			else{$check = false;} ?>
		<?php
		$atributos = array(
			'name' => 'esModificable',
			'class' => 'form-check-input',
			'type' => 'checkbox',
			'id' => 'esModificable',
			'value' => true,
			'checked' => $check
		);
		?>
		<?= form_checkbox($atributos); ?>
		<?= form_label('Voto Modificable','esModificable'); ?>
		</div>
		 <div class="form-check">
			 <?php	if(isset($pulsadoAsistentes) && $pulsadoAsistentes == true) $checkAs = 'checked';
	 			else{$checkAs = false;} ?>
		<?php
		$atributos = array(
			'name' => 'soloAsistentes',
			'class' => 'form-check-input',
			'type' => 'checkbox',
			'id' => 'soloAsistentes',
			'value' => true,
			'checked' => $checkAs
		);
		?>
		<?= form_checkbox($atributos); ?>
		<?= form_label('Solo asistentes','soloAsistentes'); ?>
		</div>

	<!-- CENSO ELECTORAL -->
		<h2> Censo electoral </h2>
		<p> Escoja el censo electoral que desee </p>
		<!-- TABLA DE CENSO -->
		<div class = "container">
		  <div class="table-wrapper-scroll-y my-custom-scrollbar">
		 	  <table class="display table table-striped table-bordered" id="votaciones_admin">
		      <thead>
		        <tr>
		          <th><center>Censo<center></th>
		          <th><center>Añadir<center></th>
							<th><center>Eliminar<center></th>
		        </tr>
		      </thead>
		      <tbody>
		        <tr>
								<!-- COMRPROBAR CENSOS QUE YA EXISTEN-->
							<?php $iguales = array(); ?>
							<?php foreach($censos as $censo)
							  {
								  for($i = 0; $i < sizeof($censosVotacion); $i++)
									{
										if($censo->Id == $censosVotacion[$i]->Id_Fichero)
										{$iguales[] = $censosVotacion[$i]->Id_Fichero;}
									}
								}
							?>
							<!-- BUCLE CON NOMBRES DE CENSOS -->
		        <?php foreach($censos as $censo){ ?>
                <td><?php echo $censo->Nombre?></td>
								<!-- COMRPROBAR CENSOS QUE YA EXISTEN-->
								<?php
								$encontrado = false;
								$i = 0;
								while($i < sizeof($iguales) && !$encontrado)
								{
									if($censo->Id == $iguales[$i])
									{$encontrado = true;}
									$i = $i + 1;
								}
								if(isset($_POST['censo']) && in_array($censo->Nombre, $_POST['censo'])) $checkCenso = 'checked';
								else{$checkCenso = false;}
								if(!$encontrado)
								{
									echo '<div class="form-check">';
								$atributos = array(
											'name' => 'censo[]',
											'class' => 'form-control',
											'type' => 'checkbox',
											'id' => $censo->Nombre,
											'value' => $censo->Nombre,
											'checked' => $checkCenso
									);
									echo '<td>'.form_checkbox($atributos).'</td>';
								}
								else // Se puede eliminar el censo
								{
									if(sizeof($censosVotacion) > 1)
									{
										echo '<td></td>';
										echo '<div class="form-check">';
									$atributos = array(
												'name' => 'censoEliminacion[]',
												'class' => 'form-control',
												'type' => 'checkbox',
												'id' => 'censo',
												'value' => $censo->Nombre
										);
										echo '<td>'.form_checkbox($atributos).'</td>';
									}
								}

								?>
							 </div>
								<?php echo '</tr>'; ?>
		        <?php }?>
		      </tbody>
		    </table>
		  </div>
	 </div>

	 <!-- CENSO ASISTENTE -->
	 <?php
	 if(isset($asistentes) && $asistentes != NULL && isset($idsAsistentes)){?>
		 <h2> Censo asistente </h2>
			 <div class = "container">
				 <div class="table-wrapper-scroll-y my-custom-scrollbar">
				 <table class="display table table-striped table-bordered" id="votaciones_admin">
					 <thead>
						 <tr>
							 <th>Asistentes</th>
							 <th></th>
						 </tr>
					 </thead>
					 <tbody>
						 <tr>
							 <?php
							 $i = 0;
							 foreach($asistentes as $asistente)
							 {?>
							 <td><?php echo $asistente?></td>
							 <?php
								 echo '<div class="form-check">';
									$atributos = array(
										 'name' => 'asistentes[]',
										 'class' => 'form-control',
										 'type' => 'checkbox',
										 'id' => 'censo',
										 'checked' => true,
										 'value' => $idsAsistentes[$i]
								 );
								 $i++;
								 ?>
							 <td><?= form_checkbox($atributos); ?></td>
						 </div>
						 <?php echo '</tr>'; ?>
				 <?php } ?>
			 </tbody>
		 </table>
	 </div>
	 </div>
 <?php } ?>
					 <?php $atributos = array(
							 'name' => 'boton_borrador',
							 'class' => 'btn btn-primary',
							 'type' => 'submit',
							 'value' => 'Guardar en borrador'
					 ); ?>

				 <?= form_submit($atributos);?>

			 <?php $atributos = array(
					 'name' => 'boton_publicar',
					 'class' => 'btn btn-primary',
					 'type' => 'submit',
					 'value' => 'Publicar'
			 ); ?>
			  <?= form_submit($atributos);?>
	<?= form_close(); ?>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>/assets/js/jquerySlim.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>


    <!-- DATETIME PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/behaviour/datepicker.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
      <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datetimepicker.min.js"></script>
    <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>-->

</body>
</html>
