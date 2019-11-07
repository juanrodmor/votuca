<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Administracion</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url().'inicio/'?>">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Votaciones</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="#">Crear</a>
              <a class="dropdown-item" href="#">Modificar</a>
              <a class="dropdown-item" href="#">Eliminar</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>

    <main role="main" class="container">
      <div class="jumbotron">
        <div class="container">
            <center><h1>Administracion</h1></center>
        </div>
      </div>
    </main><!-- /.container -->

  <!-- IMPRIME SI SE HA GUARDADO BIEN -->
    <?php if(isset($mensaje)): ?>
          <h2><?= $mensaje ?></h2>
      <?php endif; ?>
      <h3><?= validation_errors();?></h3>



  <!-- FORMULARIO DE VOTACION -->
    <section>
    <?=form_open(base_url().'administracion/crearVotacion',
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
               <?php $atributos = array(
                   'name' => 'titulo',
                   'class' => 'form-control',
                   'id' => 'titulo',
                   'required' => true,
               ); ?>
               <?= form_label('Titulo','titulo'); ?>
               <!-- Igual a: <label for="titulo">Titulo</label> -->
               <?= form_input($atributos) ?> <br/><br/>
             </div>

             <div class="form-group">
               <?php $atributos = array(
                   'name' => 'descripcion',
                   'class' => 'form-control',
                   'id' => 'descripcion',
                   'required' => true,
               ); ?>
               <?= form_label('Descripcion','descripcion'); ?>
               <?= form_textarea($atributos) ?> <br/><br/>
             </div>

        <div class="form-group">
          <?php $atributos = array(
              'name' => 'fecha_inicio',
              'class' => 'form-control',
              'data-provide' => 'datepicker',
              'id' => 'fecha_inicio',
              'required' => true

          ); ?>
          <?= form_label('Fecha Inicio','fecha_inicio'); ?>
          <?= form_input($atributos) ?> <br/><br/>
        </div>

        <div class="form-group">
          <?php $atributos = array(
              'name' => 'fecha_final',
              'class' => 'form-control',
              'data-provide' => 'datepicker',
              'id' => 'fecha_final',
              'required' => true
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
        <?= form_submit($atributos);?>
      <?= form_close(); ?>
    </section>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>/assets/js/jquerySlim.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.js"></script>


  </body>
</html>
