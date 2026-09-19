<? $this->load->helper('url'); ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="">
    <meta name="twitter:creator" content="">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<? echo $title; ?>">
    <meta name="twitter:description" content="<? echo $description; ?>">
    <meta name="twitter:image" content="">

    <!-- Facebook -->
    <meta property="og:url" content="<? echo base_url(); ?>">
    <meta property="og:title" content="<? echo $title; ?>">
    <meta property="og:description" content="<? echo $description; ?>">

    <meta property="og:image" content="">
    <meta property="og:image:secure_url" content="">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="<? echo $description; ?>">
    <meta name="author" content="<? echo $title; ?>">

    <title><? echo $title; ?></title>

    <link rel="shortcut icon" sizes="196x196" href="<?= base_url('assets/front/img/favicon.png'); ?>">
    <link href="<?= base_url('assets/admin/vendor/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/admin/vendor/Ionicons/css/ionicons.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/admin/vendor/perfect-scrollbar/css/perfect-scrollbar.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/admin/vendor/rickshaw/rickshaw.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/admin/vendor/select2/css/select2.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/front/css/font-awesome.min.css'); ?>">
    <? if(isset($aditional_stylesheets)){ ?>
        <? echo $aditional_stylesheets; ?>
    <? } ?>

    <? if(isset($stylesheets)){
        foreach($stylesheets as $style){
            echo '<link href="'.$style.'" rel="stylesheet">';
        }
     } ?>

    <link rel="stylesheet" href="<?= base_url('assets/admin/css/starlight.css'); ?>">

    <?php if (isset($styles) && is_array($styles)): ?>
        <?php foreach ($styles as $s): ?>
            <link rel="stylesheet" href="<?= base_url($s); ?>?v=<?= file_exists(FCPATH . $s) ? filemtime(FCPATH . $s) : '1.0'; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
  </head>

  <body>