<!DOCTYPE html>
<html>

<head>
    <title> Selección de rol - VotUCA </title>
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

                <div class="alert alert-info" role="alert">Antes de continuar, seleccione el rol con el que desea acceder al sistema.</div>

                <div class="inputs">
                <?php
                    if(isset($roles))
                    {
                        foreach($roles as $rol)
                        {
                            echo
                            '
                            <form id="chooseRole" class="input-group" method="post" action="">
                                <span class="input-group-addon">
                                    <input type="radio" name="radio'.$rol.'" value="'.$rol.'">
                                </span>
                                <input type="text" class="form-control" value="' . $rol . '"disabled>
                            </form><!-- /input-group -->
                             <br>';
                        }
                    }
                ?>
                </div>
            </div>
            
        </div>

         <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
    <script>
      $(document).ready(function(){
        $("#chooseRole").on("change", "input:radio", function()
        {
          $("#chooseRole").submit();
        });
      });
    </script>


</body>
</html>