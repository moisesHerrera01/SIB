<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <img src=<?= base_url("assets/image/icono.jpg")?> width="120px" align='right' style="margin:10px;"/></div>
    <title><?= $title?></title>
    <h5 align="center"><?=$mtps?></h5>
    <h5 align="center"><?=$uaci?></h5>
    <h5 align="center"><?=$param?></h5>
    <link rel="shortcut icon" href="<?= base_url("assets/image/logo.jpg")?>" />
    <link href=<?= base_url("vendor/twbs/bootstrap/dist/css/bootstrap.min.css")?> rel="stylesheet">
    <link href=<?= base_url("assets/css/main.css")?> rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url("assets/image/logo.jpg")?>" />
  </head>
  <body onload="window.print()">
    <div>
      <?= $table?>
    </div>
  </body>
</html>
