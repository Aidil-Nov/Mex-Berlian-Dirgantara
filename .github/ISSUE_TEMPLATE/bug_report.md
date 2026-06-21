---
name: 🐛 Bug Report
about: Laporkan kutu (bug), error sistem, atau keanehan layout di lapangan.
title: "[BUG] "
labels: bug
assignees: ""
---

# 📋 Project Issue Tracker & Backlog - PT MEX Berlian Dirgantara

Dokumen ini digunakan untuk melacak daftar tugas (_To-Do Lists_), perbaikan kutu (_Bug Fixes_), penanganan celah keamanan (_Security Safeguards_), dan rencana pengembangan fitur selanjutnya pada Sistem Informasi Integrasi Kargo Udara.

---

## 🔴 Current Open Issues (Bugs & Security Safeguards)

Daftar kendala lapangan atau celah sistem di sisi Admin Operasional dan Guest yang harus segera diselesaikan sebelum rilis/sidang.

### 1. [BUG] Sinkronisasi ID Rute Intern pada Dropdown Loading

-   **Deskripsi:** Opsi jadwal pesawat pada modal _Update Status_ Admin (tahap `Loading`) sempat kosong akibat ketidakcocokan antara tipe data ID di `master_kota` dengan data hasil _parsing_ API/Seeder.
-   **Status:** 🟡 _In Progress / Testing_ (Pemberian logika `parseInt()` di Alpine.js dan penyesuaian `MasterPenerbanganSeeder`).
-   **Prioritas:** Tinggi

### 2. [SECURITY] Validasi String Input pada 4 Digit Verifikasi Telepon

-   **Deskripsi:** Perlu dipastikan bahwa input 4 digit nomor telepon terakhir pada gerbang tracking Guest benar-benar bersih dari karakter non-numerik, spasi, atau simbol khusus yang dapat memicu kegagalan kueri database.
-   **Status:** 🟢 _Resolved_ (Sudah diamankan dengan `preg_replace` di _Controller_ dan filtrasi regex di _frontend_).
-   **Prioritas:** Tinggi

### 3. [UX] Layout Breakdown pada Riwayat Perjalanan Kosong

-   **Deskripsi:** Tampilan komponen grafik linimasa (_stepper progress bar_) pada halaman `tracking-result.blade.php` berisiko bergeser atau pecah jika kargo baru didaftarkan dan belum memiliki data di tabel `history_status`.
-   **Status:** ⚪ _Open_ (Perlu penambahan _conditional rendering_ `@if($kargo->history->count() > 0)`).
-   **Prioritas:** Sedang

---

## 🟡 Feature Backlog (Pengembangan Selanjutnya)

Fitur-fitur yang sengaja ditunda untuk menjaga fokus pengembangan pada peran Admin Lapangan dan fungsionalitas Publik.

### 1. Panel Modul Manajer Cabang (Skenario Poin 3, 4, 5)

-   **Deskripsi:** Membangun antarmuka khusus untuk akun dengan _role_ `manajer_cabang`.
-   **Fungsionalitas:**
    -   Melakukan filter keluhan customer yang masuk ke dalam status `menunggu`.
    -   Menyediakan kolom input khusus `tindakan_solusi` untuk memberikan keputusan kompensasi/ganti rugi atas kehilangan/kerusakan kargo.
-   **Status:** ⚪ _On Hold_ (Fokus Admin Selesai 100%).

### 2. Fitur Cetak/Download PDF Laporan Operasional Kargo

-   **Deskripsi:** Menghidupkan rute `admin.kelola-laporan.download` menggunakan _library_ DomPDF di Laravel agar Admin bisa mencetak laporan fisik kargo.
-   **Status:** ⚪ _Planned_.

### 3. Otomatisasi Status ke 'On Flight' Berdasarkan Waktu API

-   **Deskripsi:** Membuat _Scheduler_ atau _Cron Job_ harian yang otomatis mengubah status kargo dari `Loading` menjadi `On Flight` jika waktu keberangkatan pesawat pada _Live Radar API_ telah terpenuhi.
-   **Status:** ⚪ _Planned_.

---

## 🔵 Database & Deployment Checklists

-   [x] Migrasi tabel `master_kota`, `customers`, dan `kargo`.
-   [x] Migrasi tabel `master_penerbangan` dan penguncian _Foreign Key_ rute bandara.
-   [x] Pembuatan Model `MasterPenerbangan` dan relasi `belongsTo` ke `MasterKota`.
-   [x] Eksekusi `MasterPenerbanganSeeder` untuk suplai data pesawat cadangan (_API Fallback_).
-   [ ] Konfigurasi API Key Aviationstack pada file `.env` produksi.

---

_Terakhir diperbarui pada: Juni 2026_
