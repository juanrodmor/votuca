<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CREAR VOTACIÓN</title>
    <!-- Bootstrap core CSS -->

    <!--<link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">

    <!-- DATETIME PICKER -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/bootstrap-datetimepicker.min.css">
  </head>

  <body>

  <br><br>
<div class="container">
  <div class ="mensaje">
    <h3><?=   validation_errors();  ?></h3>
    <?php if(isset($mensaje)): ?>
          <br/><h1><?= $mensaje ?></h1><br/>

      <?php endif; ?>

  </div>
  <!-- FORMULARIO DE VOTACION -->
    <?=form_open(base_url().'secretario/insertarVotacion',
    		    array('name'=>'crearVotacion'));?>
            <!-- ESPERAR A SABER CÓMO COMPROBAR QUE UNA VOTACION NO EXISTE YA -->
            <!--<div class="form-group">
              <?php $atributos = array(
                  'name' => 'id',
                  'class' => 'form-control',
                  'id' => 'id',
                  'required' => true,
              ); ?>
              <?= form_label('ID','id'); ?>
              <?= form_input($atributos) ?> <br/><br/>
            </div>-->

             <div class="form-group">
               <?php
                $atributos = array(
                   'name' => 'titulo',
                   'class' => 'form-control',
                   'id' => 'titulo',
                   'placeholder' =>'Escribe un titulo',
                   'required' => true,
                   'value' => set_value('titulo') // Mantiene el valor en el form
               ); ?>
               <?= form_label('Titulo','titulo'); ?>
               <!-- Igual a: <label for="titulo">Titulo</label> -->
               <?= form_input($atributos) ?> <br/><br/>
             </div>

             <div class="form-group">
               <?php $atributos = array(
                   'name' => 'descripcion',
                   'class' => 'form-control',
                   'placeholder' =>'Escribe una descripción del evento',
                   'id' => 'descripcion',
                   'required' => true,
                   'value' => set_value('descripcion')
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
              'required' => true,
              'value' => set_value('fecha_inicio')
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
              'value' => set_value('fecha_final')
          ); ?>
          <?= form_label('Fecha Final','fecha_final'); ?>
          <?= form_input($atributos) ?> <br/><br/>
            </div>
          </div>
        </div>

        <h2> Censo electoral </h2>
        <p> Escoja el censo electoral que desee </p>
        <!-- TABLA DE CENSO -->
        <div class = "container">
          <div class="table-wrapper-scroll-y my-custom-scrollbar">
          <table class="display table table-striped table-bordered" id="votaciones_admin">
            <thead>
              <tr>
                <th>Censo</th>
                <th></th>
              </tr>
            </thead>
          <tbody>
            <tr>
              <?php foreach($censos as $censo){ ?>

                <td><?php echo $censo->Nombre?></td>
                <?php
                echo '<div class="form-check">';
                 $atributos = array(
                    'name' => 'censo[]',
                    'class' => 'form-control',
                    'type' => 'checkbox',
                    'id' => 'censo',
                    'value' => $censo->Nombre
                );
                ?>
              <td><?= form_checkbox($atributos); ?></td>
            </div>
            <?php echo '</tr>'; ?>
            <?php }?>
          </tbody>
        </table>
      </div>
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


    <!-- DATETIME PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/behaviour/datepicker.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
      <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datetimepicker.min.js"></script>
    <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>-->

  </body>
</html>
