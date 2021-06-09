<!-- Selesai Peninjauan -->
<?php $uri = service('uri'); ?>

<?php if (session()->get('isLoggedIn')) { ?>
    <ul class="navbar-nav">
        <li class=" nav-item dropdown active">
            <a class="nav-link dropdown-toggle <?= ($uri->getSegment(1) == 'account' && preg_match('@[\w]+@', $uri->getSegment(2))) ? 'active' : null ?>" id="navbarScrollingDropdown" role="button" aria-expanded="false" data-bs-toggle="dropdown">
                <img src="<?= base_url(AVATAR_100 . $me['avatar']) ?>" class="rounded-circle" alt="Avatar <?= $me['username'] ?? 'user' ?>" height="30px" width="30px">
                <p style="display: inline;" id="nav-name"><?= $me['username'] ?></p>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarScrollingDropdown">
                <a href="<?= route_to('user_profile', $me['slug']) ?>" class="dropdown-item">
                    <img src="<?= base_url(AVATAR_100 . $me['avatar']) ?>" class="rounded-circle" alt="Avatar <?= $me['username'] ?? 'user' ?>" height="55px" width="55px">
                    <?= $me['username'] ?>
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= route_to('user_settings') ?>" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a>
                <div class="dropdown-divider"></div>
                <form action="<?= base_url('auth/logout') ?>" method="post">
                    <!-- CSRF -->
                    <?= csrf_field(); ?>

                    <!-- Submit -->
                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Log out</button>
                </form>
            </ul>
        </li>
    </ul>
<?php } ?>