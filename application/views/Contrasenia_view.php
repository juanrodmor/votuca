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
        Actualmente intenta acceder a una cuenta cuya contraseña proporcionada en el sistema es temporal. A continuación, configure una nueva contraseña para su perfil.
    </div>
 
                <!--Display form-->
                <form id="login-form" class="form-horizontal" action="<?php echo base_url('login_controller/setPass')?>" method="post">
                    <div class="input-group mb-3">
                        <label id="labelPass" for="pass" class="col-xs-5 col-form-label text-right">Clave de acceso</label>
                        <input name="pass" type="password" class="form-control col-sm-5 col-xs-7" id="passwd" placeholder="Clave de acceso">
                    </div>
                    <div class="input-group mb-3">
                        <label id="labelRepeatPass" for="repeatPass" class="col-xs-5 col-form-label text-right">Repita su clave</label>
                        <input name="repeatPass" type="password" class="form-control col-sm-5 col-xs-7" id="repeatPasswd" placeholder ="Clave de acceso">
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

        <script>

            $(document).ready(function(){
                $("#passwd").keyup(validateFormat);
                $("#passwd").keyup(validateEqual);
                $("#repeatPasswd").keyup(validateEqual);
                $("#passwd").keyup(activate);
                $("#repeatPasswd").keyup(activate);
            });

            function activate()
            {
                var obj1 = $("#passwd").attr('class');
                var obj2 = $("#repeatPasswd").attr('class');

                if(obj1 != obj2 || (obj1 == obj2 && obj1.search("invalid") != -1))
                {
                    $("#button-form").prop('disabled', true);
                }
                else
                {
                    $("#button-form").prop('disabled', false);
                }

            }

            function validateEqual()
            {
                if($("#passwd").val() == $("#repeatPasswd").val())
                {
                    $("#repeatPasswd").removeClass("is-invalid");
                    $("#repeatPasswd").addClass("is-valid");
                }
                else
                {
                    $("#repeatPasswd").removeClass("is-valid");
                    $("#repeatPasswd").addClass("is-invalid");
                }
            }

            function validateFormat()
            {
                var reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;

                if(!reg.test($("#passwd").val()) || $("#passwd").val() == "")
                {
                    $("#passwd").addClass("is-invalid");
                    $("#passwd").removeAttr('data-original-title');


                    var minus = false;
                    var mayus = false;
                    var symbol = false;
                    var number = false;
                    var size = false;
                    var text = "";
                    
                    if(!(/(?=.*[a-z])/.test($("#passwd").val())))
                    {
                        minus = true;
                        text = text.concat("Falta una minúscula. ");
                    }

                    if(!(/(?=.*[A-Z])/.test($("#passwd").val())))
                    {
                        mayus = true;
                        text = text.concat("Falta una mayúscula. ");
                    }   

                    if(!(/(?=.*[0-9])/.test($("#passwd").val())))
                    {
                        number = true;
                    }  
                                                   
                    if(!(/(?=.*[!@#\$%\^&\*])/.test($("#passwd").val())))
                    {
                        symbol = true;
                        text = text.concat("Falta un símbolo especial. ");
                    }

                    if(!(/(?=.{8,})/.test($("#passwd").val())))
                    {
                        size = true;
                        text = text.concat("Mínimo 8 caracteres.");
                    }        

                    if(minus || mayus || symbol || number || size)
                    {
                        $("#passwd").attr('data-toggle', 'tooltip');
                        $("#passwd").attr('data-placement', 'right');
                        $("#passwd").attr('title', text);
                        $('[data-toggle="tooltip"]').tooltip();
                    }


                }
                else
                {
                    $("#passwd").removeAttr('data-toggle');
                    $("#passwd").removeAttr('data-original-title');
                    $("#passwd").removeAttr('data-placement');
                    $("#passwd").removeAttr('title');
                    $("#passwd").removeClass("is-invalid");
                    $("#passwd").addClass("is-valid");
                }

            }

        </script>

</body>
</html>
