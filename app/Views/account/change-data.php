<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="card mx-auto" style="max-width: 555px;">
    <div class="card-header">
        <h5 class="my-auto mx-auto text-center">Ubah Data</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('account/change-data') ?>" method="post">
            <!-- CSRF -->
            <?= csrf_field(); ?>
            <!-- Method Spoofing -->
            <input type="hidden" name="_method" value="PATCH" />

            <!-- Fullname -->
            <div class="mb-3">
                <label for="fullname" class="form-label">Fullname</label>
                <input type="text" class="form-control
                <?php if ($validation->hasError('fullname')) { ?>
                    is-invalid
                <?php } ?>" id="fullname" name="fullname" autocomplete="off" maxlength="50" value="<?= set_value('fullname', $me['fullname']) ?>" required autofocus>

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
                <?php } ?>" id="username" name="username" autocomplete="off" maxlength="25" value="<?= set_value('username', $me['username']) ?>" required>

                <?php if ($validation->hasError('username')) { ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('username') ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="birth_date" class="form-label">Tanggal lahir</label>
                <input type="date" class="form-control
                <?php if ($validation->hasError('birth_date')) { ?>
                    is-invalid
                <?php } ?>" id="birth_date" name="birth_date" autocomplete="off" value="<?= $me['birth_date'] ?>">

                <?php if ($validation->hasError('birth_date')) { ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('birth_date') ?>
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