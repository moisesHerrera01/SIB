<!-- Estructura
<div class="container-box-menu">
  <a class="box-menu">
    <div class="box-menu-icon icon-unidad"></div>
    <div class="box-menu-name">
      Unidad Medida
    </div>
  </a>
</div>
-->

<div class="container-box-menu">

<p>
  <?php
    $href;
    if ($atras) {
      $href = base_url("/index.php") . "/Submenu/index/" . $atras->id_modulo;
    } else {
      $href = base_url("/index.php");
    }
  ?>
  <a class="icono-lg icon-arrow-left" href="<?= $href?>"></a>
</p>

<?php foreach ($modulos as $modulo): ?>

    <?php $url = ($modulo->url_modulo == '') ? "Submenu/index/".$modulo->id_modulo : $modulo->url_modulo;?>

    <a href="<?= base_url('index.php/'.$url)?>" class="box-menu">
      <div class="box-menu-icon <?= $modulo->img_modulo?>"></div>
      <div class="box-menu-name">
        <?= $modulo->nombre_modulo?>
      </div>
    </a>

<?php endforeach; ?>

</div>
