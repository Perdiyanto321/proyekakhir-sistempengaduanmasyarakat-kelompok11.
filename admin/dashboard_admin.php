<?php

session_start();
require "../config/koneksi.php";

if (!isset($_SESSION["login_admin"])) {
    header("Location: ../auth/login.php");
    exit();
}

$totalLaporan  = mysqli_query($koneksi, "SELECT * FROM laporan");
$totalMenunggu = mysqli_query($koneksi, "SELECT * FROM laporan WHERE status = 'menunggu'");
$totalProses   = mysqli_query($koneksi, "SELECT * FROM laporan WHERE status = 'proses'");
$totalSelesai  = mysqli_query($koneksi, "SELECT * FROM laporan WHERE status = 'selesai'");
$totalditolak  = mysqli_query($koneksi, "SELECT * FROM laporan WHERE status = 'ditolak'");
$totalUsers    = mysqli_query($koneksi, "SELECT * FROM users WHERE role = 'user'");

$keyword = "";

if (isset($_GET["search"])) {
    $keyword = htmlspecialchars($_GET["keyword"]);
    $query   = mysqli_prepare($koneksi,
        "SELECT laporan.*, users.nama FROM laporan
         JOIN users ON laporan.user_id = users.id
         WHERE laporan.judul LIKE ? OR laporan.lokasi LIKE ? OR users.nama LIKE ?
         ORDER BY laporan.id DESC");
    $search = "%$keyword%";
    mysqli_stmt_bind_param($query, "sss", $search, $search, $search);
} else {
    $query = mysqli_prepare($koneksi,
        "SELECT laporan.*, users.nama FROM laporan
         JOIN users ON laporan.user_id = users.id
         ORDER BY laporan.id DESC");
}
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);

$activePage = 'dashboard';
$pageTitle  = 'Dashboard Admin';
$assetBase  = '../assets';
?>
<!DOCTYPE html>
<html lang="id">
<head><?php require "../includes/head.php"; ?></head>
<body class="bg-slate-100 text-slate-800 main-bg">

<div class="flex min-h-screen">

    <?php require "../includes/sidebar_admin.php"; ?>

    <main class="flex-1 lg:ml-0 pt-16 lg:pt-0">

        <header class="topbar bg-white shadow-sm px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div>
                <h2 class="text-2xl font-bold">Dashboard Admin 👨‍💼</h2>
                <p class="text-slate-500 mt-1">Kelola seluruh laporan masyarakat</p>
            </div>
            <form action="" method="GET" class="w-full md:w-[420px]">
                <div class="search-wrap flex items-center bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 focus-within:ring-4 focus-within:ring-emerald-100">
                    <input type="text" name="keyword" value="<?= $keyword; ?>" placeholder="Cari laporan..." class="w-full px-5 py-3 bg-transparent outline-none">
                    <button type="submit" name="search" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 transition duration-300">Cari</button>
                </div>
            </form>
        </header>

        <section class="p-6">

            <div class="grid md:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">

                <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-slate-500 text-sm font-medium">Total Laporan</h3>
                        <span class="text-2xl">📄</span>
                    </div>
                    <h2 class="text-3xl font-bold"><?= mysqli_num_rows($totalLaporan); ?></h2>
                </div>

                <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-slate-500 text-sm font-medium">Menunggu</h3>
                        <span class="text-2xl">⏳</span>
                    </div>
                    <h2 class="text-3xl font-bold text-yellow-500"><?= mysqli_num_rows($totalMenunggu); ?></h2>
                </div>

                <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-slate-500 text-sm font-medium">Diproses</h3>
                        <span class="text-2xl">⚡</span>
                    </div>
                    <h2 class="text-3xl font-bold text-blue-500"><?= mysqli_num_rows($totalProses); ?></h2>
                </div>

                <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-slate-500 text-sm font-medium">Selesai</h3>
                        <span class="text-2xl">✅</span>
                    </div>
                    <h2 class="text-3xl font-bold text-emerald-500"><?= mysqli_num_rows($totalSelesai); ?></h2>
                </div>
                <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-slate-500 text-sm font-medium">Ditolak</h3>
                        <span class="text-2xl">❌</span>
                    </div>
                    <h2 class="text-3xl font-bold text-red-500"><?= mysqli_num_rows($totalditolak); ?></h2>
                </div>

                <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-slate-500 text-sm font-medium">Total Users</h3>
                        <span class="text-2xl">👥</span>
                    </div>
                    <h2 class="text-3xl font-bold"><?= mysqli_num_rows($totalUsers); ?></h2>
                </div>

            </div>

            <div class="card bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-xl font-bold">Data Laporan</h2>
                    <p class="text-slate-500 text-sm mt-1">Seluruh laporan masyarakat</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-left px-6 py-4 font-semibold text-sm">No</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Pelapor</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Judul</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Lokasi</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Foto</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($laporan = mysqli_fetch_assoc($result)) : ?>
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition duration-200">
                                <td class="px-6 py-4"><?= $no++; ?></td>
                                <td class="px-6 py-4 font-medium"><?= htmlspecialchars($laporan["nama"]); ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($laporan["judul"]); ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($laporan["lokasi"]); ?></td>
                                <td class="px-6 py-4"><img src="../upload/<?= $laporan["foto"]; ?>" class="w-16 h-16 rounded-xl object-cover"></td>
                                <td class="px-6 py-4">
                                    <?php if ($laporan["STATUS"] == "menunggu") : ?>
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-xs font-semibold">Menunggu</span>
                                    <?php elseif ($laporan["STATUS"] == "proses") : ?>
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-xs font-semibold">Diproses</span>
                                    <?php elseif ($laporan["STATUS"] == "selesai") : ?>
                                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-lg text-xs font-semibold">Selesai</span>
                                    <?php elseif ($laporan["STATUS"] == "ditolak") : ?>
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-xs font-semibold">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </section>

    </main>

</div>

</body>
</html>
