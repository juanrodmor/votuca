<html>
<title>Votaciones</title>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css"/>
    

    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/css/behaviour/votacion_view.css" ?>"/>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Votaciones</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" style="cursor:pointer;" onclick="about()">About us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="cursor:pointer;" onclick="contact()">Contact us</a>
      </li>

    </ul>
    <a class="nav-link" style="color:#000000;" href="<?= base_url().'login_controller/logout'?>">Cerrar sesión</a>
    <form class="form-inline my-2 my-lg-0">
      <span><b>Votuca&nbsp;&nbsp;&nbsp;</b></span>
      <i class="fas fa-vote-yea fa-2x"></i>
    </form>
  </div>


</nav>

<div id="datatable_votaciones" style="margin-top:1%;margin-left:2%;width:96%;align: center;">
    <table id="votaciones_usuario" class="display table table-striped table-bordered" style="width:90%;">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha inicio</th>
                <th>Fecha Fin</th>
                <th>Votado</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach($datos as $objeto) {?>
                <tr>
                    <td><?php echo $objeto->Titulo;?></td>
                    <td><?php echo $objeto->Descripcion;?></td>
                    <td><?php echo $objeto->FechaInicio;?></td>
                    <td><?php echo $objeto->FechaFinal;?></td>
                    <td><?php echo $objeto->Nombre;?></td>
                </tr>
            <?php }?>

        </tbody>
        <tfoot>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Fecha inicio</th>
                <th>Fecha Fin</th>
                <th>Votado</th>
            </tr>
        </tfoot>
    </table>
</div>
<div id="modal-content">
</div>
</body>
<footer>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js">"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
    <script src="https://kit.fontawesome.com/95fa71eb53.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="<?php echo base_url()."assets/js/behaviour/votacion_elector.js"?>"></script>
</footer>
</html>