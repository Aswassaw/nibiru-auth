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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>