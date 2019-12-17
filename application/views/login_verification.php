<!doctype html>
<html>

<head>
    <title>VotUCA</title>
    <meta charset="UTF-8">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/login_css.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


</head>
<body>
  <header>
    <nav class="navbar">
      <a class="navbar-brand" href="#">
        <img src="<?php echo base_url('assets/img/logo_name.png')?>">
      </a>
    </nav>
  </header>

  <div class="container navbar-default">

    <!--Display error messages-->
    <div id="container-data">

    <div id="titleBox">
        <h2>Acceso privado</h2>
    </div>

    <div id="form-info">
		Es necesario verificar su identidad. Introduzca la clave generada por Google Authenticator 
		<?php
			if(isset($QR))
				echo ' escaneando el código QR inferior o introduciendo el código que se muestra.';
			else
				echo ' que obtuvo al vincular su APP con VotUCA anteriormente.';
		?>
    </div>
                <?php

                    if(isset($mensaje))
                    {
                        echo '<div class="alert alert-danger" id="alerts" role="alert">' . $mensaje . '</div>';
                    }
                
					if(isset($QR))
						{
							echo '<div id="qr"><img src='.$QR.'></div>';
						}

					if(isset($secret))
					{
						echo '<div id="secret-key-show">'.$secret.'</div>';
					}

				?>
                <!--Display form-->
                <form id="login-form" class="form-horizontal" action="<?php echo base_url() . 'login_controller/pass_auth';?>" method="post">
                    <div class="input-group mb-3" id="input-key">
                        <label id="labelUser" for="username" class="col-xs-5 col-form-label text-right">Clave</label>
                        <input name="key" type="text" class="form-control col-sm-5 col-xs-7" id="u" placeholder="Clave">
                    </div>
                    <input id="button-form" class="btn btn-primary" type="submit" name="enviar" value="Enviar">
                </form>
				<button id="button-form-back" class="btn btn-primary" onclick="location='<?= base_url().'login_controller/logout'?>'">Atrás</button>
	

            <div id="lock-image">
                <img src="<?php echo base_url('assets/img/lock.png')?>">               
            </div>

    </div>

</div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
