<!-- Selesai Peninjauan -->
<?php if (isset($me)) { ?>
    <?php if (!$me['email_verified_at']) { ?>
        <div class="alert alert-danger" role="alert">
            <form action="<?= route_to('resend_register_email_after_login') ?>" method="post">
                <!-- CSRF -->
                <?= csrf_field(); ?>

                Akun Anda belum terverifikasi, <button class="btn btn-link p-0 m-0 align-baseline" type="submit">kirim link verifikasi baru.</button>
            </form>
        </div>
    <?php } ?>
<?php } ?>