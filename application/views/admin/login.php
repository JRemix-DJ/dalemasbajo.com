<? //$this->load->helper(array('url', 'form')); ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="<? echo $title; ?>">
    <meta name="twitter:creator" content="Shift&Ctrl">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<? echo $title; ?>">
    <meta name="twitter:description" content="<? echo $description; ?>">
    <meta name="twitter:image" content="<? echo site_url(); ?>images/logo.png">

    <!-- Facebook -->
    <meta property="og:url" content="<? echo site_url(); ?>">
    <meta property="og:title" content="<? echo $title; ?>">
    <meta property="og:description" content="<? echo $description; ?>">

    <meta property="og:image" content="<? echo site_url(); ?>images/logo.png">
    <meta property="og:image:secure_url" content="<? echo site_url(); ?>images/logo.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="<? echo $description; ?>">
    <meta name="author" content="<? echo $title; ?>">

    <title><? echo $title; ?></title>

    <!-- vendor css -->
    <link href="<? echo site_url(); ?>admin_assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<? echo site_url(); ?>admin_assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">


    <!-- Starlight CSS -->
    <link rel="stylesheet" href="<? echo site_url(); ?>admin_assets/css/starlight.css">
  </head>

  <body>

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><img src="<? echo site_url(); ?>images/logo.png" alt=""></div>
        <div class="tx-center mg-b-60">Acceso al Administrador</div>
        <? echo form_open(base_url().'login/do'); ?>
        <div class="form-group">
            <? 
                $input_data = array(
                    'type'=>'text',
                    'name'=>'email',
                    'class'=>'form-control',
                    'placeholder'=>'Ingresa tu Username'
                );
                echo form_input($input_data);
            ?>
        </div><!-- form-group -->
        <div class="form-group">
            <? 
                $input_data = array(
                    'type'=>'password',
                    'name'=>'password',
                    'class'=>'form-control',
                    'placeholder'=>'Ingresa tu Password'
                );
                echo form_input($input_data);
            ?>
          
          <a href="" class="tx-info tx-12 d-block mg-t-10" data-toggle="modal" data-target="#myModalRecuperar">¿Olvidaste tu contraseña?</a>
        </div><!-- form-group -->

        <? echo form_hidden('token', $token); ?>
        <button type="submit" class="btn btn-info btn-block">Ingresar</button>
        <? echo form_close(); ?>
        <?php echo validation_errors(); ?>
        <? if($this->session->flashdata('usuario_incorrecto')){ ?>
            <p>
                <?= $this->session->flashdata('usuario_incorrecto'); ?>
            </p>

        <? } ?>
        <div class="mg-t-60 tx-center"><a href="<? echo site_url(); ?>" class="tx-info">Volver a Inicio</a></div>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->
    <div class="modal fade" id="myModalRecuperar" tabindex="-1" role="dialog" aria-labelledby="Recuperar">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Recuperar Contraseña</h4>
          </div>
          <div class="modal-body">
            <form action="#" id="recuperar-form">
                <label for="">
                    E-mail:
                </label>
                <input type="text" name="email" id="recuperar-email" class="form-control">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="recuperar-btn">Recuperar</button>
          </div>
        </div>
      </div>
    </div>
    <script src="<? echo site_url(); ?>admin_assets/lib/jquery/jquery.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/popper.js/popper.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/bootstrap/bootstrap.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/js/starlight.js"></script>

  </body>
</html>
