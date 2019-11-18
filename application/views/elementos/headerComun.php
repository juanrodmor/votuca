<header>
  <!-- MINI MENU BOTONES -->


  <!-- IMAGEN DEL LOGO -->
<!--  <div class="imagen">
    <h1><img src="<?php echo base_url('assets/img/logo_uca_header.png')?>"class="img-fluid" alt="Responsive image"></h1>
  </div>-->
  <!-- MENU PRINCIPAL -->

  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">VotUCA</a>
    <!-- Boton de diseño adaptable -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url().$inicio?>">Inicio <span class="sr-only">(current)</span></a>
        </li>

      </ul>
      <ul class="navbar-nav ">
        <li class="nav-item my-2 my-lg-0 mr-sm-2">
          <a class="nav-link" href="<?= base_url().'login_controller/logout'?>">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </nav>
</header>
