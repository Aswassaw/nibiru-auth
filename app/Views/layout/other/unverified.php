<!-- Selesai Peninjauan -->
<?php if (isset($me)) { ?>
    <?php if (!$me['email_verified_at']) { ?>
        <div class="alert alert-danger" role="alert">
            <form action="<?= base_url('account/resend-register-email') ?>" method="post">
                <!-- CSRF -->
                <?= csrf_field(); ?>

                Akun Anda belum terverifikasi, <button class="btn btn-link p-0 m-0 align-baseline" type="submit">kirim link verifikasi baru.</button>
            </form>
        </div>
    <?php } ?>
<?php } ?>