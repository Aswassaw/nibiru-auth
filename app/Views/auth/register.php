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
                <div class="auth-title">REGISTER FORM</div>
                <hr>
                <form action="<?= route_to('submit_register_form') ?>" method="post">
                    <!-- CSRF -->
                    <?= csrf_field(); ?>

                    <!-- Fullname -->
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Fullname</label>
                        <input type="text" class="form-control
                        <?php if ($validation->hasError('fullname')) { ?>
                            is-invalid
                        <?php } ?>" id="fullname" name="fullname" autocomplete="off" maxlength="50" value="<?= set_value('fullname') ?>" required autofocus>

                        <?php if ($validation->hasError('fullname')) { ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('fullname') ?>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control
                        <?php if ($validation->hasError('username')) { ?>
                            is-invalid
                        <?php } ?>" id="username" name="username" autocomplete="off" maxlength="25" value="<?= set_value('username') ?>" required>

                        <?php if ($validation->hasError('username')) { ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('username') ?>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control
                        <?php if ($validation->hasError('email')) { ?>
                            is-invalid
                        <?php } ?>" id="email" name="email" autocomplete="off" maxlength="100" value="<?= set_value('email') ?>" required>

                        <?php if ($validation->hasError('email')) { ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
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

                    <!-- Submit & Reset -->
                    <hr>
                    <div class="row">
                        <div class="col d-grid gap-2">
                            <input type="submit" class="btn btn-primary value=" value="Register">
                        </div>
                        <div class="col d-grid gap-2">
                            <input type="reset" class="btn btn-danger reset" value="Reset">
                        </div>
                    </div>
                    <hr>

                    <!-- Log In -->
                    <div class="row">
                        <div class="col text-center">
                            Already have an Account? <a href="<?= route_to('show_login_form') ?>" class="link">Log In</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>