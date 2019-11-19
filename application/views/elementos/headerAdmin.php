<header>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand">
          <img src="<?php echo base_url('assets/img/logo_menus.png')?>" class="imagenMenu" alt="">
        </a>
        <!-- Boton de diseño adaptable -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav mr-auto">
        <li><a class="nav-link active" href="<?= base_url().'administrador_controller/'?>">Inicio</a><li>
        <li><a class="nav-link" href="<?= base_url().'administrador_controller/gestionusuarios'?>">Usuarios</a><li>
      </ul>
      <ul class="navbar-nav ">
        <li class="nav-item my-2 my-lg-0 mr-sm-2">
          <a class="nav-link" href="<?= base_url().'login_controller/logout'?>">Cerrar sesión</a>
        </li>
      </ul>
    </div>

  </nav>
<header>
