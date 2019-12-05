<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Panel de administración - Gestionar roles</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/admin_css.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/behaviour/footer.css" rel="stylesheet">
  </head>

<body>

    <div class="container">
        <?php
        
        if(isset($Id_Votacion))
        {
            echo '
            <p>Votaciones disponibles: </p>

            <form action="asignaVotaciones">';
                $cont = 0;
                foreach($Id_Votacion as $votation)
                {
                    echo'
                        <div>
                            <label for="votacion'.$Id_Votacion.'">'.$Titulo[cont].'</label>
                            <input type="checkbox" id="votacion'.$Id_Votacion.'" name="votacion'.$Id_Votacion.'">
                        </div>
                    ';
                    $cont = $cont + 1;
                }
            echo'
            <div>
                <input type="submit" class="btn btn-primary" name="Enviar" value="Enviar">
            </div>
            </form>
            ';
        }else
        {
            echo '<p>No hay votaciones disponibles</p>';
        }
        ?>
    </div>


 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>


</html>
