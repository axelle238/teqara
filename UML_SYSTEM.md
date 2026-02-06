# UML Diagram - Teqara Enterprise Hub v16.0

Dokumen ini berisi representasi visual arsitektur sistem Teqara menggunakan diagram UML (Unified Modeling Language).

## 1. Class Diagram (Struktur Database & Relasi Model)

Diagram ini menggambarkan struktur tabel database dan hubungan antar entitas dalam sistem.

```mermaid
classDiagram
    %% User Management
    class Pengguna {
        +id: bigint
        +nama: string
        +email: string
        +kata_sandi: string
        +peran: enum (admin, pelanggan, staf)
        +poin_loyalitas: int
        +level_member: string
    }
    class AlamatPengiriman {
        +id: bigint
        +pengguna_id: FK
        +alamat_lengkap: text
        +is_utama: boolean
    }
    Pengguna "1" --> "*" AlamatPengiriman : memiliki

    %% Product Management (Pillar 2)
    class Produk {
        +id: bigint
        +nama: string
        +kode_unit: string
        +harga_modal: decimal
        +harga_jual: decimal
        +stok: int
        +tipe_produk: enum (fisik, bundle, digital)
        +harga_grosir: json
        +dimensi_kemasan: json
    }
    class Kategori {
        +id: bigint
        +nama: string
        +slug: string
    }
    class Merek {
        +id: bigint
        +nama: string
        +logo: string
    }
    class VarianProduk {
        +id: bigint
        +produk_id: FK
        +nama_varian: string
        +stok: int
    }
    class SpesifikasiProduk {
        +id: bigint
        +produk_id: FK
        +label: string
        +nilai: string
    }
    class ProdukBundling {
        +id: bigint
        +parent_produk_id: FK
        +child_produk_id: FK
        +jumlah: int
    }
    class ProdukSeri {
        +id: bigint
        +produk_id: FK
        +nomor_seri: string
        +status: enum (tersedia, terjual, rusak)
    }

    Produk "1" --> "1" Kategori : termasuk
    Produk "1" --> "1" Merek : buatan
    Produk "1" --> "*" VarianProduk : memiliki
    Produk "1" --> "*" SpesifikasiProduk : detail
    Produk "1" --> "*" ProdukBundling : terdiri_dari
    Produk "1" --> "*" ProdukSeri : identitas_unit

    %% Inventory & Logistics
    class Gudang {
        +id: bigint
        +nama: string
        +lokasi: string
    }
    class StokGudang {
        +id: bigint
        +produk_id: FK
        +gudang_id: FK
        +jumlah: int
    }
    class Pemasok {
        +id: bigint
        +nama_perusahaan: string
        +kontak: string
    }
    class PembelianStok {
        +id: bigint
        +pemasok_id: FK
        +no_faktur: string
        +total_biaya: decimal
        +status: enum
    }
    class MutasiStok {
        +id: bigint
        +produk_id: FK
        +jumlah: int
        +jenis_mutasi: string
    }
    class StockOpname {
        +id: bigint
        +kode_so: string
        +status: enum
    }

    Gudang "1" --> "*" StokGudang : menyimpan
    Produk "1" --> "*" StokGudang : lokasi
    Pemasok "1" --> "*" PembelianStok : suplai
    PembelianStok "1" --> "*" Produk : item_beli
    Produk "1" --> "*" MutasiStok : riwayat
    StockOpname "1" --> "*" Produk : audit

    %% Order Management (Pillar 3 & 4)
    class Pesanan {
        +id: bigint
        +nomor_faktur: string
        +pengguna_id: FK
        +total_harga: decimal
        +status_pesanan: enum
        +status_pembayaran: enum
    }
    class DetailPesanan {
        +id: bigint
        +pesanan_id: FK
        +produk_id: FK
        +jumlah: int
        +subtotal: decimal
    }
    class TransaksiPembayaran {
        +id: bigint
        +pesanan_id: FK
        +metode: string
        +status: enum
    }

    Pengguna "1" --> "*" Pesanan : buat
    Pesanan "1" --> "*" DetailPesanan : berisi
    DetailPesanan "*" --> "1" Produk : item
    Pesanan "1" --> "1" TransaksiPembayaran : bayar

    %% Support & Marketing
    class PenjualanKilat {
        +id: bigint
        +nama_campaign: string
        +aktif: boolean
    }
    class TiketBantuan {
        +id: bigint
        +pengguna_id: FK
        +subjek: string
        +status: enum
    }
    class Berita {
        +id: bigint
        +judul: string
        +konten: text
    }

    Produk "*" --> "*" PenjualanKilat : promo
    Pengguna "1" --> "*" TiketBantuan : lapor
```

## 2. Use Case Diagram (Interaksi Aktor)

Menggambarkan fitur apa saja yang dapat diakses oleh Admin dan Pelanggan.

```mermaid
usecaseDiagram
    actor "Pelanggan" as User
    actor "Administrator" as Admin

    package "Storefront (Toko)" {
        usecase "Jelajah Katalog" as UC1
        usecase "Cari Produk (Spotlight)" as UC2
        usecase "Kelola Keranjang" as UC3
        usecase "Checkout & Bayar" as UC4
        usecase "Lacak Pesanan" as UC5
        usecase "Ajukan Bantuan" as UC6
    }

    package "Admin Dashboard" {
        usecase "Kelola Produk (CRUD)" as UC7
        usecase "Audit Stok (SO & Mutasi)" as UC8
        usecase "Manajemen Pesanan" as UC9
        usecase "Verifikasi Pembayaran" as UC10
        usecase "Pembelian Stok (PO)" as UC11
        usecase "Laporan Analitik" as UC12
        usecase "Setup Promo & Flash Sale" as UC13
    }

    User --> UC1
    User --> UC2
    User --> UC3
    User --> UC4
    User --> UC5
    User --> UC6

    Admin --> UC7
    Admin --> UC8
    Admin --> UC9
    Admin --> UC10
    Admin --> UC11
    Admin --> UC12
    Admin --> UC13
```

## 3. Sequence Diagram (Alur Checkout Enterprise)

Detail langkah-langkah teknis saat pelanggan melakukan pembelian hingga stok berkurang.

```mermaid
sequenceDiagram
    participant P as Pelanggan
    participant FE as Frontend (Livewire)
    participant BE as Backend (Controller)
    participant DB as Database
    participant Stok as LayananStok

    P->>FE: Klik "Checkout"
    FE->>BE: Validasi Keranjang & Voucher
    BE->>DB: Cek Stok Produk
    DB-->>BE: Stok Tersedia
    BE->>FE: Tampilkan Halaman Checkout

    P->>FE: Pilih Alamat & Metode Kirim
    P->>FE: Klik "Buat Pesanan"
    FE->>BE: createOrder()
    
    activate BE
    BE->>DB: Create Pesanan (Status: Menunggu)
    BE->>DB: Move Cart Items -> DetailPesanan
    
    BE->>Stok: tahanStok(Pesanan)
    activate Stok
    Stok->>DB: Decrement Produk.stok
    Stok->>DB: Increment Produk.stok_ditahan
    deactivate Stok

    BE->>DB: Create LogAktivitas
    BE->>FE: Redirect ke Halaman Bayar
    deactivate BE

    P->>FE: Upload Bukti / Bayar Gateway
    FE->>BE: Konfirmasi Pembayaran
    
    Note over Admin, BE: Admin Memverifikasi Pembayaran
    
    Admin->>BE: Verifikasi(Pesanan)
    activate BE
    BE->>DB: Update Status -> Lunas & Diproses
    BE->>Stok: finalisasiStok(Pesanan)
    activate Stok
    Stok->>DB: Decrement Produk.stok_ditahan
    Stok->>DB: Create MutasiStok (Penjualan)
    deactivate Stok
    deactivate BE
```

## 4. Activity Diagram (Siklus Pengadaan Barang - Procurement)

Alur kerja Admin dalam menambah stok melalui pembelian ke pemasok.

```mermaid
stateDiagram-v2
    [*] --> BuatDraftPO
    BuatDraftPO --> PilihPemasok
    PilihPemasok --> TambahItemProduk
    TambahItemProduk --> TentukanHargaBeli
    
    state "Review Draft" as Review
    TentukanHargaBeli --> Review
    
    Review --> SimpanDraft: Belum Final
    Review --> FinalisasiStok: Setuju & Barang Diterima
    
    state FinalisasiStok {
        [*] --> UpdateStokFisik
        UpdateStokFisik --> UpdateHargaModal
        UpdateHargaModal --> CatatMutasiMasuk
        CatatMutasiMasuk --> [*]
    }
    
    FinalisasiStok --> Selesai
    Selesai --> [*]
```

## 5. Entity Relationship Diagram (ERD) - Ringkas

Relasi kunci antar tabel utama dalam sistem Teqara.

*   **Produk** `1` --- `*` **VarianProduk**
*   **Produk** `1` --- `*` **GambarProduk**
*   **Produk** `*` --- `*` **Pesanan** (via DetailPesanan)
*   **Pengguna** `1` --- `*` **Pesanan**
*   **Pesanan** `1` --- `1` **TransaksiPembayaran**
*   **Pemasok** `1` --- `*` **PembelianStok**
*   **PembelianStok** `*` --- `*` **Produk** (via DetailPembelian)
*   **Gudang** `1` --- `*` **StokGudang**
*   **Produk** `*` --- `*` **PenjualanKilat** (via ProdukPenjualanKilat)

---
*Dokumen ini dibuat otomatis oleh Asisten AI Teqara pada 6 Februari 2026.*
