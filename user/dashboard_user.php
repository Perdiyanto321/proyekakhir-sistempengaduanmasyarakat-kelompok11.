<?php
session_start();
require "../config/koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: ../auth/login.php"); 
    exit(); 
}

$user_id = $_SESSION["user_id"];
$total   = mysqli_query($koneksi, "SELECT * FROM laporan WHERE user_id = '$user_id'");
$proses  = mysqli_query($koneksi, "SELECT * FROM laporan WHERE user_id = '$user_id' AND status = 'proses'");
$selesai = mysqli_query($koneksi, "SELECT * FROM laporan WHERE user_id = '$user_id' AND status = 'selesai'");
$ditolak = mysqli_query($koneksi, "SELECT * FROM laporan WHERE user_id = '$user_id' AND status = 'ditolak'");

$keyword = "";
if (isset($_GET["search"])) {
    $keyword = htmlspecialchars($_GET["keyword"]);
    $query   = mysqli_prepare($koneksi, "SELECT * FROM laporan WHERE user_id = ? AND judul LIKE ? ORDER BY id DESC");
    $search  = "%$keyword%";
    mysqli_stmt_bind_param($query, "is", $user_id, $search);
} else {
    $query = mysqli_prepare($koneksi, "SELECT * FROM laporan WHERE user_id = ? ORDER BY id DESC");
    mysqli_stmt_bind_param($query, "i", $user_id);
}
mysqli_stmt_execute($query);
$result   = mysqli_stmt_get_result($query);
$userRow  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'"));

$activePage = 'dashboard';
$pageTitle  = 'Dashboard';
$assetBase  = '../assets';
?>
<!DOCTYPE html>
<html lang="id">
<head><?php require "../includes/head.php"; ?></head>
<body class="bg-slate-100 text-slate-800 main-bg">
<div class="flex min-h-screen">

<?php require "../includes/sidebar_user.php"; ?>

<main class="flex-1 pt-16 lg:pt-0">

    <header class="topbar bg-white shadow-sm px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold">Selamat Datang, <?= htmlspecialchars($userRow["nama"]); ?> 👋</h2>
            <p class="text-slate-500 mt-1">Pantau dan kelola laporan Anda</p>
        </div>
        <form action="" method="GET" class="w-full md:w-[400px]">
            <div class="search-wrap flex items-center bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 focus-within:ring-4 focus-within:ring-emerald-100">
                <input type="text" name="keyword" value="<?= $keyword; ?>" placeholder="Cari laporan..." class="w-full px-5 py-3 bg-transparent outline-none">
                <button type="submit" name="search" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 transition">Cari</button>
            </div>
        </form>
    </header>

    <section class="p-6">

        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
            <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                <p class="text-slate-500 text-sm mb-2">Total Laporan</p>
                <h2 class="text-3xl font-bold">📄 <?= mysqli_num_rows($total); ?></h2>
            </div>
            <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                <p class="text-slate-500 text-sm mb-2">Diproses</p>
                <h2 class="text-3xl font-bold text-blue-500">⚡ <?= mysqli_num_rows($proses); ?></h2>
            </div>
            <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                <p class="text-slate-500 text-sm mb-2">Selesai</p>
                <h2 class="text-3xl font-bold text-emerald-500">✅ <?= mysqli_num_rows($selesai); ?></h2>
            </div>
            <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                <p class="text-slate-500 text-sm mb-2">Ditolak</p>
                <h2 class="text-3xl font-bold text-red-500">❌ <?= mysqli_num_rows($ditolak); ?></h2>
            </div>
        </div>

        <div class="card bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold">Aktivitas Laporan</h2>
                    <p class="text-slate-500 text-sm mt-1">Riwayat laporan terbaru Anda</p>
                </div>
                <a href="buatlaporan.php" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">+ Buat Laporan</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="text-left px-6 py-4 font-semibold text-sm">No</th>
                            <th class="text-left px-6 py-4 font-semibold text-sm">Judul</th>
                            <th class="text-left px-6 py-4 font-semibold text-sm">Lokasi</th>
                            <th class="text-left px-6 py-4 font-semibold text-sm">Status</th>
                            <th class="text-left px-6 py-4 font-semibold text-sm">Foto</th>
                            <th class="text-left px-6 py-4 font-semibold text-sm">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($laporan = mysqli_fetch_assoc($result)) : ?>
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="px-6 py-4"><?= $no++; ?></td>
                            <td class="px-6 py-4 font-medium"><?= htmlspecialchars($laporan["judul"]); ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($laporan["lokasi"]); ?></td>
                            <td class="px-6 py-4">
                                <?php if ($laporan["STATUS"] == "menunggu") : ?><span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-xs font-semibold">Menunggu</span>
                                <?php elseif ($laporan["STATUS"] == "proses") : ?><span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-xs font-semibold">Diproses</span>
                                <?php elseif ($laporan["STATUS"] == "selesai") : ?><span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-lg text-xs font-semibold">Selesai</span>
                                <?php elseif ($laporan["STATUS"] == "ditolak") : ?><span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-xs font-semibold">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4"><img src="../upload/<?= $laporan["foto"]; ?>" class="w-16 h-16 rounded-xl object-cover"></td>
                            <td class="px-6 py-4 text-sm"><?= $laporan["created_at"]; ?></td>
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
