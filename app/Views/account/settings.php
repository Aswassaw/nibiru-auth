<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<h2 class="text-center mb-3">Settings</h2>
<hr class="mx-auto" style="max-width: 800px;">
<div class="card card-body mb-3 mx-auto" style="max-width: 800px;">
    <h3>User Log</h3>
    <hr>
    <div class="card my-2">
        <div class="card-body">
            <h5>Log Aktivitas</h5>
            <hr>
            <a href="<?= route_to('user_activity_log') ?>" class="btn btn-primary">Lihat</a>
        </div>
    </div>
    <div class="card my-2">
        <div class="card-body">
            <h5>Log Masuk</h5>
            <hr>
            <a href="<?= route_to('user_login_log') ?>" class="btn btn-primary">Lihat</a>
        </div>
    </div>
</div>

<div class="card card-body mt-3 border-danger mx-auto" style="max-width: 800px;">
    <h3>Danger Zone</h3>
    <hr>
    <div class="card my-2">
        <div class="card-body">
            <h5>Hapus Akun</h5>
            <hr>
            <form method="post" action="<?= route_to('delete_user_account') ?>" id="delete_user">
                <!-- CSRF -->
                <?= csrf_field(); ?>
                <!-- Method Spoofing -->
                <input type="hidden" name="_method" value="DELETE" />

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Masukkan Password</label>
                    <input type="password" class="form-control" name="password" maxlength="100" minlength="6" required>
                </div>

                <!-- Submit -->
                <input type="submit" class="btn btn-danger" value="Hapus">
            </form>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>


<?= $this->section('script') ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    document.getElementById('delete_user').addEventListener('submit', (e) => {
        e.preventDefault();

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak akan dapat membatalkan tindakan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete_user').submit();
            }
        })
    })
</script>
<?= $this->endSection('script'); ?>