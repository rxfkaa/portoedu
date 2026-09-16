# PortoEdu

PortoEdu adalah aplikasi portofolio digital sekolah berbasis Laravel. Siswa dapat menyimpan karya dan prestasi, guru memverifikasi konten, dan admin mengelola akun, kelas, serta jurusan.

## Fitur utama

- Registrasi siswa/guru dengan persetujuan admin
- Dashboard terpisah untuk siswa, guru, dan admin
- CRUD prestasi, sertifikat, proyek, organisasi, skill, magang, serta galeri
- Review proyek dan verifikasi prestasi/sertifikat oleh guru
- Portfolio publik, direktori siswa, QR code, dan ekspor PDF
- Notifikasi, reset password, tema/dark mode, serta bahasa Indonesia/Inggris

## Menjalankan untuk demo lokal

1. Nyalakan Apache dan MySQL dari XAMPP.
2. Salin `.env.example` menjadi `.env`, lalu isi koneksi MySQL. Contoh:

   ```env
   APP_NAME=PortoEdu
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost/PortoEdu/public

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=portoedu
   DB_USERNAME=root
   DB_PASSWORD=

   FILESYSTEM_DISK=public
   ```

3. Jalankan perintah berikut:

   ```powershell
   composer install
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   php artisan optimize:clear
   ```

4. Buka `http://localhost/PortoEdu/public`.

## Akun demo

Semua akun demo menggunakan password `password`.

| Role | Email |
| --- | --- |
| Admin | `admin@dsp.test` |
| Guru | `guru@dsp.test` |
| Siswa | `siswa@dsp.test` |

## Skenario presentasi

1. Tampilkan landing page dan direktori siswa publik.
2. Masuk sebagai siswa, buat prestasi atau proyek, lalu tampilkan portfolio publik/QR/PDF.
3. Masuk sebagai guru untuk memverifikasi prestasi atau memberi komentar proyek.
4. Masuk sebagai admin untuk meninjau pendaftaran, menyetujui/menolak akun, dan mengelola kelas atau jurusan.

## Checklist publish/hosting

1. Buat database MySQL dan impor aplikasi ke hosting.
2. Atur `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://domain-kamu`, dan kredensial database/SMTP production.
3. Pastikan document root domain mengarah ke folder `public`.
4. Jalankan:

   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

5. Aktifkan HTTPS dan uji upload file, reset password, portfolio publik, serta tiap role setelah deploy.

Jangan gunakan akun demo dan password demo untuk instalasi production.
