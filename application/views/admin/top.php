<? $this->load->helper('url'); ?>

<!-- ########## START: HEAD PANEL ########## -->
    <div class="sl-header">
      <div class="sl-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
      </div><!-- sl-header-left -->
      <div class="sl-header-right">
        <nav class="nav">
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name"><? echo $this->session->username; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-200">
              <ul class="list-unstyled user-profile-nav">
                <li><a href="<? echo base_url().'admin/editar_perfil/'?>"><i class="icon ion-ios-person-outline"></i> Editar Perfil</a></li>
                <li><a href="<? echo base_url().'admin/cambiar_pass/'?>"><i class="icon ion-settings"></i> Cambiar Contraseña</a></li>
               <!--  <li><a href=""><i class="icon ion-ios-gear-outline"></i> Ajustes</a></li>
                <li><a href=""><i class="icon ion-ios-download-outline"></i> Descargas</a></li> -->
                <li><a href="<? echo base_url().'login/logout_ci'; ?>"><i class="icon ion-power"></i> Salir</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
        </nav>
        
      </div><!-- sl-header-right -->
    </div><!-- sl-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="#">Dale Más Bajo</a>
        <span class="breadcrumb-item active">Dashboard</span>
      </nav>