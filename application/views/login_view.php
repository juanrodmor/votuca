<!DOCTYPE html>
<html>

<head>
    <title> Login - VotUCA </title>

    <link hred="<?php echo base_url('assets/css/main.css')?>" rel="stylesheet" type="text/css">
    <style> @import url(<?php echo base_url('assets/css/main.css')?>); </style>
    <!-- Bootstrap core CSS -->
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

            <div id="container-data">

                <?php 

                    echo form_error('usuario', '<div class="alert alert-danger" role="alert">', '</div>');
                    echo form_error('pass', '<div class="alert alert-danger" role="alert">', '</div>');            

                    if(isset($mensaje)) 
                    {
                        echo '<div class="alert alert-danger" role="alert">' . $mensaje . '</div>'; 
                    }
                ?>
                
                <form id="login-form" class="form-horizontal" action="<?php echo base_url('login_controller/verificar')?>" method="post">
                    <div class="form-group">
                        <label for="username">Nombre de usuario: </label><input name="usuario" type="text" class="form-control" id="u">
                    </div>
                        <br>
                    <div class="form-group">    
                        <label for="pass">Contraseña: </label><input name="pass" type="password" class="form-control" id="passwd">
                    </div>

                    <input id="button-form" class="btn btn-default" type="submit" name="Enviar" value="Enviar">

                </form>

            </div>
            
        </div>



</body>
</html>