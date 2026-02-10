
    <? $user_role=$this->session->userdata('role');?>
    <!-- ########## START: LEFT PANEL ########## -->
    <div class="sl-logo"><a href=""><img src="<? echo site_url(); ?>images/logo.png" alt=""></a></div>
    <div class="sl-sideleft">
      <label class="sidebar-label">Menú</label>
      <div class="sl-sideleft-menu">
        <a href="<? echo base_url().'admin/'?>" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Inicio</span>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <a href="<? echo base_url().'admin/listar_drops'?>" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Drops</span>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <a href="" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-musical-note tx-20"></i>
            <span class="menu-item-label">Audios</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item">
            <a href="<? echo base_url().'admin/listar_productos/'; ?>" class="nav-link">Aprobados</a>
            <ul>
              <? foreach($generos as $genero){ ?>
                <li>
                  <a href="<? echo $genero->id; ?>"><? echo $genero->name; ?></a>
                </li>
              <? } ?>
            </ul>
          </li>
          
          <li class="nav-item"><a href="<? echo base_url().'admin/listar_productos/?aprobacion=1'; ?>" class="nav-link">Sin Aprobar</a></li>
          
          <li class="nav-item"><a href="<? echo base_url().'admin/nuevo_producto/'; ?>" class="nav-link">Nuevo Audio</a></li>
        </ul>
        <? if($this->session->userdata('role')=='is_admin'){ ?>
          <a href="" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-android-checkbox-outline tx-20"></i>
            <span class="menu-item-label">Planes</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
          </a><!-- sl-menu-link -->
           <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="<? echo base_url('admin/listar_planes/')?>" class="nav-link">Listar Planes</a></li>
          <li class="nav-item"><a href="<? echo base_url('admin/nuevo_plan/')?>" class="nav-link">Nuevo Plan</a></li>
        </ul>
        <? } ?>

        <? if($this->session->userdata('role')=='is_admin'){ ?>
          <a href="<? echo base_url('admin/precios/')?>" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-android-checkbox-outline tx-20"></i>
            <span class="menu-item-label">Precios</span>
          </div><!-- menu-item -->
          </a><!-- sl-menu-link -->
        <? } ?>
        <? if($this->session->userdata('role')=='is_admin'){ ?>
         <a href="" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-folder tx-20"></i>
            <span class="menu-item-label">Generos</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="<? echo base_url().'admin/listar_generos/'; ?>" class="nav-link">Listar Generos</a></li>
          <li class="nav-item"><a href="<? echo base_url().'admin/nuevo_genero/'; ?>" class="nav-link">Nuevo Género</a></li>
        </ul>
         <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon ion-image tx-20"></i>
            <span class="menu-item-label">Banners</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="<? echo base_url().'admin/listar_banner/'; ?>" class="nav-link">Listar Banners</a></li>
          <li class="nav-item"><a href="<? echo base_url().'admin/nuevo_banner/'; ?>" class="nav-link">Nuevo Banners</a></li>
        </ul>
        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon ion-ios-person tx-20"></i>
            <span class="menu-item-label">Clientes</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="<? echo base_url().'admin/listar_usuarios/'; ?>" class="nav-link">Listar Clientes</a></li>
          <li class="nav-item"><a href="<? echo base_url().'admin/nuevo_usuario/'; ?>" class="nav-link">Nuevo Cliente</a></li>
        </ul>
         <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon ion-ios-person tx-20"></i>
            <span class="menu-item-label">Djs</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="<? echo base_url().'admin/listar_djs/'; ?>" class="nav-link">Listar Djs</a></li>
          <li class="nav-item"><a href="<? echo base_url().'admin/nuevo_dj/'; ?>" class="nav-link">Nuevo Dj</a></li>
        </ul>
        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-paper-outline tx-22"></i>
            <span class="menu-item-label">Ordenes</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div>
        </a>
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="<? echo base_url().'admin/listar_ordenes/';?>" class="nav-link">Mostrar Ordenes</a></li>
          <li class="nav-item"><a href="<? echo base_url().'admin/listar_ordenes_tokens/';?>" class="nav-link">Mostrar Ordenes Tokens</a></li>
        </ul>
        <? if($this->session->userdata('role')=='is_admin'){ ?>
          <a href="<? echo base_url().'admin/pagos/'?>" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Pagos</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <div class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="<? echo base_url('admin/pagos_tokens/'); ?>" class="nav-link">Pagos Pendientes Tokens</a></li>
          <li class="nav-item"><a href="<? echo base_url('admin/pagos_realizados_tokens/'); ?>" class="nav-link">Pagos Realizados Tokens</a></li>
          <li class="nav-item"><a href="<? echo base_url('admin/pagos/'); ?>" class="nav-link">Pagos Pendientes</a></li>
          <li class="nav-item"><a href="<? echo base_url('admin/pagos_realizados/'); ?>" class="nav-link">Pagos Realizados</a></li>
        </div>
        <? } ?>
        <? if($this->session->userdata('role')=='is_admin'){ ?>
          <a href="<? echo base_url().'admin/cupones/'?>" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Cupones</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <div class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="<? echo base_url('admin/cupones/'); ?>" class="nav-link">Listar Cupones</a></li>
          <li class="nav-item"><a href="<? echo base_url('admin/add_cupon/'); ?>" class="nav-link">Nuevo Cupón</a></li>
        </div>
        <? } ?>
        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-paper-outline tx-22"></i>
            <span class="menu-item-label">FAQ</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="<? echo base_url().'admin/listar_faq/'; ?>" class="nav-link">Mostrar FAQ</a></li>
          <li class="nav-item"><a href="<? echo base_url().'admin/nuevo_faq/'; ?>" class="nav-link">Nuevo FAQ</a></li>
        </ul>
      <? } ?>
      <? if($this->session->userdata('role')=='is_editor'){ ?>
        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-paper-outline tx-22"></i>
            <span class="menu-item-label">PAGOS</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href="<? echo base_url('admin/pagos_tokens/'); ?>" class="nav-link">Pagos Pendientes Tokens</a></li>
          <li class="nav-item"><a href="<? echo base_url('admin/pagos_realizados_tokens/'); ?>" class="nav-link">Pagos Realizados Tokens</a></li>
          <li class="nav-item"><a href="<? echo base_url().'admin/pagos/'; ?>" class="nav-link">Pagos Pendientes</a></li>
          <li class="nav-item"><a href="<? echo base_url().'admin/pagos_realizados/'; ?>" class="nav-link">Pagos Hechos</a></li>
        </ul>
      <? } ?>
      </div><!-- sl-sideleft-menu -->

      <br>
    </div><!-- sl-sideleft -->