<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Lista de votaciones</title>
	<!-- Bootstrap core CSS -->
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
	            <a class="nav-link" href="<?= base_url().'administracion/'?>">Link</a>
	          </li>
	          <li class="nav-item dropdown">
	            <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Votaciones</a>
	            <div class="dropdown-menu" aria-labelledby="dropdown01">
	              <a class="dropdown-item" href="<?= base_url().'administracion/crearVotacion'?>">Crear</a>
	              <a class="dropdown-item" href="<?= base_url().'modificarVotacion/'?>">Modificar</a>
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
							<center><h1>Modificar Votacion</h1></center>
					</div>
				</div>
			</main><!-- /.container -->

<div class="row">
    <div style="width:500px;margin:50px;">
        <h4>Tabla votaciones</h4>
        <table class="table table-striped table-bordered">
            <tr>
                <td><strong>ID</strong></td>
                <td><strong>TITULO</strong></td>
                <td><strong>DESCRIPCION</strong></td>
                <td><strong>FECHA INICIO</strong></td>
                <td><strong>FECHA FIN</strong></td>
            </tr>
            <?php foreach($VOTACIONES as $votacion){?>
                <tr>
                    <td>
                        <?=$votacion['Id'];?>
                    </td>
                    <td>
                        <?=$votacion['Titulo'];?>
                    </td>
                    <td>
                        <?=$votacion['Descripcion'];?>
                    </td>
                    <td>
                        <?=$votacion['FechaInicio'];?>
                    </td>
                    <td>
                        <?=$votacion['FechaFinal']?>
                    </td>
                </tr>
                <?php }?>
        </table>
    </div>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>/assets/js/jquerySlim.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

</body>
</html>
