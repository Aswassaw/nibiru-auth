<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="card mx-auto" style="max-width: 555px;">
    <div class="card-header">
        <h5 class="my-auto mx-auto text-center">Ubah Password</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('account/change-password') ?>" method="post">
            <!-- CSRF -->
            <?= csrf_field(); ?>
            <!-- Method Spoofing -->
            <input type="hidden" name="_method" value="PATCH" />

            <!-- Password Lama -->
            <div class="mb-3">
                <label for="current_password" class="form-label">Password saat ini</label>
                <input type="password" class="form-control
                <?php if ($validation->hasError('current_password')) { ?>
                    is-invalid
                <?php } ?>" name="current_password" autocomplete="off" maxlength="100" minlength="6" required autofocus>

                <?php if ($validation->hasError('current_password')) { ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('current_password') ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Password Baru -->
            <div class="mb-3">
                <label for="password" class="form-label">Password baru</label>
                <input type="password" class="form-control
                <?php if ($validation->hasError('password')) { ?>
                    is-invalid
                <?php } ?>" name="password" autocomplete="off" maxlength="100" minlength="6" required>

                <?php if ($validation->hasError('password')) { ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('password') ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Submit -->
            <hr>
            <input type="submit" class="btn btn-success" value="Update">
        </form>
    </div>
</div>
<?= $this->endSection('content'); ?>