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
    <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
  </head>

  <body>
<br><br><br><br>
  <div class="container">
    <form action="<?php base_url().'administrador_controller/monitoring' ?>" id="monitoring_search" method='post'>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="checkLogin" name="cLogin" value="true" checked>
          <label class="form-check-label" for="checkLogin">Login</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="checkLogout" name="cLogout" value="true" checked>
          <label class="form-check-label" for="checkLogout">Logout</label>
        </div>
        <!--- DE MOMENTO VIOLARIA LA PRIVACIDAD -->
        <!--<div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="checkVotos" name="cVote" value="true" checked>
          <label class="form-check-label" for="checkVotos">Votos</label>
        </div>-->

        <div class="form-check form-check-inline">
          <input class="btn btn-primary" type="submit" name="Filtrar" value="Consultar">
        </div>
      </form>


    <div class="card" id="card_monitoringView">
        <div class="card-body" style="text-align: left;">
          <?php
          if(isset($loginfo))
          {
            foreach($loginfo as $string)
            {
              echo $string . ' <br> ';
            }
          }
          ?>
        </div>
    </div>


  </div>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function(){
        $("#checkLogin").click(function(){
            if($(this).val() == 'true')
            {
              $(this).val('false');
            }
            else
            {
              $(this).val('true');
            }
        });

        $("#checkLogout").click(function(){
            if($(this).val() == 'true')
            {
              $(this).val('false');
            }
            else
            {
              $(this).val('true');
            }
        });

        $("#checkVotos").click(function(){
            if($(this).val() == 'true')
            {
              $(this).val('false');
            }
            else
            {
              $(this).val('true');
            }
        });
      });

    </script>

  </body>


</html>
