import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),

    ],
    // Tambahkan blok server ini
    // server: {
    //     host: "0.0.0.0",
    //     hmr: {
    //         host: "172.20.10.2", // Ganti dengan IP Address IPv4 laptop Anda
    //     },
    // },
});
