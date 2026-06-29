const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./resources/views/components/**/*.blade.php",
        "./index.html"
    ],
    theme: {
        extend: {
            // Setup Custom Colors
            colors: {
                // 1. BRAND COLORS (Warna Utama Customer & Identity)
                light: "#ffffff",
                blue: "#162E93",
                bluehover: "#142984",
                blueactive: "#142984",
                red: "#D62828",
                redhover: "#C12424",
                redactive: "#C12424",
                accent: "#e8eaf4",

                // 2. OPERATIONAL COLORS (Diambil dari sistem Admin Operasional)
                // Sangat berguna jika Anda ingin menyamakan warna status di halaman Customer
                success: {
                    DEFAULT: "#10b981", // Setara emerald-500 (Tiba / Selesai)
                    light: "#ecfdf5", // Setara emerald-50
                    text: "#047857" // Setara emerald-700
                },
                info: {
                    DEFAULT: "#0ea5e9", // Setara sky-500 (Proses / Info Penerbangan)
                    light: "#f0f9ff", // Setara sky-50
                    text: "#0369a1" // Setara sky-700
                },
                warning: {
                    DEFAULT: "#f59e0b", // Setara amber-500 (Menunggu / Keterlambatan)
                    light: "#fffbeb", // Setara amber-50
                    text: "#b45309" // Setara amber-700
                },
                pending: {
                    DEFAULT: "#a855f7", // Setara purple-500 (Loading / On Flight)
                    light: "#faf5ff", // Setara purple-50
                    text: "#7e22ce" // Setara purple-700
                },
                surface: {
                    DEFAULT: "#f8fafc", // Setara slate-50 (Background dasar elemen form/card)
                    border: "#e2e8f0", // Setara slate-200 (Garis pembatas tabel/card)
                    text: "#0f172a", // Setara slate-900 (Judul utama)
                    muted: "#64748b" // Setara slate-500 (Teks sekunder/deskripsi)
                }
            },
            // Setup Custom Fonts
            fontFamily: {
                // Perbaikan: Menggunakan spread operator (...) agar array default tidak nested
                sans: [
                    "Poppins",
                    "sans-serif",
                    ...defaultTheme.fontFamily.sans
                ],
                primary: [
                    "Poppins",
                    "sans-serif",
                    ...defaultTheme.fontFamily.sans
                ]
                // secondary: ["Lora", "serif"]
            },
            fontSize: {
                // Format: ['ukuran-font', 'line-height']
                sm: ["12px", "20px"],
                base: ["16px", "24px"],
                lg: ["18px", "28px"],
                xl: ["20px", "28px"],
                "2xl": ["24px", "36px"],
                "3xl": ["30px", "40px"],
                "4xl": ["36px", "48px"],
                "5xl": ["48px", "63px"],
                "6xl": ["60px", "72px"],
                hero: ["96px", "118px"]
            }
        }
    },
    plugins: []
};
