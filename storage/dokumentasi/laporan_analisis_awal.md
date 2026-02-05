# LAPORAN ANALISIS SISTEM TEQARA

**Tanggal:** 05 Februari 2026
**Penyusun:** System Analyst (AI Code Gemini)
**Versi:** 1.0.0

## 1. STATUS PROYEK SAAT INI
- **Framework:** Laravel 12 (Terinstal)
- **Frontend Engine:** Blade + Livewire v3 (Baru diinstal)
- **Styling:** Tailwind CSS v4
- **Database:** MySQL
- **Kondisi Awal:** Struktur default Laravel (Banyak istilah Inggris yang harus diganti).

## 2. ANALISIS KESENJANGAN (GAP ANALYSIS)

### A. Database & Model Data
| Kondisi Saat Ini (Default) | Target Sistem (Indonesian Rules) | Tindakan Diperlukan |
|----------------------------|----------------------------------|---------------------|
| Tabel `users` | Tabel `pengguna` | Rename & Refactor Migrasi |
| Kolom `name`, `password` | Kolom `nama`, `kata_sandi` | Override Auth Laravel |
| Model `User.php` | Model `Pengguna.php` | Rename Class & File |
| Tabel `products` (Belum ada) | Tabel `produk` | Buat baru |
| Tabel `orders` (Belum ada) | Tabel `pesanan` | Buat baru |

### B. Antarmuka (UI/UX)
- **Aturan:** DILARANG KERAS MENGGUNAKAN MODAL.
- **Tantangan:** Form input data (tambah/edit) biasanya menggunakan modal untuk efisiensi tempat.
- **Solusi:** Menggunakan pendekatan *Inline Editing* (edit di baris tabel), *Drawer/Panel* (muncul dari samping), atau *Dedicated Page* dengan transisi cepat (SPA feel) menggunakan `wire:navigate`.

### C. SEO Teknis
- URL saat ini belum terdefinisi.
- **Target:** URL harus deskriptif bahasa Indonesia.
  - *Salah:* `/products/123`
  - *Benar:* `/katalog/laptop-asus-rog-strix-g15`

## 3. STRATEGI IMPLEMENTASI
1. **Pembersihan:** Menghapus/mengubah migrasi bawaan Laravel yang berbahasa Inggris.
2. **Pondasi:** Membangun `Tabel Pengguna` dan `Sistem Otentikasi` kustom (Bahasa Indonesia).
3. **Komponen:** Membuat Layout Blade dasar tanpa modal.
4. **Fitur:** Implementasi modul per modul (Hulu ke Hilir).
