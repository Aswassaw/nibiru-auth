<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('style'); ?>
<style>
    .auth-title {
        font-size: 30px;
        font-weight: bold;
        text-align: center;
    }
</style>
<?= $this->endSection('style'); ?>


<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="auth-title">RESET PASSWORD</div>
                <hr>
                <form action="<?= route_to('submit_reset_form') ?>" method="post">
                    <!-- CSRF -->
                    <?= csrf_field(); ?>
                    <!-- Method Spoofing -->
                    <input type="hidden" name="_method" value="PATCH" />

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control
                        <?php if ($validation->hasError('password')) { ?>
                            is-invalid
                        <?php } ?>" id="password" name="password" autocomplete="off" maxlength="100" minlength="6" required autofocus>

                        <?php if ($validation->hasError('password')) { ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Password Confirm -->
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Password Confirm</label>
                        <input type="password" class="form-control
                        <?php if ($validation->hasError('password_confirm')) { ?>
                            is-invalid
                        <?php } ?>" id="password_confirm" name="password_confirm" autocomplete="off" maxlength="100" minlength="6" required>

                        <?php if ($validation->hasError('password_confirm')) { ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password_confirm') ?>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Submit -->
                    <hr>
                    <div class="row">
                        <div class="col d-grid gap-2">
                            <input type="submit" class="btn btn-primary" value="Kirim">
                        </div>
                    </div>
                    <hr>

                    <!-- Log In -->
                    <div class="row">
                        <div class="col text-center">
                            Already remember? <a href="<?= route_to('show_login_form') ?>" class="link">Log In</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>