<!-- Selesai Peninjauan -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="<?= base_url('/') ?>" class="navbar-brand">
            <img src="<?= base_url() ?>/assets/img/logo/logo50px.png" class="d-inline-block align-top" alt="Logo <?= APP_NAME ?>" height="30" width="30">
            <?= APP_NAME ?>
        </a>
        <button type="button" class="navbar-toggler" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar before login -->
            <?= $this->include('layout/nav/nav-left'); ?>
            <!-- Navbar after login -->
            <?= $this->include('layout/nav/nav-right'); ?>
        </div>
    </div>
</nav>