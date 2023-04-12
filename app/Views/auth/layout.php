
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?=$title . ' - ' . APP_NAME?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/lib/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

  <!-- CSS Libraries -->
  <!-- <link rel="stylesheet" href="<?=base_url()?>/assets/lib/selectric/selectric.css">   -->
  <!-- <link rel="stylesheet" href="<?=base_url()?>/assets/lib/bootstrap/bootstrap-social.css"> -->

  <!-- Template CSS -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/components.css">
  <style>
      body {
          overflow-x: hidden;
      }
  </style>
</head>

<body>
  <div id="app">
      <!-- Content -->
    <?=$this->renderSection('content')?>
  </div>

  <!-- General JS Scripts -->
  <script src="<?=base_url()?>/assets/lib/jquery/jquery.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/popper/popper.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/bootstrap/bootstrap.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/jquery/jquery.nicescroll.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/moment/moment.min.js"></script>
  <script src="<?=base_url()?>/assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="<?=base_url()?>/assets/js/scripts.js"></script>
  <script src="<?=base_url()?>/assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
