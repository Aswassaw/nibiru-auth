<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="card mx-auto" style="max-width: 555px;">
    <div class="card-header">
        <h5 class="my-auto mx-auto text-center">Tambah Data User Baru</h5>
    </div>
    <div class="card-body">
        <form action="<?= route_to('admin_insert_user_data') ?>" method="post">
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

            <!-- Submit -->
            <hr>
            <input type="submit" class="btn btn-success" value="Insert">
        </form>
    </div>
</div>
<?= $this->endSection('content'); ?>