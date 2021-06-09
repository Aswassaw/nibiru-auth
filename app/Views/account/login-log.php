<!-- Selesai Peninjauan -->
<?= $this->extend('layout/template'); ?>


<?= $this->section('style'); ?>
<style>
    .loginlog {
        transition: 0.3s;

    }

    .loginlog:hover {
        background-color: #f0f3f5;
        transform: scale(1.005);
    }

    small {
        font-size: 13px;
        color: gray;
    }
</style>
<?= $this->endSection('style'); ?>


<?= $this->section('content'); ?>
<div class="card mx-auto" style="max-width: 800px;">
    <div class="card-body">
        <h3 class="text-center">Log Masuk</h3>
        <hr>
        <div class="row">
            <div class="col-12 col-sm-6 float-right">
                <h4>
                    Jumlah Log ditemukan:
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
        <?php if (!$loginlogs) { ?>
            <h5>Tidak ditemukan aktivitas apapun.</h5>
        <?php } else { ?>
            <?php $no = 1 + (10 * ($current_page - 1));
            foreach ($loginlogs as $lgn) { ?>
                <div class="card card-body my-2 loginlog">
                    <?= $no++ ?>. Detail Log:
                    <div>
                        - IP Address: <strong><?= $lgn['ip'] ?></strong>
                        <br>
                        - Browser: <strong><?= $lgn['browser'] ?></strong>
                        <br>
                        - Platform: <strong><?= $lgn['platform'] ?></strong>
                    </div>
                    <small><?= $lgn['created_at'] ?></small>
                </div>
            <?php } ?>
        <?php } ?>
        <hr>
        <!-- Link pagination -->
        <?= $pager->links('loginlogs', 'pagination') ?>
    </div>
</div>
<?= $this->endSection('content'); ?>