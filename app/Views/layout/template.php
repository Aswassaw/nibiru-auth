<!-- Selesai Peninjauan -->
<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Aplikasi Sistem Login Lengkap Menggunakan CodeIgniter 4.1.2 dan Bootstrap 5.0.1">
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP, CodeIgniter 4, Bootstrap 5">
    <meta name="author" content="Andry Pebrianto">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Optional CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/font.css">

    <!-- Suatu page dapat merender style jika dibutuhkan -->
    <?= $this->renderSection('style') ?>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/package/bootstrap5/css/bootstrap.min.css">

    <title><?= $title ?? APP_NAME ?></title>
</head>

<body>
    <!-- Navbar -->
    <?= $this->include('layout/navbar'); ?>

    <br>

    <!-- Content -->
    <div class="container">
        <?= $this->include('layout/other/unverified'); ?>
        <?= $this->include('layout/other/flashdata'); ?>
        <?= $this->renderSection('content'); ?>
    </div>

    <br>

    <!-- Optional JavaScript -->
    <script src="<?= base_url() ?>/assets/js/manipulate.js"></script>

    <!-- Suatu page dapat merender script jika dibutuhkan -->
    <?= $this->renderSection('script') ?>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="<?= base_url() ?>/package/bootstrap5/js/bootstrap.bundle.min.js"></script>
</body>

</html>