<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Panel de administración - Auditorías</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style> @import url(<?php echo base_url('assets/css/admin_css.css')?>); </style>

  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">VotUCA</a>

      <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
          <a class="nav-link" href="<?= base_url().'administracion/index'?>">Gestionar roles</a>
          <a class="nav-link active" href="#">Auditoría</a>
        </ul>
        <a class="nav-link text-success" href="<?= base_url().'login_controller/logout'?>">Cerrar sesión</a>
      </div>

    </nav>

  <div class="container">
  
    <div class="jumbotron">
        <center><h1>Administración</h1></center>
        <center><h3>Auditoría</h3></center>
    </div>

    <form action="" id="monitoring_search">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="checkLogin" name="checkLogin" value="option1" checked>
          <label class="form-check-label" for="checkLogin">Login</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="checkLogout" name="checkLogout" value="option2" checked>
          <label class="form-check-label" for="checkLogout">Logout</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="checkVotos" name="checkVotos" value="option3" disabled>
          <label class="form-check-label" for="checkVotos">Votos</label>
        </div>

        <div class="form-check form-check-inline">
          <input class="btn btn-primary" type="submit" value="Consultar">
        </div>
      </form>


    <div class="card">
        <div class="card-body">Hola</div>
    </div>


  </div>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  


  </body>
  

</html>
