<?php
session_start();
require "../config/koneksi.php";

if (!isset($_SESSION["login"])) { header("Location: ../auth/login.php"); exit(); }

$user_id = $_SESSION["user_id"];
$result  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'"));

$activePage = 'profil';
$pageTitle  = 'Profil Saya';
$assetBase  = '../assets';
?>
<!DOCTYPE html>
<html lang="id">
<head><?php require "../includes/head.php"; ?></head>
<body class="bg-slate-100 text-slate-800 main-bg">
<div class="flex min-h-screen">

<?php require "../includes/sidebar_user.php"; ?>

<main class="flex-1 pt-16 lg:pt-0 p-6">

    <div class="card bg-white rounded-2xl shadow-sm overflow-hidden max-w-3xl">

        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-10 text-white">
            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <img src="https://i.pravatar.cc/150" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                <div>
                    <h1 class="text-3xl font-bold"><?= htmlspecialchars($result["nama"]); ?></h1>
                    <p class="mt-1 text-emerald-100"><?= htmlspecialchars($result["email"]); ?></p>
                    <span class="inline-block mt-3 bg-white text-emerald-600 px-4 py-1.5 rounded-xl text-sm font-semibold">
                        <?= $result["role"]; ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid md:grid-cols-2 gap-4 mb-8">
                <div class="bg-slate-50 rounded-xl p-5">
                    <p class="text-slate-500 text-sm mb-1">Nama Lengkap</p>
                    <h2 class="text-xl font-bold"><?= htmlspecialchars($result["nama"]); ?></h2>
                </div>
                <div class="bg-slate-50 rounded-xl p-5">
                    <p class="text-slate-500 text-sm mb-1">Email</p>
                    <h2 class="text-xl font-bold"><?= htmlspecialchars($result["email"]); ?></h2>
                </div>
                <div class="bg-slate-50 rounded-xl p-5">
                    <p class="text-slate-500 text-sm mb-1">Role</p>
                    <h2 class="text-xl font-bold"><?= $result["role"]; ?></h2>
                </div>
                <div class="bg-slate-50 rounded-xl p-5">
                    <p class="text-slate-500 text-sm mb-1">ID User</p>
                    <h2 class="text-xl font-bold">#<?= $result["id"]; ?></h2>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="gantipassword.php" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition">🔒 Ganti Password</a>
                <a href="dashboard_user.php" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-semibold transition">Kembali</a>
            </div>
        </div>

    </div>

</main>
</div>
</body>
</html>
