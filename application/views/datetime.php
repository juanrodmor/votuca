<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>CREACION VOTACIONES</title>
  <!-- Bootstrap core CSS -->

  <!--<link href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" rel="stylesheet">-->
  <link href="<?php echo base_url(); ?>/assets/css/prueba.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/css/behaviour/footer.css" rel="stylesheet">

  <!-- DATETIME PICKER -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
</head>

<body>
  <br><br><br><br><br><br><br><br><br><br>
  <div class="container">
    <div class="container">
      <div class="row">
          <div class="col-sm-6">
              <input type="text" class="form-control datetimepicker-input" id="datetimepicker5" data-toggle="datetimepicker" data-target="#datetimepicker5"/>
          </div>
          <script type="text/javascript">
              $(function () {
                  $('#datetimepicker5').datetimepicker();
              });
          </script>
      </div>
  </div>
  </div>


  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

  <!-- DATETIME PICKER -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

</body>

</html>
