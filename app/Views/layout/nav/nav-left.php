<!-- Selesai Peninjauan -->
<?php $uri = service('uri'); ?>

<?php if (!session()->get('isLoggedIn')) { ?>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a href="<?= route_to('show_login_form') ?>" class="nav-link <?= ($uri->getSegment(1) == 'auth' && $uri->getSegment(2) == 'login') ? 'active' : null ?>">Log In</a>
        </li>
        <li class="nav-item">
            <a href="<?= route_to('show_register_form') ?>" class="nav-link <?= ($uri->getSegment(1) == 'auth' && $uri->getSegment(2) == 'register') ? 'active' : null ?>">Create an Account</a>
        </li>
    </ul>
<?php } else { ?>
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a href="<?= base_url('home') ?>" class="nav-link <?= ($uri->getSegment(1) == 'home') ? 'active' : null ?>">Home</a>
        </li>
        <?php if ($me['role'] == 1 || $me['role'] == 2) { ?>
            <li class="nav-item">
                <a href="<?= route_to('admin_page') ?>" class="nav-link <?= ($uri->getSegment(1) == 'admin' && $uri->getSegment(2) == '' || $uri->getSegment(1) == 'admin' && preg_match('@[\w]+@', $uri->getSegment(2))) ? 'active' : null ?>">Admin</a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>