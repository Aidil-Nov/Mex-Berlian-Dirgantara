import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        // Pastikan path ini ada agar komponen button.blade.php yang baru kita buat ikut terbaca
        "./resources/views/components/**/*.blade.php",
        "./index.html"
    ],
    theme: {
        extend: {
            // Setup Custom Colors yang Anda modifikasi
            colors: {
                light: "#ffffff",
                blue: "#162E93",
                bluehover: "#142984",
                blueactive: "#142984",
                red: "#D62828",
                redhover: "#C12424",
                redactive: "#C12424",
                accent: "#e8eaf4"
            },
            // Setup Custom Fonts
            fontFamily: {
                sans: ["Inter", "sans-serif", defaultTheme.fontFamily.sans],
                primary: ["Poppins", "sans-serif"],
                secondary: ["Lora", "serif"]
            },
            fontSize: {
                // Format: ['ukuran-font', 'line-height']
                sm: ["12px", "20px"],
                base: ["16px", "24px"],
                lg: ["18px", "28px"], // Teks deskripsi card/section
                xl: ["20px", "28px"],
                "2xl": ["24px", "36px"], // Judul Card (Kargo Udara, Trucking, dll)
                "3xl": ["30px", "40px"],
                "4xl": ["36px", "48px"],
                "5xl": ["48px", "63px"], // Judul Section (Lacak Kargo, FAQ, Tentang Kami)
                "6xl": ["60px", "72px"],
                hero: ["96px", "118px"] // Khusus untuk Judul Utama di Hero Section
            }
        }
    },
    plugins: []
};
