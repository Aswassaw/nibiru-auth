<!-- Selesai Peninjauan -->
<div class="modal fade" id="modalAdminPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAdminPasswordLabel">Masukkan Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route_to('verify_password') ?>" method="post">
                    <!-- CSRF -->
                    <?= csrf_field(); ?>

                    <!-- Diperlukan -->
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="hidden" name="type" value="<?= $type ?>">
                    <input type="hidden" name="action" value="<?= $action ?>">
                    <input type="hidden" name="prevUrl" value="<?= $prevUrl ?>">

                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" maxlength="100" minlength="6" autofocus required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Kirim">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>