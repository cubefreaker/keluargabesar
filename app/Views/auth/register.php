<?= $this->extend($config->viewLayout) ?>
<?= $this->section('content') ?>
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="card card-primary">
              <div class="card-header"><h4><?=lang('Auth.register')?></h4></div>

              <div class="card-body">
                <form method="POST" action="<?= route_to('register') ?>" >
                  <?= csrf_field() ?>

                  <!-- <div class="row">
                    <div class="form-group col-6">
                      <label for="first_name">First Name</label>
                      <input id="first_name" type="text" class="form-control" name="first_name" autofocus>
                    </div>
                    <div class="form-group col-6">
                      <label for="last_name">Last Name</label>
                      <input id="last_name" type="text" class="form-control" name="last_name">
                    </div>
                  </div> -->

                  <div class="row">
                      <div class="form-group col-6">
                        <label for="email"><?=lang('Auth.email')?></label>
                        <input id="email" type="email"
                               class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                               name="email"
                               aria-describedby="emailHelp"
                               placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>"
                               required>
                        <small id="emailHelp" class="form-text text-muted"><?=lang('Auth.weNeverShare')?></small>
                      </div>
    
                      
                      <div class="form-group col-6">
                          <label for="username"><?=lang('Auth.username')?></label>
                          <input id="username"
                                 type="text"
                                 class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>"
                                 name="username"
                                 placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>"
                                 required>
                      </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block"><?=lang('Auth.password')?></label>
                      <input id="password"
                             type="password"
                             class="form-control pwstrength <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" data-indicator="pwindicator"
                             name="password"
                             placeholder="<?=lang('Auth.password')?>"
                             autocomplete="off"
                             required>
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>

                    <div class="form-group col-6">
                      <label for="pass_confirm" class="d-block"><?=lang('Auth.repeatPassword')?></label>
                      <input id="password2"
                             type="password"
                             class="form-control <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                             name="pass_confirm"
                             placeholder="<?=lang('Auth.repeatPassword')?>"
                             autocomplete="off"
                             required>
                    </div>
                  </div>

                  <!-- <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                      <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                    </div>
                  </div> -->

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        <?=lang('Auth.register')?>
                    </button>
                  </div>
                </form>
                <hr>
                <p class="text-small"><?=lang('Auth.alreadyRegistered')?> <a href="<?= route_to('login') ?>"><?=lang('Auth.signIn')?></a></p>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Stisla 2018
            </div>
          </div>
        </div>
      </div>
    </section>
<?= $this->endSection() ?>