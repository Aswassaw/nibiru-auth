<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="card mx-auto" style="max-width: 555px;">
    <div class="card-header">
        <h5 class="my-auto mx-auto text-center">Ubah Password <a href="<?= base_url('account/profile/' . $user['slug']) ?>" class="link"><?= $user['username'] ?></a></h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/user/change-password/' . $user['id']) ?>" method="post">
            <!-- CSRF -->
            <?= csrf_field(); ?>
            <!-- Method Spoofing -->
            <input type="hidden" name="_method" value="PATCH" />

            <!-- Password Baru -->
            <div class="mb-3">
                <label for="password" class="form-label">Password baru</label>
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

            <!-- Submit -->
            <hr>
            <input type="submit" class="btn btn-success" value="Update">
        </form>
    </div>
</div>
<?= $this->endSection('content'); ?>