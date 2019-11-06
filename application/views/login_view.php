<!DOCTYPE html>
<html>

<head>
    <title> Login - VotUCA </title>

    <link hred="assets/css/main.css" rel="stylesheet" type="text/css">
    <style> @import url('assets/css/main.css'); </style>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>

        <div class="container navbar-default">
                
        <div id=logo>
            <a class="center" href="#"><img src="assets/img/logo_uca.png"></a>
        </div>       
            <br><br>
        <form class="form-horizontal" action="<?php echo base_url('login_controller/verificar')?>" method="POST">
            <div class="form-group">
                <label for="username">Nombre de usuario: </label><input name="usuario" type="text" class="form-control">
            </div>
                <br>
            <div class="form-group">    
                <label for="pass">Contraseña: </label><input name="pass" type="password" class="form-control">
            </div>

            <input id="button-form" class="btn btn-default" type="submit" name="Enviar" value="Enviar">

        </form>

            
        </div>



</body>


</html>