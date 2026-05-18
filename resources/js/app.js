import "./bootstrap";
import 'remixicon/fonts/remixicon.css'

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function() {
    AOS.init({
        duration: 800, // Durasi animasi dalam milidetik (800ms = lumayan halus)
        once: true, // TRUE: Animasi hanya jalan sekali. FALSE: Animasi ngulang saat di-scroll naik-turun
        offset: 100, // Jarak offset dari bawah layar sebelum animasi dipicu
        easing: "ease-out-cubic" // Gaya pergerakan animasi (lebih natural)
    });
});
