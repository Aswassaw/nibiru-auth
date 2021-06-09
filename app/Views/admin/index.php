<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<h3>Selamat datang admin <a href="<?= route_to('user_profile', $me['slug']) ?>" class="link"><?= $me['username'] ?></a></h3>
<hr>
<div class="card card-body">
    <div class="row row-cols-1 row-cols-md-3">
        <div class="col my-2">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">User</h5>
                    <hr>
                    <p class="card-text">
                        <strong><?= $users_count ?></strong> User ditemukan,
                        <strong><?= $users_deleted_count ?></strong> dihapus.
                    </p>
                    <a class="btn btn-primary" href="<?= route_to('show_all_user') ?>">Atur</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>