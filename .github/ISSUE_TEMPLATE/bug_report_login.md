---
name: 🐛 Bug Fix & Refactor Login Panel
about: Perbaikan kritis unscrollable screen pada mobile, aktivasi toggle password, dan standardisasi theme.
title: "[BUG/UI] Perbaikan Layout Auth Login & Sinkronisasi Sistem Desain Tailwind"
labels: bug, ui/ux, frontend
assignees: ""
---

# 🔒 [BUG/UI] Perbaikan Layout Auth Login & Sinkronisasi Sistem Desain Tailwind

Halaman login secara fungsi backend (Laravel Breeze) telah berjalan dengan aman. Issue ini dibuka untuk mendokumentasikan pembenahan beberapa kutu (bugs) tampilan pada perangkat mobile (khususnya iPhone dengan viewport sempit) serta pembersihan sisa kode hardcoded agar patuh pada aturan `tailwind.config.js`.

### 🚨 Temuan Masalah & Dampak Lapangan:

1. **Critical Mobile Lock (`overflow-hidden`):** Tag `<body>` mengunci halaman secara vertikal. Saat virtual keyboard ponsel aktif, form terpotong dan user tidak bisa menavigasi atau menggulir layar ke tombol submit.
2. **Non-Interactive Password Toggle:** Ikon pembuka sandi (`ri-eye-line`) belum dipasang logika interaktivitas, sehingga fitur intip password tidak berfungsi.
3. **Hardcoded Utilities Style:** Penggunaan font manual `font-['Poppins']` dan variasi warna hover/shadow merah (`red-700`) melompati variabel resmi core theme (`font-primary` dan `redhover`).

---

### 🛠️ Rencana Aksi Pembenahan (Checklist Penyelarasan):

-   [ ] **Fix Viewport Scroll:** Menghapus `overflow-hidden` pada elemen body dan menggantinya dengan manajemen overflow yang aman pada level container flex screen.
-   [ ] **Implementasi Alpine.js Toggle Password:** Menyisipkan state reactive `x-data="{ showPassword: false }"` untuk mengubah atribut `type="password"` menjadi `type="text"` secara dinamis sekaligus mengganti ikon mata secara realtime.
-   [ ] **Standardisasi Tipografi:** Mengganti semua elemen font manual menjadi kelas utilitas `font-primary`.
-   [ ] **Penyelarasan Warna Korporat:** Mengubah utilitas hover tombol ke `hover:bg-redhover` dan menyelaraskan warna latar belakang form card menggunakan kluster `bg-surface` serta `border-surface-border`.
-   [ ] **Verifikasi Error Message Alignment:** Memastikan tampilan komponen `<x-input-error>` dari Breeze terformat rapi tanpa merusak grid layout form saat pesan validasi muncul.

---

_Prioritas: Tinggi (Blocking Core Access)_
_Scope: Authentication View_
