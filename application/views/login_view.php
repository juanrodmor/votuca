<!DOCTYPE html>
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
        Indique su identificador y clave única de acceso a servicios (Campus virtual, servicios de personal, CAU...).
    </div>
                <?php

                    echo form_error('usuario', '<div class="alert alert-danger" id="alerts" role="alert">', '</div>');
                    echo form_error('pass', '<div class="alert alert-danger" id="alerts" role="alert">', '</div>');

                    if(isset($mensaje))
                    {
                        echo '<div class="alert alert-danger" id="alerts" role="alert">' . $mensaje . '</div>';
                    }
                ?>

                <!--Display form-->
                <form id="login-form" class="form-horizontal" action="<?php echo base_url('login_controller/verificar')?>" method="post">
                    <div class="input-group mb-3">
                        <label id="labelUser" for="username" class="col-xs-5 col-form-label text-right">Nombre de usuario</label>
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="usuario" type="text" class="form-control col-sm-5 col-xs-7" id="u" placeholder="Nombre de usuario">
                    </div>
                    <div class="input-group mb-3">
                        <label id="labelPass" for="pass" class="col-xs-5 col-form-label text-right">Clave de acceso</label>
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input name="pass" type="password" class="form-control col-sm-5 col-xs-7" id="passwd" placeholder ="Clave de acceso">
                    </div>
                    <input id="button-form" class="btn btn-primary" type="submit" name="Enviar" value="Enviar">
                </form>

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
