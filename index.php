<?php

require "config/koneksi.php";

$totalLaporan  = mysqli_query($koneksi, "SELECT * FROM laporan");
$totalMenunggu = mysqli_query($koneksi, "SELECT * FROM laporan WHERE status = 'menunggu'");
$totalProses   = mysqli_query($koneksi, "SELECT * FROM laporan WHERE status = 'proses'");
$totalSelesai  = mysqli_query($koneksi, "SELECT * FROM laporan WHERE status = 'selesai'");
$totalUsers    = mysqli_query($koneksi, "SELECT * FROM users WHERE role = 'user'");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PengaduanKu – Sistem Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>

    <style>
        body { 
            font-family: "Segoe UI", sans-serif; 
        }
        html { 
            scroll-behavior: smooth; 
        }
    </style>

    <script src="assets/js/app.js"></script>
</head>
<body class="bg-slate-100 text-slate-800 main-bg">

    <nav class="card bg-white shadow-md fixed top-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <h1 class="text-2xl font-bold text-emerald-600">PengaduanKu</h1>

            <div class="hidden md:flex items-center gap-8 font-medium">
                <a href="#home"    class="hover:text-emerald-600 transition">Home</a>
                <a href="#fitur"   class="hover:text-emerald-600 transition">Fitur</a>
                <a href="#tentang" class="hover:text-emerald-600 transition">Tentang</a>
                <a href="#kontak"  class="hover:text-emerald-600 transition">Kontak</a>
            </div>

            <div class="flex items-center gap-3">

                <button data-theme-toggle aria-label="Toggle tema"
                    class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-xl transition text-sm font-medium">
                    <span data-theme-icon>🌙</span>
                    <span data-theme-label class="hidden sm:inline">Dark Mode</span>
                </button>
                <a href="auth/register.php" class="border border-emerald-600 text-emerald-700 hover:bg-emerald-700 hover:text-white font-semibold px-5 py-2 rounded-xl transition hidden sm:inline-block">Registrasi</a>
                <a href="auth/login.php"    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2 rounded-xl transition">Login</a>
            </div>

        </div>
    </nav>

    <section id="home" class="min-h-screen flex items-center bg-gradient-to-br from-emerald-600 to-emerald-800 text-white pt-24">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center py-16">
            <div>
                <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">
                    Sistem Pengaduan<br>Masyarakat Modern
                </h1>
                <p class="text-lg text-emerald-100 leading-relaxed mb-8">
                    Platform digital untuk membantu masyarakat melaporkan masalah lingkungan,
                    fasilitas umum, dan pelayanan secara cepat, aman, dan transparan.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="auth/register.php" class="bg-white text-emerald-700 px-6 py-3 rounded-2xl font-semibold hover:scale-105 transition shadow-xl">Mulai Sekarang</a>
                    <a href="#fitur" class="border border-white px-6 py-3 rounded-2xl font-semibold hover:bg-white hover:text-emerald-700 transition">Pelajari</a>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="bg-white/10 backdrop-blur-lg p-8 rounded-3xl shadow-2xl w-full max-w-sm border border-white/20 space-y-4">
                    <div class="bg-white/20 rounded-2xl p-5">
                        <p class="font-medium mb-1">Total User</p>
                        <h2 class="text-3xl font-bold"><?= mysqli_num_rows($totalUsers); ?></h2>
                    </div>
                    <div class="bg-white/20 rounded-2xl p-5">
                        <p class="font-medium mb-1">Laporan Masuk</p>
                        <h2 class="text-3xl font-bold"><?= mysqli_num_rows($totalLaporan); ?></h2>
                    </div>
                    <div class="bg-white/20 rounded-2xl p-5">
                        <p class="font-medium mb-1">Sedang Diproses</p>
                        <h2 class="text-3xl font-bold"><?= mysqli_num_rows($totalProses); ?></h2>
                    </div>
                    <div class="bg-white/20 rounded-2xl p-5">
                        <p class="font-medium mb-1">Selesai</p>
                        <h2 class="text-3xl font-bold"><?= mysqli_num_rows($totalSelesai); ?></h2>
                    </div>
                    <div class="bg-white/20 rounded-2xl p-5">
                        <p class="font-medium mb-1">Menunggu</p>
                        <h2 class="text-3xl font-bold"><?= mysqli_num_rows($totalMenunggu); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-24 card bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Fitur Unggulan</h2>
                <p class="text-slate-500 text-lg">Sistem dirancang untuk mempermudah masyarakat dan admin.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-slate-100 p-8 rounded-3xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-300">
                    <div class="text-5xl mb-5">📄</div>
                    <h3 class="text-2xl font-bold mb-4">Laporan Cepat</h3>
                    <p class="text-slate-600 leading-relaxed">Kirim laporan hanya dalam beberapa langkah dengan upload foto dan lokasi.</p>
                </div>
                <div class="bg-slate-100 p-8 rounded-3xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-300">
                    <div class="text-5xl mb-5">🔍</div>
                    <h3 class="text-2xl font-bold mb-4">Tracking Status</h3>
                    <p class="text-slate-600 leading-relaxed">Pantau perkembangan laporan secara realtime dan transparan.</p>
                </div>
                <div class="bg-slate-100 p-8 rounded-3xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-300">
                    <div class="text-5xl mb-5">⚡</div>
                    <h3 class="text-2xl font-bold mb-4">Respon Cepat</h3>
                    <p class="text-slate-600 leading-relaxed">Admin dapat memproses dan memberikan respon lebih cepat.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="py-24 bg-slate-100 main-bg">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200&auto=format&fit=crop"
                class="rounded-3xl shadow-2xl w-full h-[400px] object-cover">
            <div>
                <h2 class="text-4xl font-bold mb-6">Tentang Sistem</h2>
                <p class="text-slate-600 leading-relaxed text-lg">
                    Sistem Pengaduan Masyarakat membantu menjembatani komunikasi antara masyarakat
                    dan pihak pengelola agar setiap laporan dapat ditangani secara efektif dan transparan.
                </p>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-24 bg-gradient-to-br from-emerald-600 to-emerald-800 text-white text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-4xl font-bold mb-6">Siap Membantu Masyarakat</h2>
            <p class="text-lg text-emerald-100 mb-10 leading-relaxed">
                Gunakan platform pengaduan modern untuk menciptakan lingkungan yang lebih baik dan transparan.
            </p>
            <div class="flex flex-wrap justify-center gap-5">
                <a href="auth/register.php" class="bg-white text-emerald-700 px-8 py-4 rounded-2xl font-bold hover:scale-105 transition shadow-xl">Buat Akun</a>
                <a href="auth/login.php" class="border border-white px-8 py-4 rounded-2xl font-bold hover:bg-white hover:text-emerald-700 transition">Login</a>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-8 text-center text-sm">
        © 2026 Sistem Pengaduan Masyarakat. All Rights Reserved.
    </footer>

</body>
</html>
