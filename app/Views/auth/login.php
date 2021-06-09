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
                <div class="auth-title">LOG IN FORM</div>
                <hr>
                <form action="<?= route_to('submit_login_form') ?>" method="post">
                    <!-- CSRF -->
                    <?= csrf_field(); ?>

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username or Email</label>
                        <input type="text" class="form-control
                        <?php if ($validation->hasError('username')) { ?>
                            is-invalid
                        <?php } ?>" id="username" name="username" autocomplete="off" maxlength="25" value="<?= set_value('username') ?>" required autofocus>

                        <?php if ($validation->hasError('username')) { ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('username') ?>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control
                        <?php if ($validation->hasError('password')) { ?>
                            is-invalid
                        <?php } ?>" id="password" name="password" autocomplete="off" maxlength="100" minlength="6" required>

                        <?php if ($validation->hasError('password')) { ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Submit & Reset -->
                    <hr>
                    <div class="row">
                        <div class="col d-grid gap-2">
                            <input type="submit" class="btn btn-primary" value="Login">
                        </div>
                        <div class="col d-grid gap-2">
                            <input type="reset" class="btn btn-danger reset" value="Reset">
                        </div>
                    </div>
                    <hr>

                    <!-- Create an Account or Forgot Password -->
                    <div class="row">
                        <div class="col text-center">
                            <a href="<?= route_to('show_register_form') ?>" class="link">Create an Account</a> or <a href="<?= route_to('show_forgot_form') ?>" class="link">Forgot Password</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>