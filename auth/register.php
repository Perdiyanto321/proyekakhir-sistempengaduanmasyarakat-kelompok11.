<?php

require "../config/koneksi.php";

if (isset($_POST["kirim"])) {

    $nama      = htmlspecialchars($_POST["nama"]);
    $email     = htmlspecialchars($_POST["email"]);
    $password  = htmlspecialchars($_POST["password"]);
    $password1 = htmlspecialchars($_POST["password1"]);

    if (empty($nama)) {
        echo "
            <script>
                alert('Username tidak boleh kosong');
            </script>
        ";   
    } elseif (empty($email)) {
        echo "
            <script>
                alert('Email tidak boleh kosong');
            </script>
        ";
    } elseif (empty($password) || empty($password1)) {
        echo "
            <script>
                alert('Password atau konfirmasi passwordtidak boleh kosong');
            </script>
        ";  
    } else {

        $user = mysqli_prepare(
            $koneksi,
            "SELECT id FROM users WHERE nama = ?"
        );

        mysqli_stmt_bind_param($user, "s", $nama);
        mysqli_stmt_execute($user);

        $result_user = mysqli_stmt_get_result($user);

        $qemail = mysqli_prepare(
            $koneksi,
            "SELECT id FROM users WHERE email = ?"
        );

        mysqli_stmt_bind_param($qemail, "s", $email);
        mysqli_stmt_execute($qemail);

        $result_email = mysqli_stmt_get_result($qemail);

        if (mysqli_num_rows($result_user) > 0) {

            echo "
                <script>
                    alert('Username sudah terdaftar');
                </script>
            ";

        } elseif (mysqli_num_rows($result_email) > 0) {

            echo "
                <script>
                    alert('Email sudah terdaftar');
                </script>
            ";
        } else {

            if (strlen($password) < 8 || strlen($password) > 16) {

                echo "
                    <script>
                        alert('Password harus 8-16 karakter');
                    </script>
                ";

            } elseif ($password !== $password1) {

                echo "
                    <script>
                        alert('Konfirmasi password tidak valid');
                    </script>
                ";

            } else {

                $passwordHash = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $insert = mysqli_prepare(
                    $koneksi,
                    "INSERT INTO users (nama, email, password)
                    VALUES (?, ?, ?)"
                );

                mysqli_stmt_bind_param(
                    $insert,
                    "sss",
                    $nama,
                    $email,
                    $passwordHash
                );

                mysqli_stmt_execute($insert);

                if (mysqli_affected_rows($koneksi) > 0) {

                    echo "
                        <script>
                            alert('Akun berhasil dibuat');
                            window.location.href = 'login.php';
                        </script>
                    ";

                } else {

                    echo "
                        <script>
                            alert('Akun gagal dibuat');
                        </script>
                    ";

                }

            }

        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi – PengaduanKu</title>
    <script>
        (function() {
            if (localStorage.getItem("pengaduanku_theme") === "dark")
                document.documentElement.classList.add("dark");
        })();
    </script>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: "class" }</script>
    <style>body { font-family: "Segoe UI", sans-serif; }</style>
    <script src="../assets/js/app.js"></script>
</head>
<body class="min-h-screen bg-slate-100 main-bg flex items-center justify-center p-6">

    <!-- Dark mode toggle -->
    <button data-theme-toggle aria-label="Toggle tema"
        class="fixed top-5 right-5 z-50 flex items-center gap-2 bg-white card shadow-md hover:shadow-lg px-4 py-2 rounded-xl transition text-sm font-medium">
        <span data-theme-icon>🌙</span>
        <span data-theme-label class="hidden sm:inline">Dark Mode</span>
    </button>

    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

        <div class="hidden md:flex flex-col justify-center bg-gradient-to-br from-emerald-600 to-emerald-800 text-white p-12">

            <h1 class="text-4xl font-bold leading-tight mb-6">
                Buat Akun <br>
                Pengaduan
            </h1>

            <p class="text-emerald-100 text-lg leading-relaxed mb-8">
                Daftarkan akun Anda untuk mulai membuat laporan pengaduan
                secara cepat, aman, dan terintegrasi.
            </p>

            <div class="space-y-4">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        â
                    </div>
                    <span>Upload foto laporan</span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        â
                    </div>
                    <span>Pantau status realtime</span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        â
                    </div>
                    <span>Respon admin transparan</span>
                </div>

            </div>

        </div>

        <div class="p-8 md:p-12 flex flex-col justify-center">

            <div class="mb-5">
                <h2 class="text-3xl font-bold text-slate-800 mb-2">
                    Register
                </h2>
            </div>

            <form action="" method="POST" class="space-y-5">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Username
                    </label>

                    <input type="text" name="nama" placeholder="Masukkan username" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Email
                    </label>

                    <input type="email" name="email" placeholder="Masukkan email" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Password
                    </label>

                    <input type="password" name="password" placeholder="Masukkan password" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Konfirmasi Password
                    </label>

                    <input type="password" name="password1" placeholder="Masukkan password" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition">
                </div>

                <button type="submit" name="kirim" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl transition duration-300 shadow-lg hover:shadow-xl">Daftar Sekarang</button>

            </form>

            <p class="text-center text-slate-600 mt-8">
                Sudah punya akun?
                <a href="login.php" class="text-emerald-600 font-semibold hover:underline">
                    Login
                </a>
            </p>
            <p class="text-center text-slate-600 mt-8">
                <a href="../index.php" class="text-emerald-600 font-emerald-600 hover:underline">Kembali ke Beranda</a>
            </p>

        </div>

    </div>

</body>
</html>