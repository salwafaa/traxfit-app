# 🏋️ TraxFit App

TraxFit adalah aplikasi manajemen gym berbasis web yang dibuat menggunakan Laravel.  
Aplikasi ini digunakan untuk membantu pengelolaan data member, transaksi, dan laporan gym.

---

## 🚀 Fitur Utama

- 👤 Manajemen Member
- 💳 Transaksi Membership
- 🛒 Penjualan Produk
- 📦 Manajemen Stok
- 📊 Laporan (Owner)
- 🔐 Multi Role (Admin, Kasir, Owner)

---

## 🛠️ Teknologi

- Laravel
- MySQL
- Tailwind CSS
- JavaScript

---

## 👥 Role Pengguna

- **Admin** → Mengelola data (member, produk, paket, dll)
- **Kasir** → Melakukan transaksi & check-in
- **Owner** → Melihat laporan & mengelola user

---

## 📌 Tujuan

Aplikasi ini dibuat untuk memenuhi tugas UKK (Uji Kompetensi Keahlian) dan sebagai sistem manajemen gym yang efisien.

---

## 📷 Preview
*(Tambahkan screenshot aplikasi kamu di sini kalau ada)*

---

## ⚡ Instalasi

```bash
git clone https://github.com/salwafaa/traxfit-app.git
cd traxfit-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve