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
                <div class="auth-title">FORGOT PASSWORD</div>
                <hr>
                <form action="<?= base_url('auth/password/forgot') ?>" method="post">
                    <!-- CSRF -->
                    <?= csrf_field(); ?>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control
                        <?php if ($validation->hasError('email')) { ?>
                            is-invalid
                        <?php } ?>" id="email" name="email" autocomplete="off" maxlength="100" value="<?= set_value('email') ?>" required autofocus>

                        <?php if ($validation->hasError('email')) { ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
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
                            Already remember? <a href="<?= base_url('auth/login') ?>" class="link">Log In</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>