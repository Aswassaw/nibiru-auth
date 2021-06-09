<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('style'); ?>
<link rel="stylesheet" href="/package/dropify/css/dropify.css">
<?= $this->endSection('style'); ?>


<?= $this->section('content'); ?>
<!-- Error Alert untuk avatar -->
<?php if (session()->get('avatar')) : ?>
    <?php foreach (session()->get('avatar') as $avt) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $avt ?>
        </div>
    <?php } ?>
<?php endif; ?>

<div class="card mx-auto" style="max-width: 555px;">
    <div class="card-header">
        <h5 class="my-auto mx-auto text-center">Ubah Avatar <a href="<?= route_to('user_profile', $user['slug']) ?>" class="link"><?= $user['username'] ?></a></h5>
    </div>
    <div class="card-body">
        <form action="<?= route_to('admin_change_user_avatar', $user['id']) ?>" method="post" enctype="multipart/form-data">
            <!-- CSRF -->
            <?= csrf_field(); ?>
            <!-- Method Spoofing -->
            <input type="hidden" name="_method" value="PATCH" />

            <!-- Avatar Baru -->
            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar baru</label>
                <div class="mb-3">
                    <input type="file" class="form-control dropify" id="avatar" name="avatar" data-height="300">
                </div>
            </div>

            <!-- Submit -->
            <hr>
            <input type="submit" class="btn btn-success" value="Update">
        </form>
    </div>
</div>
<?= $this->endSection('content'); ?>


<?= $this->section('script'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/package/dropify/js/dropify.js"></script>
<script src="/package/dropify/js/dropify.min.js"></script>
<script src="/assets/js/dropify.js"></script>
<?= $this->endSection('script'); ?>