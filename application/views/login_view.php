<!DOCTYPE html>
<html>

<head>
    <title> Login - VotUCA </title>
    <meta charset="UTF-8">

    <style> @import url(<?php echo base_url('assets/css/login_css.css')?>); </style>

    <!-- Bootstrap and JQUERY resources -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script  src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>





        <div class="container navbar-default">

        <div id=logo>
            <a class="center" href="#"><img src="<?php echo base_url('assets/img/logo_uca.png')?>"></a>
        </div>
            <br><br>

            <!--Display error messages-->
            <div id="container-data">
                <?php

                    echo form_error('usuario', '<div class="alert alert-danger" role="alert">', '</div>');
                    echo form_error('pass', '<div class="alert alert-danger" role="alert">', '</div>');

                    if(isset($mensaje))
                    {
                        echo '<div class="alert alert-danger" role="alert">' . $mensaje . '</div>';
                    }
                ?>

                <!--Display form-->
                <form id="login-form" class="form-horizontal" action="<?php echo base_url('login_controller/verificar')?>" method="post">
                    <label for="username">Nombre de usuario: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="usuario" type="text" class="form-control" id="u" placeholder="Nombre de usuario">
                    </div>
                        <br>
                    <label for="pass">Contraseña: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input name="pass" type="password" class="form-control" id="passwd" placeholder ="Contraseña">
                    </div>
                    <br>
                    <input id="button-form" class="btn btn-primary" type="submit" name="Enviar" value="Enviar">
                </form>

            </div>

        </div>

</body>
</html>
