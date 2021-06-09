<!-- Selesai Peninjauan -->
<?php if (session()->get('success')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->get('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->get('error')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->get('error') ?>
    </div>
<?php endif; ?>