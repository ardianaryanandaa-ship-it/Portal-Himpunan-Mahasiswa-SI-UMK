
# Portal Himpunan Mahasiswa Sistem Informasi UMK

Website Portal Himpunan Mahasiswa Sistem Informasi Universitas Muria Kudus.

## Pengelolaan Konten Frontend

Masuk ke backend melalui `/login`.

Akun tidak dapat didaftarkan melalui website. Buat akun melalui terminal proyek menggunakan perintah:

```bash
php spark users:create
```

Setiap pengguna aktif yang berhasil login memiliki akses ke dashboard backend dan dapat:
- Melihat serta mengelola aspirasi yang dikirim pengunjung.
- Mengubah status aspirasi menjadi menunggu, dibaca, selesai, atau ditolak.
- Menampilkan atau menghentikan tampilan aspirasi pada landing page.
- Menghapus aspirasi yang tidak diperlukan.

Aspirasi dapat dikirim melalui formulir pada bagian Aspirasi di landing page. Data yang tersedia mencakup nama, NIM, email, nomor telepon, kategori, judul, pesan, serta pilihan anonim.

Untuk gambar dan video, gunakan path file relatif dari folder `public`, misalnya:

```text
gambar/kegiatan.jpg
```

## Teknologi yang Digunakan

- PHP
- CodeIgniter 4
- MySQL
- HTML
- CSS
- JavaScript
- Bootstrap

## Instalasi

1. Clone repository:

```bash
git clone https://github.com/ardianaryanandaa-ship-it/Portal-Himpunan-Mahasiswa-SI-UMK.git
```

2. Masuk ke folder project:

```bash
cd Portal-Himpunan-Mahasiswa-SI-UMK
```

3. Install dependency:

```bash
composer install
```

4. Salin file `env` menjadi `.env`.

5. Sesuaikan konfigurasi database dan `baseURL` pada `.env`.

6. Jalankan aplikasi:

```bash
php spark serve
```

## Repository

GitHub: https://github.com/ardianaryanandaa-ship-it/Portal-Himpunan-Mahasiswa-SI-UMK
