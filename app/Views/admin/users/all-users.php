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
<h2 class="text-center">Daftar User</h2>
<hr>
<a class="btn btn-primary mb-3" href="<?= route_to('admin_show_insert_user_data_form') ?>" role="button">Tambah User</a>
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
                                <td><a class="link" href="<?= route_to('user_profile', $usr['slug']) ?>"><?= $usr['username'] ?></a></td>
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
                                                <?php if ($usr['role'] == 2) { ?>
                                                    <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'become-user')">Jadikan User</a></li>
                                                    <hr class="dropdown-divider">
                                                <?php } else if ($usr['role'] == 3) { ?>
                                                    <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'become-admin')">Jadikan Admin</a></li>
                                                    <hr class="dropdown-divider">
                                                <?php } ?>
                                                <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'update-data')">Update Data</a></li>
                                                <hr class="dropdown-divider">
                                                <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'update-password')">Update Password</a></li>
                                                <hr class="dropdown-divider">
                                                <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'update-avatar')">Update Avatar</a></li>
                                                <?php if (!$usr['deleted_at']) { ?>
                                                    <hr class="dropdown-divider">
                                                    <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'delete-account')">Delete Account</a></li>
                                                <?php } else { ?>
                                                    <hr class="dropdown-divider">
                                                    <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'restore-account')">Restore Account</a></li>
                                                <?php } ?>

                                                <!-- Jika user adalah admin -->
                                            <?php } elseif ($me['role'] == 2) { ?>
                                                <?php if ($usr['role'] == 3 || $usr['id'] == session()->get('id')) { ?>
                                                    <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'update-data')">Update Data</a></li>
                                                    <hr class="dropdown-divider">
                                                    <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'update-password')">Update Password</a></li>
                                                    <hr class="dropdown-divider">
                                                    <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'update-avatar')">Update Avatar</a></li>
                                                    <?php if (!$usr['deleted_at']) { ?>
                                                        <hr class="dropdown-divider">
                                                        <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'delete-account')">Delete Account</a></li>
                                                    <?php } else { ?>
                                                        <hr class="dropdown-divider">
                                                        <li><a class="dropdown-item" onclick="verifyPassword(<?= $usr['id'] ?>, 'restore-account')">Restore Account</a></li>
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

<!-- CSRF untuk ajax request -->
<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

<div class="success_modal" style="display: none;"></div>
<?= $this->endSection('content'); ?>


<?= $this->section('script'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    function verifyPassword(id, action) {
        // CSRF Hash
        let csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
        let csrfHash = $('.txt_csrfname').val(); // CSRF hash

        // Mengirimkan request ajax
        $.ajax({
            type: 'post',
            url: '<?= route_to('modal_password') ?>',
            data: {
                [csrfName]: csrfHash,
                id: id,
                type: 'user',
                action: action,
                prevUrl: '<?= (string)current_url(true) ?>',
            },
            dataType: 'json',
            // Success
            success: function(response) {
                // Update CSRF hash
                $('.txt_csrfname').val(response.token);

                if (response.success) {
                    $('.success_modal').html(response.success).show();
                    $('#modalAdminPassword').modal('show');
                }
            },
            // Error
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }
</script>
<?= $this->endSection('script'); ?>