---
name: 👔 Panel Manager Development
about: Tiket instruksi kerja khusus untuk implementasi fitur dan hak akses Peran Manajer Cabang.
title: '[FEAT] Implementasi Panel Modul Manajer Cabang (Workflow Approval & Monitoring)'
labels: enhancement, backend, frontend
assignees: ''
---

## 📝 Deskripsi Tugas
Halo! Sesuai dengan pembagian kerja tim, tugas kamu adalah membangun **Panel Modul Manajer Cabang**. Saat ini fitur untuk Admin Operasional dan Guest Tracking sudah selesai 100%. Tugas Manajer di sini lebih berfokus pada fungsi pengawasan (*monitoring*) dan pengambilan keputusan solusi terhadap keluhan (*complaint approval workflow*).

Manajer **TIDAK** melakukan entri data kargo baru ataupun mengubah status operasional kargo di hanggar. Otoritas tertinggi Manajer adalah memberikan instruksi solusi berupa teks tindakan ganti rugi/kompensasi atas kargo yang bermasalah.

---

## 🎯 Ruang Lingkup Fitur (Scope of Work)

### 1. Middleware Hak Akses (Role Protection)
* Memastikan halaman panel manajer hanya bisa diakses oleh user yang memiliki kolom `role == 'manajer_cabang'` di database.
* Jika Admin Operasional mencoba masuk ke URL Manajer, sistem harus menolak dan melempar *error* `403 Unauthorized` atau mengarahkannya kembali (*redirect*) ke dashboard admin.

### 2. Dashboard Ringkasan (Read-Only Monitoring)
* Menampilkan komponen kartu statistik sederhana (*dashboard cards*):
  * Total Kargo Berstatus `Offload` (Tertunda).
  * Total Komplain Masuk Berstatus `Menunggu`.
* Menampilkan tabel ringkasan log pergerakan kargo terbaru dari tabel `history_status` (Cukup tampilkan 5-10 data terbaru).

### 3. Modul Verifikasi Solusi Keluhan (Core Feature)
* **Halaman Indeks Komplain:** Menampilkan daftar keluhan customer yang ditarik dari tabel `komplain` di mana statusnya masih bernilai `menunggu`.
* **Tombol Aksi Review:** Menyediakan modal pop-up atau halaman detail untuk membaca isi deskripsi keluhan secara utuh.
* **Form Tindakan Solusi:** Di dalam modal tersebut, sediakan kolom `textarea` bernama `tindakan_solusi` dan tombol **"Simpan Keputusan Final"**.
* **Efek Pasca Simpan:** Ketika Manajer mengklik simpan:
  * Kolom `tindakan_solusi` di tabel `komplain` akan terisi.
  * Atribut `status` keluhan otomatis berubah dari `menunggu` menjadi `selesai` atau `diproses`.

---

## 🗃️ Referensi Kolom Database (Model Komplain)
Saat koding di bagian *backend*, pastikan kamu berinteraksi dengan tabel `komplain` melalui model `App\Models\Komplain.php`. Berikut kolom kunci yang wajib kamu gunakan:
* `status` : Ubah nilainya dari `'menunggu'` menjadi `'selesai'` setelah manajer mengisi solusi.
* `tindakan_solusi` : Tempat menyimpan teks keputusan ganti rugi/solusi yang diketik oleh manajer.
* `no_resi` : Gunakan ini untuk membuat relasi `belongsTo` ke model `Kargo` jika ingin memunculkan detail barang di halaman manajer.

---

## ✅ Kriteria Penerimaan (Acceptance Criteria)

- [ ] Route untuk manajer diproteksi ketat menggunakan Middleware bawaan Laravel (e.g., Auth & Custom Role Check).
- [ ] Manajer bisa melihat daftar komplain masuk secara rapi.
- [ ] Terdapat form input/modal review keluhan tanpa merusak layout Tailwind yang sudah ada.
- [ ] Data `tindakan_solusi` tersimpan ke database dengan aman tanpa memicu error kueri.
- [ ] Teks solusi yang diinput oleh manajer berhasil tampil di modal pop-up "Lihat Tindakan" milik sisi Admin Operasional (bersifat *read-only* bagi admin).

---

## 🛠️ Panduan Langkah Kerja (Tips untuk Junior Programmer)

1. **Membuat Route Group:** Bungkus rute baru kamu di dalam file `routes/web.php` menggunakan grup middleware agar rapi. Contoh struktur kasarnya:
   ```php
   Route::middleware(['auth', 'checkRole:manajer_cabang'])->prefix('manager')->group(function () {
       Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
       Route::post('/komplain/{id}/solusi', [ManagerKomplainController::class, 'updateSolusi'])->name('manager.komplain.solusi');
   });