<?php
session_start();
require "../config/koneksi.php";

if (!isset($_SESSION["login"])) { header("Location: ../auth/login.php"); exit(); }

$user_id = $_SESSION["user_id"];

if (isset($_POST["ganti"])) {
    $passwordLama = $_POST["password_lama"];
    $passwordBaru = $_POST["password_baru"];
    $konfirmasi   = $_POST["konfirmasi"];

    $q = mysqli_prepare($koneksi, "SELECT * FROM users WHERE id = ?");
    mysqli_stmt_bind_param($q, "i", $user_id);
    mysqli_stmt_execute($q);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($q));

    if (empty($passwordLama)) {
        echo "
            <script>
                alert('Password lama tidak boleh kosong');
            </script>
        "; 
    } elseif (empty($passwordBaru)) {
        echo "
            <script>
                alert('Password baru tidak boleh kosong');
            </script>
        "; 
    } elseif ((empty($passwordBaru) || empty($konfirmasi))) {
        echo "
            <script>
                alert('Password atau konfirmasi passwordtidak boleh kosong');
            </script>
        ";  
    } else {
        
        if (!password_verify($passwordLama, $user["password"])) {
        echo "<script>alert('Password lama salah');</script>";
        } elseif (strlen($passwordBaru) <= 8 || strlen($passwordBaru) >= 16) {
            echo "<script>alert('Password harus 8-16 karakter');</script>";
        } elseif ($passwordBaru !== $konfirmasi) {
            echo "<script>alert('Konfirmasi password tidak cocok');</script>";
        } else {
            $hash = password_hash($passwordBaru, PASSWORD_DEFAULT);
            $upd  = mysqli_prepare($koneksi, "UPDATE users SET password = ? WHERE id = ?");
            mysqli_stmt_bind_param($upd, "si", $hash, $user_id);
            mysqli_stmt_execute($upd);
            echo "<script>alert('Password berhasil diubah!'); window.location.href = 'detail_user.php';</script>";
        }
    }

}

$activePage = 'profil';
$pageTitle  = 'Ganti Password';
$assetBase  = '../assets';
?>
<!DOCTYPE html>
<html lang="id">
<head><?php require "../includes/head.php"; ?></head>
<body class="bg-slate-100 text-slate-800 main-bg">
    <div class="flex min-h-screen">
        <?php require "../includes/sidebar_user.php"; ?>

        <main class="flex-1 pt-16 lg:pt-0 flex items-center justify-center p-6">

            <div class="card bg-white rounded-2xl shadow-sm p-8 w-full max-w-lg">

                <div class="mb-8">
                    <h1 class="text-2xl font-bold">Ganti Password 🔒</h1>
                    <p class="text-slate-500 mt-1">Pastikan password baru mudah diingat dan aman</p>
                </div>

                <form action="" method="POST" class="space-y-5">

                    <div>
                        <label class="block mb-2 text-sm font-semibold">Password Lama</label>
                        <input type="password" name="password_lama" 
                            class="w-full border border-slate-200 rounded-xl px-5 py-3 outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">Password Baru</label>
                        <input type="password" name="password_baru" 
                            class="w-full border border-slate-200 rounded-xl px-5 py-3 outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi" 
                            class="w-full border border-slate-200 rounded-xl px-5 py-3 outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition">
                    </div>

                    <div class="flex gap-3 pt-2">
                        <a href="detail_user.php" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-semibold transition">Kembali</a>
                        <button type="submit" name="ganti" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl font-semibold transition">
                            Ganti Password
                        </button>
                    </div>

                </form>

            </div>

        </main>
    </div>
</body>
</html>
