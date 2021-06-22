<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('style'); ?>
<style>
    /* Mengatur agar text di dalam table akan berada di tengah secara vertikal */
    .table>tbody>tr>* {
        vertical-align: middle;
    }
</style>
<?= $this->endSection('style'); ?>


<?= $this->section('content'); ?>
<!-- Membuat session current_url -->
<?php session()->set('current_url', (string)current_url(true)) ?>

<h2 class="text-center">Daftar User</h2>
<hr>
<div class="row my-2">
    <div class="col-12 col-sm-6">
        <a class="btn btn-primary mb-3" href="<?= base_url('admin/user/insert-data') ?>" role="button">Tambah User</a>
    </div>
    <div class="col-12 col-sm-6">
        <div class="row">
            <div class="col-md-3 mt-1">
                <label for="filter">
                    <h4><i class="fas fa-filter"></i> Filter</h4>
                </label>
            </div>
            <div class="col-md-9">
                <form action="<?= base_url('admin/user/all-user') ?>" method="post">
                    <!-- CSRF -->
                    <?= csrf_field(); ?>

                    <select name="filter" id="filter" class="form-control">
                        <option value="Tidak">Semua</option>
                        <option <?= "Admin" == session()->get('filter') ? 'selected=selected' : null ?> value="Admin">Admin</option>
                        <option <?= "User" == session()->get('filter') ? 'selected=selected' : null ?> value="User">User</option>
                        <option <?= "Diaktifkan" == session()->get('filter') ? 'selected=selected' : null ?> value="Diaktifkan">Diaktifkan</option>
                        <option <?= "Belum Diaktifkan" == session()->get('filter') ? 'selected=selected' : null ?> value="Belum Diaktifkan">Belum Diaktifkan</option>
                        <option <?= "Dihapus" == session()->get('filter') ? 'selected=selected' : null ?> value="Dihapus">Dihapus</option>
                    </select>
                    <button id="filter-submit" style="display:none;" type="submit"></button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-6 float-right">
                <h4>
                    Jumlah User ditemukan: <?= $users_count ?>
                </h4>
            </div>
            <div class="col-12 col-sm-6 float-right">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="search" class="form-control" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : null ?>" name="keyword" placeholder="Masukkan kata kunci pencarian" maxlength="500" autocomplete="off" autofocus>
                        <div class="input-group-append">
                            <input class="btn btn-success fas" type="submit" value="Cari">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="table-responsive mt-4">
            <?php if (!$users) { ?>
                <h5>Tidak ditemukan satu pun user.</h5>
            <?php } else { ?>
                <table class="table table-hover">
                    <!-- Table Head -->
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Avatar</th>
                            <th>Tanggal<div style="display: inline; opacity: 0;">_</div>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <!-- table Body -->
                    <tbody>
                        <?php $no = 1 + (10 * ($current_page - 1));
                        foreach ($users as $usr) { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><a class="link" href="<?= base_url('account/profile/' . $usr['slug']) ?>"><?= $usr['username'] ?></a></td>
                                <td><?= $usr['email'] ?></td>
                                <td>
                                    <?php if ($usr['deleted_at']) { ?>
                                        Dihapus
                                    <?php } elseif ($usr['email_verified_at']) { ?>
                                        Aktif
                                    <?php } else { ?>
                                        Belum Aktif
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($usr['role'] == 1) { ?>
                                        Super Admin
                                    <?php } elseif ($usr['role'] == 2) { ?>
                                        Admin
                                    <?php } else { ?>
                                        User
                                    <?php } ?>
                                </td>
                                <td>
                                    <img src="<?= base_url(AVATAR_400 . $usr['avatar']) ?>" alt="Avatar <?= $usr['username'] ?>" height="90px" width="90px">
                                </td>
                                <td><?= $usr['created_at'] ?></td>
                                <td>
                                    <div class="dropstart">
                                        <button type="button" class="btn btn-danger dropdown-toggle" id="dropdownAksi<?= $usr['id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownAksi<?= $usr['id'] ?>">
                                            <!-- Jika user adalah super admin -->
                                            <?php if ($me['role'] == 1) { ?>
                                                <li><a href="<?= base_url('admin/user/change-data/' . $usr['id']) ?>" class="dropdown-item">Update Data</a></li>
                                                <hr class="dropdown-divider">
                                                <li><a href="<?= base_url('admin/user/change-password/' . $usr['id']) ?>" class="dropdown-item">Update Password</a></li>
                                                <hr class="dropdown-divider">
                                                <li><a href="<?= base_url('admin/user/change-avatar/' . $usr['id']) ?>" class="dropdown-item">Update Avatar</a></li>
                                                <!-- Ubah Role -->
                                                <?php if ($usr['role'] == 2) { ?>
                                                    <hr class="dropdown-divider">
                                                    <li>
                                                        <form action="<?= base_url('admin/user/become-user/' . $usr['id']) ?>" method="post">
                                                            <!-- CSRF -->
                                                            <?= csrf_field(); ?>
                                                            <!-- Method Spoofing -->
                                                            <input type="hidden" name="_method" value="PATCH" />

                                                            <!-- Submit -->
                                                            <button type="submit" class="dropdown-item">Jadikan User</button>
                                                        </form>
                                                    </li>
                                                <?php } else if ($usr['role'] == 3) { ?>
                                                    <hr class="dropdown-divider">
                                                    <li>
                                                        <form action="<?= base_url('admin/user/become-admin/' . $usr['id']) ?>" method="post">
                                                            <!-- CSRF -->
                                                            <?= csrf_field(); ?>
                                                            <!-- Method Spoofing -->
                                                            <input type="hidden" name="_method" value="PATCH" />

                                                            <!-- Submit -->
                                                            <button type="submit" class="dropdown-item">Jadikan Admin</button>
                                                        </form>
                                                    </li>
                                                <?php } ?>
                                                <!-- Delete dan Restore -->
                                                <?php if (!$usr['deleted_at']) { ?>
                                                    <hr class="dropdown-divider">
                                                    <li>
                                                        <form action="<?= base_url('admin/user/delete-account/' . $usr['id']) ?>" method="post">
                                                            <!-- CSRF -->
                                                            <?= csrf_field(); ?>
                                                            <!-- Method Spoofing -->
                                                            <input type="hidden" name="_method" value="PATCH" />

                                                            <!-- Submit -->
                                                            <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin?')">Delete Account</button>
                                                        </form>
                                                    </li>
                                                <?php } else { ?>
                                                    <hr class="dropdown-divider">
                                                    <li>
                                                        <form action="<?= base_url('admin/user/restore-account/' . $usr['id']) ?>" method="post">
                                                            <!-- CSRF -->
                                                            <?= csrf_field(); ?>
                                                            <!-- Method Spoofing -->
                                                            <input type="hidden" name="_method" value="PATCH" />

                                                            <!-- Submit -->
                                                            <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin?')">Restore Account</button>
                                                        </form>
                                                    </li>
                                                <?php } ?>

                                                <!-- Jika user adalah normal admin -->
                                            <?php } elseif ($me['role'] == 2) { ?>
                                                <?php if ($usr['role'] == 3 || $usr['id'] == session()->get('id')) { ?>
                                                    <li><a href="<?= base_url('admin/user/change-data/' . $usr['id']) ?>" class="dropdown-item">Update Data</a></li>
                                                    <hr class="dropdown-divider">
                                                    <li><a href="<?= base_url('admin/user/change-password/' . $usr['id']) ?>" class="dropdown-item">Update Password</a></li>
                                                    <hr class="dropdown-divider">
                                                    <li><a href="<?= base_url('admin/user/change-avatar/' . $usr['id']) ?>" class="dropdown-item">Update Avatar</a></li>
                                                    <!-- Delete dan Restore -->
                                                    <?php if (!$usr['deleted_at']) { ?>
                                                        <hr class="dropdown-divider">
                                                        <li>
                                                            <form action="<?= base_url('admin/user/delete-account/' . $usr['id']) ?>" method="post">
                                                                <!-- CSRF -->
                                                                <?= csrf_field(); ?>
                                                                <!-- Method Spoofing -->
                                                                <input type="hidden" name="_method" value="PATCH" />

                                                                <!-- Submit -->
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin?')">Delete Account</button>
                                                            </form>
                                                        </li>
                                                    <?php } else { ?>
                                                        <hr class="dropdown-divider">
                                                        <li>
                                                            <form action="<?= base_url('admin/user/restore-account/' . $usr['id']) ?>" method="post">
                                                                <!-- CSRF -->
                                                                <?= csrf_field(); ?>
                                                                <!-- Method Spoofing -->
                                                                <input type="hidden" name="_method" value="PATCH" />

                                                                <!-- Submit -->
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin?')">Restore Account</button>
                                                            </form>
                                                        </li>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <li><a class="dropdown-item" href="#">Nothing</a></li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
            <hr>
            <!-- Link pagination -->
            <?= $pager->links('users', 'pagination') ?>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>


<?= $this->section('script'); ?>
<script>
    // Event ketika filter diganti
    let filter = document.getElementById('filter');
    // Jika elemen filter ada
    if (filter !== null) {
        filter.addEventListener('change', () => document.getElementById('filter-submit').click());
    }
</script>
<?= $this->endSection('script'); ?>