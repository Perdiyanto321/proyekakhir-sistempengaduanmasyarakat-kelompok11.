<?php
session_start();
require "../config/koneksi.php";

if (!isset($_SESSION["login"])) { header("Location: ../auth/login.php"); exit(); }

$user_id = $_SESSION["user_id"];
$query   = mysqli_prepare($koneksi,
    "SELECT laporan.*, tanggapan.respon AS tanggapan_respon, tanggapan.created_at AS tanggapan_waktu
     FROM laporan
     LEFT JOIN tanggapan ON tanggapan.laporan_id = laporan.id
     WHERE laporan.user_id = ? ORDER BY laporan.id DESC");
mysqli_stmt_bind_param($query, "i", $user_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);

$activePage = 'tanggapan';
$pageTitle  = 'Tanggapan';
$assetBase  = '../assets';
?>
<!DOCTYPE html>
<html lang="id">
<head><?php require "../includes/head.php"; ?></head>
<body class="bg-slate-100 text-slate-800 main-bg">
<div class="flex min-h-screen">

<?php require "../includes/sidebar_user.php"; ?>

<main class="flex-1 pt-16 lg:pt-0">

    <header class="topbar bg-white shadow-sm px-6 py-5">
        <h2 class="text-2xl font-bold">Tanggapan Laporan 💬</h2>
        <p class="text-slate-500 mt-1">Lihat tanggapan admin atas laporan Anda</p>
    </header>

    <section class="p-6 space-y-5">

        <?php if (mysqli_num_rows($result) == 0) : ?>
            <div class="card bg-white rounded-2xl shadow-sm p-10 text-center">
                <span class="text-5xl">📭</span>
                <p class="text-slate-500 mt-4 text-lg">Belum ada laporan yang Anda buat.</p>
                <a href="buatlaporan.php" class="mt-5 inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl transition">Buat Laporan</a>
            </div>
        <?php else : ?>

            <?php while ($laporan = mysqli_fetch_assoc($result)) : ?>
            <div class="card bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="p-5 flex gap-4">
                    <img src="../upload/<?= $laporan["foto"]; ?>" class="w-20 h-20 rounded-xl object-cover flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h3 class="font-bold text-base"><?= htmlspecialchars($laporan["judul"]); ?></h3>
                            <?php if ($laporan["STATUS"] == "menunggu") : ?><span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-lg text-xs font-semibold">Menunggu</span>
                            <?php elseif ($laporan["STATUS"] == "proses") : ?><span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-lg text-xs font-semibold">Diproses</span>
                            <?php elseif ($laporan["STATUS"] == "selesai") : ?><span class="bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-lg text-xs font-semibold">Selesai</span>
                            <?php elseif ($laporan["STATUS"] == "ditolak") : ?><span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-lg text-xs font-semibold">Ditolak</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-slate-500 text-sm">📍 <?= htmlspecialchars($laporan["lokasi"]); ?></p>
                        <p class="text-slate-400 text-xs mt-0.5"><?= $laporan["created_at"]; ?></p>
                    </div>
                </div>

                <div class="border-t border-slate-100 px-5 pb-5 pt-4">
                    <p class="text-xs font-semibold text-slate-500 mb-2">💬 Tanggapan Admin</p>
                    <?php if (!empty($laporan["tanggapan_respon"])) : ?>
                        <div class="tanggapan-box bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                            <p class="text-slate-700 text-sm leading-relaxed"><?= nl2br(htmlspecialchars($laporan["tanggapan_respon"])); ?></p>
                            <p class="text-emerald-600 text-xs mt-2 font-medium">✅ <?= $laporan["tanggapan_waktu"]; ?></p>
                        </div>
                    <?php else : ?>
                        <div class="tanggapan-empty bg-slate-50 border border-slate-200 rounded-xl p-4 text-center">
                            <p class="text-slate-400 italic text-sm">⏳ Admin belum memberikan tanggapan.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <?php endwhile; ?>

        <?php endif; ?>

    </section>
</main>
</div>
</body>
</html>
