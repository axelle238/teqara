# RENCANA ARSITEKTUR SISTEM TEQARA

**Status:** DRAFT (Menunggu Implementasi)

## 1. STRUKTUR DATABASE (BAHASA INDONESIA MUTLAK)

Sistem akan menggunakan tabel-tabel berikut dengan penamaan kolom 100% Bahasa Indonesia.

### A. Modul Pengguna & Akses
**Tabel: `pengguna`**
- `id` (BigInt, PK)
- `nama` (String)
- `email` (String, Unique)
- `kata_sandi` (String)
- `peran` (Enum: 'admin', 'staf_gudang', 'kasir', 'pelanggan')
- `nomor_telepon` (String, Nullable)
- `foto_profil` (String, Nullable)
- `dibuat_pada` (Timestamp)
- `diperbarui_pada` (Timestamp)

### B. Modul Produk (Hulu)
**Tabel: `kategori`**
- `id`
- `nama`
- `slug` (Index)
- `ikon`

**Tabel: `merek`**
- `id`
- `nama`
- `logo`

**Tabel: `produk`**
- `id`
- `kategori_id` (FK)
- `merek_id` (FK)
- `nama`
- `slug` (Unique, Index SEO)
- `deskripsi_singkat`
- `deskripsi_lengkap` (HTML)
- `harga_modal` (Decimal)
- `harga_jual` (Decimal)
- `stok` (Integer)
- `sku` (String, Unique)
- `status` (Enum: 'aktif', 'arsip', 'habis')

### C. Modul Transaksi (Tengah - Hilir)
**Tabel: `keranjang`** (Penyimpanan sementara via Database untuk persistensi antar device)
- `id`
- `pengguna_id` (FK)
- `produk_id` (FK)
- `jumlah`

**Tabel: `pesanan`**
- `id`
- `nomor_faktur` (String, Unique, cth: TRX-2026-0001)
- `pengguna_id` (FK)
- `total_harga`
- `status_pembayaran`
- `status_pesanan` (Enum: 'menunggu', 'diproses', 'dikirim', 'selesai', 'batal')
- `alamat_pengiriman` (Text)

**Tabel: `detail_pesanan`**
- `id`
- `pesanan_id` (FK)
- `produk_id` (FK)
- `harga_saat_ini` (Snapshot harga saat beli)
- `jumlah`
- `subtotal`

### D. Modul Audit & Log
**Tabel: `log_aktivitas`**
- `id`
- `pelaku_id` (FK -> pengguna)
- `aksi` (String, cth: "Mengubah Harga")
- `target` (String, cth: "Laptop Asus ROG")
- `pesan_naratif` (Text, cth: "Admin Budi mengubah harga Laptop Asus ROG dari 15jt menjadi 16jt")
- `waktu` (Timestamp)

## 2. ARSITEKTUR KODE (LARAVEL + LIVEWIRE)

### Penamaan Class
- Controller: `App\Http\Controllers\KatalogController`
- Model: `App\Models\Produk`
- Livewire: `App\Livewire\Produk\DaftarProduk`

### Pola Interaksi (No Modal)
1. **Daftar Data:** Tabel dengan filter real-time.
2. **Tambah Data:** Tombol "Tambah" mengarahkan ke halaman baru (`wire:navigate`) atau membuka panel samping (Slide-over).
3. **Edit Data:** Klik baris -> Inline edit ATAU halaman detail.
4. **Hapus:** Konfirmasi via Toast/Alert non-blocking (SweetAlert custom atau Native confirm).

## 3. ALUR SEO
1. Setiap produk disimpan/diupdate -> Trigger membuat Slug otomatis.
2. Sitemap.xml digenerate otomatis setiap tengah malam via Scheduler.
3. Meta tag (OpenGraph) di-inject dinamis di `layouts/app.blade.php`.
