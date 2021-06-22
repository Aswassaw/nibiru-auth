<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="row">
    <div class="col mx-auto text-center">
        <div class="card">
            <div class="card-body">
                <h1>Verifikasi Akun Anda!</h1>
                <hr>
                <p>Kami telah mengirimkan email berisi link verifikasi untuk <strong><?= session()->get('verify_register_email') ?></strong>, mohon verifikasikan akun Anda sebelum 30 menit sejak kami mengirimkan email tersebut kepada Anda.</p>
                <button type="button" class="btn btn-primary mb-2" aria-controls="form_new_verify" aria-expanded="false" data-bs-target="#form_new_verify" data-bs-toggle="collapse">
                    Kirim Link Baru
                </button>
                <div class="collapse<?= $validation->hasError('email') ? '.show' : null ?>" id="form_new_verify">
                    <div class="card card-body">
                        <form action="<?= base_url('auth/verify-register-alert') ?>" method="post">
                            <!-- CSRF -->
                            <?= csrf_field(); ?>

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

                            <!-- Submit -->
                            <input type="submit" class="btn btn-success" value="Kirim Ulang">
                        </form>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <h5>Log In Sekarang</h5>
                        <a href="<?= base_url('auth/login') ?>" class="btn btn-primary">Log In</a>
                    </div>
                    <div class="col">
                        <h5>Register Sekarang</h5>
                        <a href="<?= base_url('auth/register') ?>" class="btn btn-danger">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>