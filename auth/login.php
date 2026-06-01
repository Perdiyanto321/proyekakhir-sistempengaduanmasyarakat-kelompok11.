<?php

session_start();

require "../config/koneksi.php";

if (isset($_POST["kirim"])) {

    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $role     = htmlspecialchars($_POST["pilih"]);

    if (empty($username)) {
        echo "<script>alert('Username tidak boleh kosong!');</script>";
    } elseif (empty($password)) {
        echo "<script>alert('Password tidak boleh kosong!');</script>";
    } else {
        $query = mysqli_prepare($koneksi, "SELECT * FROM users WHERE nama = ? AND role = ?");
        mysqli_stmt_bind_param($query, "ss", $username, $role);
        mysqli_stmt_execute($query);
        $result = mysqli_stmt_get_result($query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if ($role === "admin") {
                if ($password === $user["password"]) {
                    $_SESSION["login_admin"] = true;
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["role"] = $user["role"];
                    $_SESSION["nama"] = $user["nama"];
                    header("Location: ../admin/dashboard_admin.php");
                } else {
                    echo "<script>alert('Password salah!');</script>";
                }
            }

            if ($role === "user") {
                if (password_verify($password, $user["password"])) {
                    $_SESSION["login"] = true;
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["role"] = $user["role"];
                    $_SESSION["nama"] = $user["nama"];
                    header("Location: ../user/dashboard_user.php");
                } else {
                    echo "<script>alert('Password salah!');</script>";
                }
            }
        } else {
            echo "<script>alert('Akun tidak ditemukan!');</script>";
        }
    }

}

    
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – PengaduanKu</title>
    <script>
        (function() {
            if (localStorage.getItem('pengaduanku_theme') === 'dark')
                document.documentElement.classList.add('dark');
        })();
    </script>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
        }
    </style>
    <script src="../assets/js/app.js"></script>
</head>
<body class="min-h-screen bg-slate-100 main-bg flex items-center justify-center p-6">

    <button data-theme-toggle aria-label="Toggle tema"
        class="fixed top-5 right-5 z-50 flex items-center gap-2 bg-white card shadow-md hover:shadow-lg px-4 py-2 rounded-xl transition text-sm font-medium">
        <span data-theme-icon>🌙</span>
        <span data-theme-label class="hidden sm:inline">Dark Mode</span>
    </button>

    <div class="w-full max-w-5xl card bg-white rounded-3xl shadow-2xl shadow-emerald-800/10 overflow-hidden grid md:grid-cols-2">

        <div class="hidden md:flex flex-col justify-center bg-gradient-to-br from-emerald-400 to-emerald-800 text-white p-12">
            <h1 class="text-4xl font-bold leading-tight mb-6">Sistem Pengaduan<br>Masyarakat</h1>
            <p class="text-emerald-100 text-lg leading-relaxed mb-8">
                Laporkan masalah lingkungan, fasilitas umum, atau pelayanan dengan mudah dan cepat.
            </p>
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center text-sm">✓</div>
                    <span>Laporan realtime</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center text-sm">✓</div>
                    <span>Pantau status laporan</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center text-sm">✓</div>
                    <span>Respon admin cepat</span>
                </div>
            </div>
        </div>

        <div class="auth-right p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-2">Login</h2>
                <p class="text-slate-500">Silakan masuk ke akun Anda</p>
            </div>

            <form action="" method="POST" class="space-y-5">

                <div>
                    <label class="auth-label block mb-2 text-sm font-semibold">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition">
                </div>

                <div>
                    <label class="auth-label block mb-2 text-sm font-semibold">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition">
                </div>

                <div>
                    <label class="auth-label block mb-2 text-sm font-semibold">Login sebagai</label>
                    <select name="pilih" class="w-full px-4 py-3 rounded-xl border border-slate-300 outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <button type="submit" name="kirim" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl transition shadow-lg hover:shadow-xl">
                    Masuk
                </button>

            </form>

            <p class="text-center text-slate-600 mt-8">
                Belum punya akun?
                <a href="register.php" class="text-emerald-600 font-semibold hover:underline">Daftar sekarang</a>
            </p>
            <p class="text-center text-slate-600 mt-3">
                <a href="../index.php" class="text-emerald-600 hover:underline">← Kembali ke Beranda</a>
            </p>
        </div>

    </div>

</body>
</html>
