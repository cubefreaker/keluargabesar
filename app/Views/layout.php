<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    <script src="<?=base_url()?>/assets/lib/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>/assets/lib/bootstrap/bootstrap.min.js"></script>
    <title><?=$title?></title>
</head>
<body>
    <!-- Main Content -->
    <div class="main-content">
        <?= $this->renderSection("content") ?>
    </div>
</body>
</html>