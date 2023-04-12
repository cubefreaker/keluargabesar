<?=$this->extend($config->viewLayout)?>
<?=$this->section('content')?>
  <canvas></canvas>
    <section class="mt-n4">
      <!-- <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4"> -->
            <div class="login-brand pt-4">
              <!-- <img src="<?=base_url()?>/assets/img/logo.png" alt="logo" width="100" class="shadow-light rounded"> -->
            </div>
            <div class="card card-primary login-form">
              <div class="card-header"><h4><?=lang('Auth.loginTitle')?></h4></div>

              <!-- <div class="card-body"> -->

                <?= view('Myth\Auth\Views\_message_block') ?>
                
                <form method="POST" action="<?= route_to('login') ?>" class="needs-validation mx-4" novalidate="">
                  <?= csrf_field() ?>
                  
                <?php if ($config->validFields === ['email']): ?>
                  <div class="form-group">
                    <label for="login"><?=lang('Auth.email')?></label>
                    <input id="email"
                           type="email"
                           class="form-control <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>"
                           name="login"
                           placeholder="<?=lang('Auth.email')?>"
                           tabindex="1"
                           required autofocus>
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                  </div>

                <?php else: ?>  
                  <div class="form-group">
                    <label for="login"><?=lang('Auth.emailOrUsername')?></label>
                    <input type="text"
                           class="form-control <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>"
                           name="login"
                           placeholder="<?=lang('Auth.emailOrUsername')?>"
                           tabindex="1"
                           required autofocus>
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                  </div>
                  
                <?php endif; ?>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label"><?=lang('Auth.password')?></label>

                        <?php if ($config->activeResetter): ?>
                            <div class="float-right">
                                <a href="<?= route_to('forgot') ?>" class="text-small">
                                    <?=lang('Auth.forgotYourPassword')?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <input id="password"
                           type="password"
                           class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>"
                           name="password"
                           placeholder="<?=lang('Auth.password')?>"
                           tabindex="2"
                           required>
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                  </div>

                <?php if ($config->allowRemembering): ?>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox"
                             name="remember"
                             class="custom-control-input"
                             tabindex="3"
                             id="remember-me"
                             <?php if(old('remember')) : ?> checked <?php endif ?>>
                      <label class="custom-control-label" for="remember-me"><?=lang('Auth.rememberMe')?></label>
                    </div>
                  </div>
                <?php endif; ?>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        <?=lang('Auth.loginAction')?>
                    </button>
                  </div>
                </form>

                <!-- <hr> -->
                
                <!-- <?php if ($config->allowRegistration) : ?>
                    <p class="text-small"><a href="<?= route_to('register') ?>"><?=lang('Auth.needAnAccount')?></a></p>
                <?php endif; ?> -->
                <!-- <div class="text-center mt-4 mb-3">
                  <div class="text-job text-muted">Login With Social</div>
                </div>
                <div class="row sm-gutters">
                  <div class="col-6">
                    <a class="btn btn-block btn-social btn-facebook">
                      <span class="fab fa-facebook"></span> Facebook
                    </a>
                  </div>
                  <div class="col-6">
                    <a class="btn btn-block btn-social btn-twitter">
                      <span class="fab fa-twitter"></span> Twitter
                    </a>
                  </div>
                </div> -->

              <!-- </div> -->
            </div>
            <!-- <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="auth-register.html">Create One</a>
            </div> -->
            <!-- <div class="simple-footer">
              Copyright &copy; Stisla 2018
            </div> -->
          <!-- </div>
        </div>
      </div> -->
    </section>
    
  <!-- WEB Fluid Simulation -->
  <script>
    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
    ga('create', 'UA-105392568-1', 'auto');
    ga('send', 'pageview');
  </script>
  <script src="<?=base_url()?>/assets/js/webgl.fluid.js"></script>
<?=$this->endSection()?>