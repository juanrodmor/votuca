<div id="header">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      	<a class="navbar-brand" href="<?= base_url().'secretario/delegado/'?>">
        	<img id="logo-btn" src="<?php echo base_url('assets/img/logo_menus.png')?>" style="height:5em;" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
           <ul class="navbar-nav mr-auto">
          </ul>
           <ul class="navbar-nav ">
         <li class="nav-item my-2 my-lg-0 mr-sm-8">
        <a id="cerrar-ses" class="nav-link" href="<?= base_url().'login_controller/logout'?>">Cerrar sesión</a>
      </li>
    </ul>
      </div>
    </nav> <!-- FIN MENU SUPERIOR -->

    <nav class="row is-flex see-overflow fixed" id="title-container"> <!-- MENU INFERIOR -->
    <!--<div class="row is-flex see-overflow fixed" id="title-container">-->
        <div class="col-xs-12 col-sm-8">
            <h2>Secretario delegado</h2>
        </div>
        <hr class="divider">

  <!--</div>-->
  </nav>
</div>
