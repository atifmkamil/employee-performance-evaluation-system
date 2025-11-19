<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Employee Performance Evaluation System

Sistem untuk penilaian kinerja yang dibangun dengan Filament, Spatie, dan Laravel 12. 

## 📦 Instalasi

### Prerequisites

```bash
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Git
```

### Langkah Instalasi

1. **Clone Repository**

```bash
git clone https://github.com/atifmkamil/employee-performance-evaluation-system.git
cd direktori-projek
```

2. **Install Dependencies**

```bash
composer install
```

3. **Setup Environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**
   Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=employee_performance_evaluation_system
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. **Buat Database**

```sql
CREATE DATABASE employee_performance_evaluation_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

6. **Jalankan Server**

```bash
php artisan serve
```

Sistem akan berjalan di `http://127.0.0.1:8000/admin/login`

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat issue di repository ini.

---

**Built with Laravel 12 + Filament + Spatie**
