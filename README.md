# Sistem Perpustakaan

Sistem manajemen perpustakaan digital yang dibangun dengan Laravel framework. Sistem ini menyediakan fitur-fitur lengkap untuk mengelola koleksi buku, peminjaman, reservasi, dan aktivitas perpustakaan.

## Fitur Utama

- 📚 **Manajemen Buku**: Tambah, edit, hapus, dan kelola koleksi buku
- 📖 **Kategori Buku**: Organisasi buku berdasarkan kategori
- 👥 **Manajemen User**: Sistem user dengan role admin dan anggota
- 📋 **Peminjaman**: Sistem peminjaman buku dengan tracking status
- 📅 **Reservasi**: Sistem reservasi buku untuk anggota
- ⭐ **Review Buku**: Sistem review dan rating buku
- 📊 **Laporan**: Laporan aktivitas dan statistik perpustakaan
- ⚙️ **Pengaturan**: Konfigurasi sistem dan perpustakaan
- 📝 **Log Aktivitas**: Tracking semua aktivitas sistem

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL/MariaDB atau SQLite
- Node.js & NPM (untuk asset compilation)
- Web Server (Apache/Nginx)

## Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd sistem_perpustakaan
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Konfigurasi Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_perpustakaan
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migration

```bash
# Jalankan migration untuk membuat tabel database
php artisan migrate
```

### 6. Jalankan Seeder

```bash
# Jalankan semua seeder untuk mengisi data awal
php artisan db:seed

# Atau jalankan seeder tertentu
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=SystemSettingSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=LibrarySettingSeeder
php artisan db:seed --class=BookSeeder
```

### 7. Compile Assets

```bash
# Compile CSS dan JavaScript
npm run build

# Atau untuk development dengan hot reload
npm run dev
```

### 8. Set Permissions (Linux/Mac)

```bash
# Set permissions untuk storage dan cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 9. Jalankan Server

```bash
# Development server
php artisan serve

# Server akan berjalan di http://localhost:8000
```

## Data Seeder

Sistem ini dilengkapi dengan beberapa seeder untuk mengisi data awal:

### UserSeeder
Membuat user admin default:
- **Email**: admin@sistemperpustakaan.com
- **Password**: password
- **Role**: Admin

### SystemSettingSeeder
Mengatur konfigurasi sistem:
- Nama sistem: "Sistem Perpustakaan"
- Logo dan favicon default
- Copyright text

### CategorySeeder
Membuat kategori buku default:
- Fiksi
- Non-Fiksi
- Referensi
- Majalah
- Jurnal
- Teknologi
- Pendidikan
- Agama

### LibrarySettingSeeder
Mengatur pengaturan perpustakaan:
- Maksimal hari peminjaman (siswa: 14 hari, guru: 30 hari)
- Maksimal buku per peminjam (siswa: 3 buku, guru: 5 buku)
- Durasi reservasi: 7 hari
- Informasi perpustakaan (nama, alamat, telepon, email)

### BookSeeder
Membuat sample buku untuk testing:
- Laskar Pelangi - Andrea Hirata
- Ayat-Ayat Cinta - Habiburrahman El Shirazy
- Sejarah Indonesia Modern - M.C. Ricklefs
- Matematika Dasar - Prof. Dr. Suharsimi Arikunto
- Harry Potter and the Philosopher's Stone - J.K. Rowling

## Reset Database

Jika ingin mengulang instalasi dari awal:

```bash
# Hapus semua tabel dan jalankan ulang migration
php artisan migrate:fresh

# Jalankan seeder setelah migration
php artisan db:seed
```

## Struktur Database

### Tabel Utama:
- `users` - Data pengguna sistem
- `categories` - Kategori buku
- `books` - Data buku
- `borrowings` - Data peminjaman
- `reservations` - Data reservasi
- `book_reviews` - Review buku
- `library_settings` - Pengaturan perpustakaan
- `system_settings` - Pengaturan sistem
- `activity_logs` - Log aktivitas

## Akses Sistem

Setelah instalasi selesai, Anda dapat mengakses:

- **Frontend**: http://localhost:8000
- **Backend Admin**: http://localhost:8000/admin
- **Login Admin**: 
  - Email: admin@sistemperpustakaan.com
  - Password: 123456789

## Troubleshooting

### Error "Class not found"
```bash
composer dump-autoload
```

### Error Permission Denied
```bash
# Linux/Mac
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Windows (jika menggunakan XAMPP/Laragon)
# Pastikan folder storage dan bootstrap/cache dapat ditulis
```

### Error Database Connection
- Pastikan database server berjalan
- Periksa konfigurasi di file `.env`
- Pastikan database sudah dibuat

### Error Migration
```bash
# Reset migration jika ada error
php artisan migrate:reset
php artisan migrate
```

## Kontribusi

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

## Kontak

- **Email**: admin@sistemperpustakaan.com
- **Project Link**: [Repository URL]

---

**Sistem Perpustakaan** - Solusi digital untuk manajemen perpustakaan modern