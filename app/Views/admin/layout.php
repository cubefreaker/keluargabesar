
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?=$title?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/lib/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/lib/ionicons/css/ionicons.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/components.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/lib/select2/select2.min.css">
  
  <!-- General JS Scripts -->
  <script src="<?=base_url()?>/assets/lib/moment/moment.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/lodash/lodash.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/jquery/jquery.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/popper/popper.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/bootstrap/bootstrap.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/jquery/jquery.nicescroll.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/sweetalert/sweetalert.min.js"></script>
  <script src="<?=base_url()?>/assets/js/stisla.js"></script>
  <script src="<?=base_url()?>/assets/lib/select2/select2.full.min.js"></script>

  <!-- Template JS File -->
  <script src="<?=base_url()?>/assets/js/scripts.js"></script>
  <script src="<?=base_url()?>/assets/js/custom.js"></script>
  
  <!-- Load Angular JS -->
  <script src="<?=base_url()?>/assets/lib/angularjs/angular.min.js"></script>
  <script src="<?=base_url()?>/assets/js/angularjs.module.js"></script>
  <script src="<?=base_url()?>/assets/js/angularjs.directive.js"></script>
  <script src="<?=base_url()?>/assets/lib/angularjs/angular-sanitize.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/angularjs/angular-input-masks-standalone.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/angularjs/ng-file-upload-shim.min.js"></script>
  <script src="<?=base_url()?>/assets/lib/angularjs/ng-file-upload.min.js"></script>
</head>

<body>
  <div id="app" ng-app="Silsilah">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <!-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> -->
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <?php if(logged_in()){ ?>
            <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="<?=base_url()?>/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
              <div class="d-inline-block"><?=user()->username?></div></a>
              <div class="dropdown-menu dropdown-menu-right">
                <!-- <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="features-profile.html" class="dropdown-item has-icon">
                  <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                  <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                  <i class="fas fa-cog"></i> Settings
                </a> -->
                <div class="dropdown-divider"></div>
                <a href="<?=base_url('logout')?>" class="dropdown-item has-icon text-danger">
                  <i class="fas fa-sign-out-alt"></i> Logout
                </a>
              </div>
            </li>
          <?php } ?>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?=base_url()?>">Silsilah</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?=base_url()?>">SLS</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Home</li>
              <li><a class="nav-link" href="<?=base_url()?>/memberTree<?=$slug?>"><i class="ion ion-network"></i><span>Silsilah</span></a></li>
              <li class="menu-header">Keluarga</li>
              <li><a class="nav-link" href="<?=base_url()?>/member<?=$slug?>"><i class="ion ion-ios-people"></i><span>Anggota</span></a></li>
              <li><a class="nav-link" href="<?=base_url()?>/gallery<?=$slug?>"><i class="ion ion-image"></i><span>Galeri</span></a></li>
              <?php if(!logged_in()){?>
                <li class="menu-header">Admin</li>
                <li><a class="nav-link" href="<?=base_url()?>/login"><i class="ion ion-log-in"></i><span>Login</span></a></li>
              <?php }?>
              <!-- <li><a class="nav-link" href="<?=base_url()?>/tipe-tagihan"><i class="ion ion-card"></i><span>Tipe Tagihan</span></a></li> -->
              <!-- <li class="menu-header">Data</li> -->
              <!-- <li><a class="nav-link" href="<?=base_url()?>/users"><i class="ion ion-ios-people"></i> <span>Users</span></a></li> -->
          </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <?= $this->renderSection("content") ?>
      </div>

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; HH 2022 
          <!-- <div class="bullet"></div> Design By Muhamad Nauval Azhar -->
        </div><p></p>
        <div class="footer-right">
          2.3.0
        </div>
      </footer>
    </div>
  </div>
</body>
</html>
