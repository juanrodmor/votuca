<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mesa Electoral</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
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
  							<a class="nav-link" href="<?= base_url().'MesaElectoral/'?>">Inicio <span class="sr-only">(current)</span></a>
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
            <center><h1>Mesa Electoral</h1></center>
      </div>
    </main>

    <?php if(isset($mensaje)): ?>
          <h2><?= $mensaje ?></h2>
      <?php endif; ?>

  <div class = "container">
    <table class="display table table-striped table-bordered">
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
         <?php foreach($votacion as $objeto){?>
      <tr>
        <td scope="row" class="table-danger"><?php echo $objeto->Id;?></td>
        <td><?php echo $objeto->Titulo;?></td>
        <td><?php echo $objeto->Descripcion;?></td>
        <td><?php echo $objeto->FechaInicio;?></td>
        <td><?php echo $objeto->FechaFinal;?></td>
        <?=form_open(base_url().'MesaElectoral/recuentoVotos');?>
               <?php
               $atributos = array(
                  'recuento' => $objeto->Id

              );
               ?>
         <?= form_hidden($atributos);?>
         <?php $atributos = array(
             'name' => 'boton_recuento',
             'class' => 'btn btn-primary',
             'type' => 'submit',
             'value' => 'Recuento'
         ); ?>
         <td><?= form_submit($atributos);?></td>
         <?= form_close(); ?>
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
          <h4 class="title">Sumi</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin suscipit, libero a molestie consectetur, sapien elit lacinia mi.</p>
          <ul class="social-icon">
          <a href="#" class="social"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          <a href="#" class="social"><i class="fa fa-twitter" aria-hidden="true"></i></a>
          <a href="#" class="social"><i class="fa fa-instagram" aria-hidden="true"></i></a>
          <a href="#" class="social"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
          <a href="#" class="social"><i class="fa fa-google" aria-hidden="true"></i></a>
          <a href="#" class="social"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
          </ul>
          </div>
      <div class="col-sm-3">
          <h4 class="title">My Account</h4>
          <span class="acount-icon">
          <a href="#"><i class="fa fa-heart" aria-hidden="true"></i> Wish List</a>
          <a href="#"><i class="fa fa-cart-plus" aria-hidden="true"></i> Cart</a>
          <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
          <a href="#"><i class="fa fa-globe" aria-hidden="true"></i> Language</a>
        </span>
          </div>
      <div class="col-sm-3">
          <h4 class="title">Category</h4>
          <div class="category">
          <a href="#">men</a>
          <a href="#">women</a>
          <a href="#">boy</a>
          <a href="#">girl</a>
          <a href="#">bag</a>
          <a href="#">teshart</a>
          <a href="#">top</a>
          <a href="#">shos</a>
          <a href="#">glass</a>
          <a href="#">kit</a>
          <a href="#">baby dress</a>
          <a href="#">kurti</a>
          </div>
          </div>
      <div class="col-sm-3">
          <h4 class="title">Payment Methods</h4>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
          <ul class="payment">
          <li><a href="#"><i class="fa fa-cc-amex" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-credit-card" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-paypal" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-cc-visa" aria-hidden="true"></i></a></li>
          </ul>
          </div>
      </div>
      <hr>

      <div class="row text-center"> © 2019. Hecho por grupo 5 pinf.</div>
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
