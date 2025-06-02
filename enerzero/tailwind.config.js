// tailwind.config.js

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // TAMBAHKAN ATAU UBAH BARIS INI
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};