<div id="header">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      	<a class="navbar-brand">
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
            <h2>Secretario</h2>
        </div>
        <hr class="divider">
		<ul class="nav nav-pills">
  			<li class="nav-item">
          <a style="border-radius: 0px;color: white" class="nav-link" href="<?= base_url().'secretario/'?>">Votaciones</a>
  			</li>
	  		<li class="nav-item dropdown">
	    		<a style="border-radius: 0px;color: white" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Crear votación</a>
	    		<div class="dropdown-menu">
	    			<style>
					.nav-pills a:hover {
  					background-color: #cbcbcb;
					}
					</style>
		            <a class="dropdown-item" href="<?= base_url().'secretario/crearVotacion/VotacionSimple'?>">Simple</a>
		            <a class="dropdown-item" href="<?= base_url().'secretario/crearVotacion/VotacionCompleja'?>">Compleja</a>
		            <a class="dropdown-item" href="<?= base_url().'secretario/crearVotacion/ConsultaSimple'?>">Consulta simple</a>
		            <a class="dropdown-item" href="<?= base_url().'secretario/crearVotacion/ConsultaCompleja'?>">Consulta compleja</a>
		            <a class="dropdown-item" href="<?= base_url().'secretario/crearVotacion/EleccionRepresentantes'?>">Elección representantes</a>
		            <a class="dropdown-item" href="<?= base_url().'secretario/crearVotacion/CargosUniponderados'?>">Cargos uniponderados</a>
	    		</div>
	    	</li>
	    	<li class="nav-item active">
            	<a style="border-radius: 0px;color: white" class="nav-link" href="<?= base_url().'secretario/obtenerBorradores'?>">Borradores</a>
        	</li>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
		</ul>
  <!--</div>-->
  </nav>
</div>
