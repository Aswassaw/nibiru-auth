<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Aplikasi Sistem Login Lengkap Menggunakan CodeIgniter 4.1.2 dan Bootstrap 5.0.1">
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP, CodeIgniter 4, Bootstrap 5">
    <meta name="author" content="Andry Pebrianto">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/font.css">
    <style>
        * {
            font-family: "poppinsregular", arial, sans-serif;
        }

        .auth-title {
            text-align: center;
        }

        .auth-content {
            border: 2px solid #0a1d37;
            border-radius: 3px;
            line-height: 30px;
            max-width: 800px;
            margin: 0 auto;
            padding: 25px;
        }

        .auth-button {
            background-color: #293b5f;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            font-weight: bold;
            margin: 0 auto;
            padding: 5px;
            display: block;
            width: 150px;
        }
    </style>

    <title>Verify Email</title>
</head>

<body style="background-color: #deedf0; padding: 20px;">
    <h1 class="auth-title"><?= APP_NAME ?></h1>

    <div class="auth-content" style="background-color: white;">
        <p style="font-size: 20px;">Halo!</p>

        <hr>

        <p>
            Anda menerima email ini karena Anda telah melakukan registrasi akun di <a href="<?= base_url() ?>"><?= APP_NAME ?></a>.
            <br>
            Segera verifikasi akun Anda dengan menekan tombol di bawah ini.
        </p>

        <a href="<?= $url ?>" style="color: white;" class="auth-button">Verifikasi Akun</a>

        <p>
            Link verifikasi akun tersebut akan kedaluwarsa dalam 30 menit.
            <br>
            Jika Anda tidak merasa melakukan hal tersebut, abaikan email ini.
        </p>

        <hr>

        <p>Jika Anda memiliki masalah dengan tombol di atas, Anda dapat menggunakan link berikut ini: <a href="<?= $url ?>"><?= $url ?></a></p>
    </div>
</body>

</html>