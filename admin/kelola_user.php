<?php

session_start();
require "../config/koneksi.php";

if (!isset($_SESSION["login_admin"])) {
    header("Location: ../auth/login.php");
    exit();
}

$keyword = "";

if (isset($_GET["search"])) {
    $keyword = htmlspecialchars($_GET["keyword"]);
    $query   = mysqli_prepare($koneksi,
        "SELECT * FROM users WHERE nama LIKE ? OR email LIKE ? ORDER BY id DESC");
    $search = "%$keyword%";
    mysqli_stmt_bind_param($query, "ss", $search, $search);
} else {
    $query = mysqli_prepare($koneksi,
        "SELECT * FROM users WHERE role = 'user' ORDER BY id DESC");
}
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);

$activePage = 'user';
$pageTitle  = 'Data User';
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
                <h2 class="text-2xl font-bold">Data User 👥</h2>
                <p class="text-slate-500 mt-1">Kelola seluruh user sistem</p>
            </div>
            <form action="" method="GET" class="w-full md:w-[420px]">
                <div class="search-wrap flex items-center bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 focus-within:ring-4 focus-within:ring-emerald-100">
                    <input type="text" name="keyword" value="<?= $keyword; ?>" placeholder="Cari user..." class="w-full px-5 py-3 bg-transparent outline-none">
                    <button type="submit" name="search" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 transition">Cari</button>
                </div>
            </form>
        </header>

        <section class="p-6">
            <div class="card bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-xl font-bold">Data Seluruh User</h2>
                    <p class="text-slate-500 text-sm mt-1">Semua user yang terdaftar di sistem</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-left px-6 py-4 font-semibold text-sm">No</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Nama</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Email</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Jumlah Laporan</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($user = mysqli_fetch_assoc($result)) : ?>
                            <?php $laporan = mysqli_query($koneksi, "SELECT * FROM laporan WHERE user_id = '{$user['id']}'"); ?>
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition duration-200">
                                <td class="px-6 py-4"><?= $no++; ?></td>
                                <td class="px-6 py-4 font-medium"><?= htmlspecialchars($user["nama"]); ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($user["email"]); ?></td>
                                <td class="px-6 py-4">
                                    <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-lg text-sm font-semibold">
                                        <?= mysqli_num_rows($laporan); ?> laporan
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="hapus_user.php?id=<?= $user["id"]; ?>" onclick="return confirm('Yakin ingin menghapus user?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">Hapus</a>
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
