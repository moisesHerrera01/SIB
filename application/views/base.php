<?php $this->ci =& get_instance(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title><?= $title?></title>
    <link rel="shortcut icon" href="<?= base_url("assets/image/logo.jpg")?>" />
    <link href=<?= base_url("vendor/twbs/bootstrap/dist/css/bootstrap.min.css")?> rel="stylesheet" media="screen">
    <link href=<?= base_url("assets/css/main.css")?> rel="stylesheet" media="screen">
    <link href=<?= base_url("assets/css/menu.css")?> rel="stylesheet" media="screen">
    <link href=<?= base_url("assets/css/sweetalert.css")?> rel="stylesheet" media="screen">
    <link href=<?= base_url("assets/css/iconos.css")?> rel="stylesheet" media="screen">
    <script type="text/javascript">
      var baseurl = "<?= base_url(); ?>";
    </script>
  </head>
  <body>
    <div>
      <?php
        if (isset($menu)) {
          echo $menu;
        }
      ?>
    </div>
    <div class="content">
       <?= $body?>
    </div></div>
    </div></div>
    <?php $this->ci->load->view("help/reportar_problema"); ?>
    <div class="footer">
      <div class="content_footer">
        <div class="content-info-sis">
          <p class="name-sis">
            SIB INSAFOCOOP
          </p>
          <p>
            Copyright (c) 2017 Copyright Holder All Rights Reserved.
          </p>
        </div>
        <div class="conten-info-min">
          <img id="ues" src="<?= base_url("assets/image/minerva.gif")?>" alt="" width="50px"/>
          <img id="escudo" src="<?= base_url("assets/image/escudo.png")?>" alt="" />
          <img id="escudo" src="<?= base_url("assets/image/icono.jpg")?>" alt="" />
          <div class="nombre-inst">&nbsp; INSTITUTO SALVADOREÑO DE FOMENTO COOPERATIVO.</div>
        </div>
      </div>
    </div>
    <!-- script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script -->
    <script src='<?= base_url('assets/js/jquery-1.11.3.min.js') ?>'></script>
    <script src="<?= base_url('assets/js/jquery.validate.min.js')?>"></script>
    <script src="<?= base_url('assets/js/html2canvas.min.js')?>"></script>
    <script src="<?= base_url("assets/js/validate/additional-methods.js")?>"></script>
    <script src="<?= base_url('assets/js/jquery-migrate-1.2.1.min.js')?>"></script>
    <script src="<?= base_url("vendor/twbs/bootstrap/dist/js/bootstrap.min.js")?>"></script>
    <script src="<?= base_url("assets/js/jQueryRotate.js")?>"></script>
    <script src="<?= base_url("assets/js/main.js")?>"></script>
    <?php
      if (isset($js)) {
        echo "<script src=".base_url($js)." type=\"text/javascript\"></script>";
      }
    ?>
    <script src="<?= base_url("assets/js/notice.js")?>"></script>
    <script src="<?= base_url("assets/js/help.js")?>"></script>
    <script src="<?= base_url("assets/js/sweetalert.min.js")?>"></script>
  </body>
</html>
