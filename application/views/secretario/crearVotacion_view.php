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
    <?=form_open(base_url().'secretario/insertarVotacion/');?>
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
            <?php
        		 $atributos = array(
        				'Id_TipoVotacion' => $tipoVotacion
        		); ?>
        		<?= form_hidden($atributos) ?> <br/><br/>
             <div class="form-group">
               <?php
                $atributos = array(
                   'name' => 'titulo',
                   'class' => 'form-control',
                   'id' => 'titulo',
                   'placeholder' =>'Escribe un titulo',
                   'required' => true,
                   'autocomplete' => 'off',
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
                   'autocomplete' => 'off',
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
              'autocomplete' => 'off',
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
              'autocomplete' => 'off',
              'value' => set_value('fecha_final')
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
              'autocomplete' => 'off',
              'value' => set_value('quorum') // Mantiene el valor en el form
          ); ?>
          <?= form_label('Quorum','quorum'); ?>
          <!-- Igual a: <label for="titulo">Titulo</label> -->
          <?= form_input($atributos) ?> <br/><br/>
        </div>

        <!-- PONDERACIONES -->
        <?php if(isset($permitirPonderaciones) && $permitirPonderaciones == true){?>
          <h2> Ponderaciones </h2>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <?php
                 $atributos = array(
                    'name' => 'ponderacionPAS',
                    'class' => 'form-control',
                    'id' => 'pondPas',
                    'placeholder' =>'Escribe un la ponderacion para el grupo PAS',
                    'required' => true,
                    'autocomplete' => 'off',
                    'value' => set_value('pondPas') // Mantiene el valor en el form
                ); ?>
                <?= form_label('Ponderacion PAS','ponderacionPAS'); ?>
                <?= form_input($atributos) ?> <br/><br/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <?php
                 $atributos = array(
                    'name' => 'ponderacionAlumnos',
                    'class' => 'form-control',
                    'id' => 'pondAlumnos',
                    'placeholder' =>'Escribe un la ponderacion para el grupo Alumnos',
                    'required' => true,
                    'autocomplete' => 'off',
                    'value' => set_value('pondAlumnos') // Mantiene el valor en el form
                ); ?>
                <?= form_label('Ponderacion Alumnos','ponderacionAlumnos'); ?>
                <!-- Igual a: <label for="titulo">Titulo</label> -->
                <?= form_input($atributos) ?> <br/><br/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <?php
                 $atributos = array(
                    'name' => 'ponderacionProfesores',
                    'class' => 'form-control',
                    'id' => 'pondProfesores',
                    'placeholder' =>'Escribe un la ponderacion para el grupo Profesores',
                    'required' => true,
                    'autocomplete' => 'off',
                    'value' => set_value('pondProfesores') // Mantiene el valor en el form
                ); ?>
                <?= form_label('Ponderacion Profesores','ponderacionProfesores'); ?>
                <!-- Igual a: <label for="titulo">Titulo</label> -->
                <?= form_input($atributos) ?> <br/><br/>
              </div>
            </div>
          </div>
        <?php } ?>

        <?php if(isset($permitirOpciones) && $permitirOpciones == true){ ?>
          <h2> Opciones </h2>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
            <?php $atributos = array(
                'id' => 'nOpciones',
                'name' => 'nOpciones',
                'class' => 'form-control',
                'placeholder' =>'Introduzca un número de opciones que podrá votar un usuario en total',
                'required' => true,
                'autocomplete' => 'off',
                'value' => set_value('nOpciones')
            ); ?>
            <?= form_label('Total de opciones a votar','nOpciones'); ?>
            <?= form_input($atributos) ?> <br/><br/>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
            <?php
            $totales = array();
             $atributos = array(
                'id' => 'opciones',
                'name' => 'opciones',
                'class' => 'form-control',
                'placeholder' =>'Introduzca las opciones posibles',
                'required' => true,
                'autocomplete' => 'off',
                'value' => set_value('opciones')
              ); ?>
            <strong><h2><?= form_label('Opciones disponibles','opciones'); ?></h2></strong>
            <p> Separe cada opción por una coma </p>
            <?= form_input($atributos) ?> <br/><br/>
            </div>
            </div>
          </div>

        <?php } ?>

        <!-- CHECK BUTTONS -->
        <div class="form-check">
          <?php
           if(isset($_POST['esModificable'])) $check = 'checked';
           else{$check = false;}
          ?>
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

    <?php if(isset($permitirAsistentes) && $permitirAsistentes == true){?>
      <div class="form-check">
        <?php
         if(isset($_POST['soloAsistentes'])) $checkAsis = 'checked';
         else{$checkAsis = false;}
        ?>
        <?php
        $atributos = array(
          'name' => 'soloAsistentes',
          'class' => 'form-check-input',
          'type' => 'checkbox',
          'id' => 'soloAsistentes',
          'value' => true,
          'checked' => $checkAsis
        );
        ?>
        <?= form_checkbox($atributos); ?>
        <?= form_label('Solo asistentes','soloAsistentes'); ?>
      </div>
    <?php } ?>

    <?php if(isset($permitirRecuento) && $permitirRecuento == true){ ?>
      <div class="form-check">
      <?php
      $atributos = array(
        'name' => 'recuentoParalelo',
        'class' => 'form-check-input',
        'type' => 'checkbox',
        'id' => 'recuentoParalelo',
        'value' => true
      );
      ?>
      <?= form_checkbox($atributos); ?>
      <?= form_label('Recuento Paralelo','recuentoParalelo'); ?>
    </div>


    <?php } ?>
    <?php if(isset($censos)){?>
        <h2> Censo electoral </h2>
        <p> Escoja el censo electoral que desee </p>
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
                 if(isset($_POST['censo']) && in_array($censo->Nombre, $_POST['censo'])) $checkCenso = 'checked';
                 else{$checkCenso = false;}
                ?>
              <?php
                echo '<div class="form-check">';
                 $atributos = array(
                    'name' => 'censo[]',
                    'class' => 'form-control',
                    'type' => 'checkbox',
                    'id' => 'censo',
                    'value' => $censo->Nombre,
                    'checked' => $checkCenso
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

    <?php }?>
    <?php
    if(isset($asistentes) && $asistentes != NULL){?>
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
                foreach($asistentes as $asistente)
                {?>
                <td><?php echo $asistente[0]->NombreUsuario?></td>
                <?php
                  echo '<div class="form-check">';
                   $atributos = array(
                      'name' => 'asistentes[]',
                      'class' => 'form-control',
                      'type' => 'checkbox',
                      'id' => 'censo',
                      'value' => $asistente[0]->Id
                  );
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

      <!-- BOTÓN ENVIAR -->
        <?php $atributos = array(
            'name' => 'submit_reg',
            'class' => 'btn btn-primary',
            'type' => 'submit',
            'value' => 'Enviar'
        ); ?>
        <?= form_submit($atributos);?>

        <br/>
        <?php $atributos = array(
            'name' => 'boton_borrador',
            'class' => 'btn btn-primary',
            'type' => 'submit',
            'value' => 'Guardar en borrador'
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
