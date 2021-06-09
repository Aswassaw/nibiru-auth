<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('style'); ?>
<link rel="stylesheet" href="/package/dropify/css/dropify.css">

<style>
    .user-data {
        background-color: #f0f3f5;
        padding: 8px;
        color: #2D3436;
        border-radius: 5px;
    }
</style>
<?= $this->endSection('style'); ?>


<?= $this->section('content'); ?>
<!-- Error Alert untuk avatar -->
<?php if (session()->get('avatar')) { ?>
    <?php foreach (session()->get('avatar') as $avt) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $avt ?>
        </div>
    <?php } ?>
<?php } ?>

<div class="card">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="<?= base_url(AVATAR_400 . $user['avatar']) ?>" class="img-fluid mx-auto d-block img-thumbnail" alt="Avatar <?= $user['username'] ?? 'user' ?>">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">Data lengkap <strong><a class="link" href="<?= route_to('user_profile', $user['slug']) ?>"><?= $user['username'] ?></a></strong></h5>
                <div class="card">
                    <div class="card-body">
                        <div class="user-data my-1">- Nama: <strong><?= $user['fullname'] ?></strong></div>
                        <div class="user-data my-1">- Email: <strong><?= $user['email'] ?></strong></div>
                        <div class="user-data my-1">- Tanggal Lahir:
                            <strong>
                                <?php if ($user['birth_date']) { ?>
                                    <?= $user['birth_date'] ?> (<?= $user['age'] ?> Tahun)
                                <?php } else { ?>
                                    Tidak diketahui
                                <?php } ?>
                            </strong>
                        </div>
                        <div class="user-data my-1">- Bergabung Pada: <strong><?= $user['created_at'] ?></strong></div>
                    </div>
                </div>

                <?php if ($user['id'] == session()->get('id')) { ?>
                    <a href="<?= route_to('show_change_user_data_form') ?>" class="btn btn-primary mt-2">Ubah Data</a>
                    <a class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#avatarModal">Ubah Avatar</a>
                    <a href="<?= route_to('show_change_user_password_form') ?>" class="btn btn-danger mt-2">Ubah Password</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="avatarModal" aria-hidden="true" aria-labelledby="avatarModalLabel" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">Ubah Avatar</h5>
                <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route_to('change_user_avatar') ?>" method="post" enctype="multipart/form-data">
                    <!-- CSRF -->
                    <?= csrf_field(); ?>
                    <!-- Method Spoofing -->
                    <input type="hidden" name="_method" value="PATCH" />

                    <!-- Avatar -->
                    <div class="mb-3">
                        <input class="form-control dropify" type="file" data-height="300" name="avatar" id="avatar">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Update">
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>


<?= $this->section('script'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/package/dropify/js/dropify.js"></script>
<script src="/package/dropify/js/dropify.min.js"></script>
<script src="/assets/js/dropify.js"></script>
<?= $this->endSection('script'); ?>