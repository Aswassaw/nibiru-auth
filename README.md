# Nibiru Login

## Apa itu Nibiru Login?
Nibiru Login adalah sebuah aplikasi sistem login lengkap yang dibuat dengan tujuan untuk mempercepat proses pembuatan aplikasi CodeIgniter 4 yang membutuhkan sebuah sistem login yang lengkap. Nibiru Login dibuat menggunakan CodeIgniter 4.1.2 dan Bootstrap 5.0.1. Versi ini adalah pengembangan dari versi sebelumnya, dimana pada versi ini ada banyak peningkatan fitur dari versi sebelumnya.

## Fitur-fitur pada Nibiru Login
Nibiru Login memiliki 3 macam role (Super Admin, Admin, dan User), dimana untuk setiap role memiliki fitur yang berbeda pula.

### Fitur untuk role Super Admin (1):
- Login dan Logout.
- Forgot password dengan link lewat Email.
- Update Data Pribadi.
- Update Password.
- Update Avatar.
- Menambahkan Data User Baru sebagai SuperAdmin.
- Update Data Pribadi User dan Admin sebagai SuperAdmin.
- Update Password User dan Admin sebagai SuperAdmin.
- Update Avatar User dan Admin sebagai SuperAdmin.
- Mengubah User menjadi Admin.
- Mengubah Admin menjadi User.
- Menghapus akun Admin dan User.
- Merestore akun Admin dan User.

### Fitur untuk role Admin (2):
- Login dan Logout.
- Forgot password dengan link lewat Email.
- Update Data Pribadi.
- Update Password.
- Update Avatar.
- Menambahkan Data User Baru sebagai Admin.
- Update Data Pribadi User sebagai Admin.
- Update Password User sebagai Admin.
- Update Avatar User sebagai Admin.
- Menghapus akun User.
- Merestore akun User.

### Fitur untuk role User (3):
- Login dan Logout.
- Forgot password dengan link lewat Email.
- Update Data Pribadi.
- Update Password.
- Update Avatar.

### Fitur Lain:
- Register.
- Menggunakan SoftDeletes.
- Search dan Pagination.
- Filter Search.
- Log Aktivitas.
- Log Masuk.
- Migration dan Seeder menggunakan Faker.
- Terdapat 20 halaman keseluruhan.

### Fitur keamanan:
- CSRF.
- Throttle 30 request/menit.
- Honeypot.

## Cara penggunaan Nibiru Login
- Pastikan composer terinstall.
- Pastikan versi PHP yang terinstall adalah versi `7.4` ke atas.
- Clone repository ini.
- Jalankan `composer install`.
- Ubah file `env` menjadi `.env`, atau gunakan konfigurasi milik Anda sendiri.
- Konfigurasikan email Anda di `App\Config\Email.php`, ubah isi property `$SMTPUser` dengan email Anda dan `$SMTPPass` dengan password email Anda.
- Ubah nama pengirim email di `App\Config\Constants.php`. Cari const EMAIL lalu ubah isinya dengan nama pengirim email yang anda inginkan.
- Buat database bernama `nibiru-login`.
- Migrate menggunakan `php spark migrate`.
- Seeding menggunakan `php spark db:seed Users`.
- Jika Anda ingin menambahkan beberapa user dummy untuk percobaan, Seeding menggunakan `php spark db:seed UsersSample`.
- Jalankan `php spark serve`.
- Akun default yang tersedia untuk login:

  ### Super Admin:
  - Username: superadmin
  - Password: Superadmin123
  
  ### Admin:
  - Username: admin
  - Password: Admin123

  ### User:
  - Username: user
  - Password: User123

## Bantuan
Jika Anda membutuhkan bantuan, hubungi saya di email: andrypeb27@protonmail.com atau andrypeb227@gmail.com.
