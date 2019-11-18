<!doctype html>
<html lang="en">
  <body>

    <br><br><br><br><br>
    <form action="<?= base_url().'Elector_controller/guardarVoto/'.$id_votacion.'/'?>" method="post">
      <center>
        <div class="btn-group" data-toggle="buttons">
          <?php foreach($votos as $voto) { ?>
            <label class="btn btn-primary">
              <input type="radio" name="voto" autocomplete="off" value="<?php echo $voto->Nombre?>"> <?php echo $voto->Nombre ?>
            </label>
          <?php } ?>
        </div>
        <br>
        <input class="btn btn-primary" type="submit" value="Votar">
      </center>
    </form>

</body>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>/assets/js/jquerySlim.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

    <!-- Scripts para la tabla de votaciones -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
   <script src="<?php echo base_url()."assets/js/behaviour/tabla_secretario.js"?>"></script>

    <!-- DATE PICKER -->
    <script src="<?php echo base_url(); ?>/assets/js/bootstrap-datepicker.js"></script>

</html>
