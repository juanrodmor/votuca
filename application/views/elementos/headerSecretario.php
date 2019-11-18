<header>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <!-- Logo -->
    <a class="navbar-brand">
          <img src="<?php echo base_url('assets/img/logo_menus.png')?>" class="imagenMenu" alt="">
        </a>
    <!--<a class="navbar-brand" href="#">VotUCA</a>-->
    <!-- Boton de diseño adaptable -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="<?= base_url().'secretario/'?>">Inicio <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Votaciones</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="<?= base_url().'secretario/crearVotacion'?>">Crear</a>
          </div>
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
