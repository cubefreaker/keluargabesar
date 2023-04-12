<?= $this->extend($config->viewLayout) ?>
<?= $this->section('content') ?>
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header"><h4><?=lang('Auth.resetYourPassword')?></h4></div>

              <div class="card-body">

                <?= view('Myth\Auth\Views\_message_block') ?>

                <p class="text-muted"><?=lang('Auth.enterCodeEmailPassword')?></p>
                <form method="POST" action="<?= route_to('reset-password') ?>">
                  <div class="form-group">
                    <label for="token"><?=lang('Auth.token')?></label>
                    <input id="token"
                           type="text"
                           class="form-control <?php if(session('errors.token')) : ?>is-invalid<?php endif ?>"
                           name="token"
                           tabindex="1"
                           required
                           autofocus>
                    <div class="invalid-feedback">
                        <?= session('errors.token') ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email"><?=lang('Auth.email')?></label>
                    <input id="email"
                           type="email"
                           class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                           name="email"
                           tabindex="1"
                           required
                           autofocus
                           placeholder="<?=lang('Auth.email')?>"
                           value="<?= old('email') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.email') ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="password"><?=lang('Auth.newPassword')?></label>
                    <input id="password"
                           type="password"
                           class="form-control pwstrength <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>"
                           data-indicator="pwindicator"
                           name="password"
                           tabindex="2"
                           required>
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                    <div id="pwindicator" class="pwindicator">
                      <div class="bar"></div>
                      <div class="label"></div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="pass_confirm"><?=lang('Auth.newPasswordRepeat')?></label>
                    <input id="password-confirm"
                           type="password"
                           class="form-control <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                           name="pass_confirm"
                           tabindex="2"
                           required>
                    <div class="invalid-feedback">
                        <?= session('errors.pass_confirm') ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        <?=lang('Auth.resetPassword')?>
                    </button>
                  </div>
                </form>
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