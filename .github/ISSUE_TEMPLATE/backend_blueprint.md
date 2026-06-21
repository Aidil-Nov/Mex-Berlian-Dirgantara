---
name: 🛠️ Backend Blueprint & Migrations
about: Cetak biru arsitektur backend, migrasi database, dan backlog sistem kargo MEX.
title: "[BACKLOG] Arsitektur Backend & Database Blueprint"
labels: documentation, backend
assignees: ""
---

# 🛠️ Backend Architecture & Database Migrations Blueprint

Dokumen ini mendokumentasikan informasi lengkap mengenai arsitektur _backend_, skema migrasi tabel database, relasi antar-entitas, serta log kontrol sistem (_State Machine_ & _API Fallback_) pada Sistem Informasi Logistik dan Kargo Udara PT MEX Berlian Dirgantara.

---

## 💾 1. Skema Migrasi Database (Database Schemas)

Berikut adalah detail cetak biru (_blueprint_) tabel _database_ yang telah diimplementasikan ke dalam sistem menggunakan Laravel Migration.

### A. Tabel Master Kota (`master_kota`)

Menyimpan data induk wilayah operasional bandara beserta kode IATA (contoh penulisan data: `Pontianak (PNK)`, `Jakarta (CGK)`).

-   `id` : **BigIncrements** (Primary Key)
-   `nama_kota` : **String**
-   `timestamps()` : `created_at` & `updated_at`

### B. Tabel Master Customer (`customers`)

Menyimpan data entitas pengguna jasa logistik baik berperan sebagai pengirim maupun penerima kargo.

-   `id` : **BigIncrements** (Primary Key)
-   `nama` : **String**
-   `alamat` : **Text**
-   `no_hp` : **String**
-   `tipe_cust` : **Enum** (`retail`, `corporate`)
-   `timestamps()` : `created_at` & `updated_at`

### C. Tabel Master Penerbangan (`master_penerbangan`)

Repositori data jadwal dan armada pesawat lokal yang berfungsi sebagai _Live API Fallback Database_.

-   `id` : **BigIncrements** (Primary Key)
-   `no_penerbangan` : **String** (Unique)
-   `maskapai` : **String**
-   `jenis_pesawat` : **String** (Komersil / Freighter)
-   `tipe_pesawat` : **String** (Contoh: Boeing 737-800)
-   `id_kota_asal` : **UnsignedBigInteger** (Foreign Key &rarr; `master_kota`)
-   `id_kota_tujuan` : **UnsignedBigInteger** (Foreign Key &rarr; `master_kota`)
-   `status_penerbangan` : **String** (Default: `belum_terbang`)
-   `timestamps()` : `created_at` & `updated_at`

### D. Tabel Inti Transaksi Kargo (`kargo`)

Tabel utama pelacakan manifes kargo udara yang mengikat seluruh entitas rute dan customer.

-   `id` : **BigIncrements** (Primary Key)
-   `no_resi` : **String** (Unique)
-   `id_pengirim` : **UnsignedBigInteger** (Foreign Key &rarr; `customers`)
-   `id_penerima` : **UnsignedBigInteger** (Foreign Key &rarr; `customers`)
-   `id_kota_asal` : **UnsignedBigInteger** (Foreign Key &rarr; `master_kota`)
-   `id_kota_tujuan` : **UnsignedBigInteger** (Foreign Key &rarr; `master_kota`)
-   `berat` : **Integer**
-   `isi_barang` : **String**
-   `no_penerbangan` : **String** (Nullable)
-   `maskapai` : **String** (Nullable)
-   `status_terakhir` : **String** (Default: `Entry`)
-   `timestamps()` : `created_at` & `updated_at`

### E. Tabel Log Riwayat Status (`history_status`)

Mencatat rekam jejak audit kronologis perpindahan status kargo secara _time-series_.

-   `id` : **BigIncrements** (Primary Key)
-   `no_resi` : **String** (Foreign Key &rarr; `kargo`)
-   `id_user` : **UnsignedBigInteger** (Foreign Key &rarr; `users` / Admin eksekutor)
-   `status` : **String**
-   `keterangan` : **Text**
-   `timestamps()` : Digunakan sebagai acuan `waktu_update` operasional lapangan.

### F. Tabel Komplain Customer (`komplain`)

Pencatatan kendala kargo yang mendukung sistem alur approval manajemen.

-   `id` : **BigIncrements** (Primary Key)
-   `id_komplain` : **String** (Unique Tiket, e.g., `COMP-001`)
-   `no_resi` : **String** (Foreign Key &rarr; `kargo`)
-   `nama_pelapor` : **String**
-   `hp_pelapor` : **String**
-   `email_pelapor` : **String** (Nullable)
-   `kategori` : **String** (`keterlambatan`, `rusak`, `hilang`, `layanan`)
-   `tingkat_keparahan` : **String** (`rendah`, `sedang`, `tinggi`, `kritis`)
-   `deskripsi` : **Text**
-   `estimasi_klaim` : **String** (Nullable)
-   `status` : **String** (Default: `menunggu`)
-   `tindakan_solusi` : **Text** (Nullable - Khusus diisi oleh _Role_ Manager)
-   `channel` : **String** (`telepon`, `whatsapp`, `email`, `langsung`)
-   `timestamps()` : `created_at` & `updated_at`

---

## 🧠 2. Informasi Sistem & Logika Komponen Backend

### A. Status Pengiriman Controller (`StatusPengirimanController`)

Mengelola alur pergerakan kargo internal admin. Memiliki 2 fitur utama:

1. **Mekanisme Otomatis Analisis Kode IATA:** Mengekstrak 3 huruf kode bandara dari nama kota menggunakan _Regular Expression_ (`preg_match('/\((.*?)\)/'`) untuk dipetakan ke ID internal.
2. **Logika Toleransi Kesalahan API (_Fallback System_):** Mencoba menarik jadwal penerbangan komersil rute Pontianak via _Aviationstack API_. Jika gagal koneksi/timeout/limit habis, sistem otomatis beralih mengeksekusi _query_ data pesawat lokal dari model `MasterPenerbangan` agar performa aplikasi di _frontend_ tidak _crash_.

### B. Pelacakan Publik Gateway (`TrackingController`)

Menangani pencarian posisi kargo dari sisi _Guest_ (Customer Publik) dengan aturan pengamanan ketat:

1. **Otentikasi Dua Faktor String:** Sebelum menampilkan riwayat perjalanan, sistem mewajibkan inputan parameter 4-digit angka telepon.
2. **Filtrasi Ganda Keamanan (_Double Verification Query_):** Data nomor telepon di-sanitasi menggunakan `preg_replace('/[^0-9]/', '')` untuk membuang karakter strip/spasi. Server kemudian menguji kecocokan nilai inputan dengan 4 digit terakhir nomor handphone milik **Pengirim** ATAU **Penerima**. Jika tidak lolos, akses _view tracking_ diblokir total.

### C. Validasi Resi Latar Belakang (`KomplainController`)

Menyediakan API internal JSON (`/admin/komplain/cek-resi`) yang diakses secara asinkron (_asynchronous_) oleh Alpine.js di _frontend_. Menjamin integritas data bahwa Admin Operasional tidak dapat mendaftarkan formulir komplain jika nomor resi yang bersangkutan tidak valid/tidak terdaftar di database kargo.

---

## 📝 3. Backend Implementation Checklists (GitHub Issues)

Daftar checklist implementasi dan pengujian modul backend untuk kesiapan sistem:

-   [x] Implementasi relasi `hasMany` (`kargoDikirim` & `kargoDiterima`) pada model `Customer`.
-   [x] Proteksi integritas data hapus `destroy()` customer jika masih terikat riwayat kargo.
-   [x] Integrasi `DB::beginTransaction()` dan `DB::rollBack()` pada pembaruan status log kargo.
-   [x] Penerapan fungsi `parseInt()` pada penyaringan _routing_ maskapai lokal di Alpine.js.
-   [x] Pembuatan `MasterPenerbanganSeeder` untuk _suplai fallback dataset_.
-   [ ] Pengujian beban integrasi _Aviationstack API_ saat status penerbangan berubah menjadi `Landed` atau `Active`.
-   [ ] Implementasi pembatasan hak akses (_Middleware Role_) antara Admin Operasional dan Manajer Cabang.

## 🧩 4. Rancangan Use Case Diagram (PlantUML Blueprint)

Bagian ini mendokumentasikan hubungan interaksi antara aktor (Admin Operasional, Guest/Customer, dan Manajer Cabang) terhadap fungsi-fungsi utama di dalam Sistem Informasi Kargo Udara PT MEX Berlian Dirgantara.

### A. Kode Komponen PlantUML Use Case

```plantuml
@startuml
left to right direction
skinparam packageStyle rectangle
skinparam shadowing false
skinparam actorThickness 2
skinparam rectangleBorderThickness 1.5

actor "Admin Operasional" as admin
actor "Guest / Customer" as guest
actor "Manajer Cabang" as manager

rectangle "Sistem Informasi Kargo Udara PT MEX" {

    '--- Core Authentication ---
    usecase "Autentikasi Sistem (Login)" as UC_Login

    '--- Admin Operasional Tasks ---
    usecase "Kelola Manifest Data Kargo" as UC_Manifest
    usecase "Update Status Pengiriman (State Machine)" as UC_Status
    usecase "Pilih Maskapai Penerbangan" as UC_Radar
    usecase "Catat Komplain Customer" as UC_Komplain
    usecase "Verifikasi Validitas Nomor Resi (Fetch API)" as UC_CekResi
    usecase "Ekspor Laporan Operasional Kargo" as UC_Laporan

    '--- Guest / Customer Tasks ---
    usecase "Lacak Posisi Kargo (Public Tracking)" as UC_Tracking
    usecase "Otentikasi 4 Digit Nomor Telepon" as UC_VerifyPhone

    '--- Manajer Cabang Tasks ---
    usecase "Review & Input Solusi Komplain" as UC_Solusi
    usecase "Monitoring Dashboard & Laporan" as UC_Monitor
}

'--- Admin Relationships ---
admin --> UC_Login
admin --> UC_Manifest
admin --> UC_Status
admin --> UC_Komplain
admin --> UC_Laporan

'--- Admin Includes ---
UC_Status ..> UC_Radar : <<include>>
note on UC_Radar
  Sistem otomatis melakukan Fallback
  ke Local DB jika API Radar Limit/Mati
end note

UC_Komplain ..> UC_CekResi : <<include>>

'--- Guest Relationships ---
guest --> UC_Tracking
UC_Tracking ..> UC_VerifyPhone : <<include>>

'--- Manager Relationships ---
manager --> UC_Login
manager --> UC_Solusi
manager --> UC_Monitor

@endum

---

_Dokumentasi Backend ini diselaraskan dengan arsitektur sistem terbaru per Juni 2026._
```
