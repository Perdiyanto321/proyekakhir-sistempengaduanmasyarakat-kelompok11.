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
        "SELECT laporan.*, users.nama,
                (SELECT respon FROM tanggapan WHERE tanggapan.laporan_id = laporan.id ORDER BY tanggapan.id DESC LIMIT 1) AS tanggapan_respon,
                (SELECT created_at FROM tanggapan WHERE tanggapan.laporan_id = laporan.id ORDER BY tanggapan.id DESC LIMIT 1) AS tanggapan_waktu
         FROM laporan
         JOIN users ON laporan.user_id = users.id
         WHERE laporan.judul LIKE ? OR laporan.lokasi LIKE ? OR users.nama LIKE ?
         ORDER BY laporan.id DESC");
    $search = "%$keyword%";
    mysqli_stmt_bind_param($query, "sss", $search, $search, $search);
} else {
    $query = mysqli_prepare($koneksi,
        "SELECT laporan.*, users.nama,
                (SELECT respon FROM tanggapan WHERE tanggapan.laporan_id = laporan.id ORDER BY tanggapan.id DESC LIMIT 1) AS tanggapan_respon,
                (SELECT created_at FROM tanggapan WHERE tanggapan.laporan_id = laporan.id ORDER BY tanggapan.id DESC LIMIT 1) AS tanggapan_waktu
         FROM laporan
         JOIN users ON laporan.user_id = users.id
         ORDER BY laporan.id DESC");
}
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);

$activePage = 'tanggapan';
$pageTitle  = 'Kelola Tanggapan';
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
                <h2 class="text-2xl font-bold">Kelola Tanggapan 💬</h2>
                <p class="text-slate-500 mt-1">Berikan tanggapan untuk setiap laporan masyarakat</p>
            </div>
            <form action="" method="GET" class="w-full md:w-[420px]">
                <div class="search-wrap flex items-center bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 focus-within:ring-4 focus-within:ring-emerald-100">
                    <input type="text" name="keyword" value="<?= $keyword; ?>" placeholder="Cari laporan..." class="w-full px-5 py-3 bg-transparent outline-none">
                    <button type="submit" name="search" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 transition">Cari</button>
                </div>
            </form>
        </header>

        <section class="p-6">

            <?php if (isset($_GET["berhasil"])) : ?>
                <div id="alertBerhasil" class="bg-emerald-100 border border-emerald-300 text-emerald-700 px-5 py-4 rounded-2xl mb-5 flex items-center justify-between">
                    <span>✅ Tanggapan berhasil dikirim!</span>
                    <button onclick="document.getElementById('alertBerhasil').remove()" class="text-emerald-500 hover:text-emerald-700 font-bold text-lg">&times;</button>
                </div>
            <?php endif; ?>

            <div class="card bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-xl font-bold">Daftar Laporan</h2>
                    <p class="text-slate-500 text-sm mt-1">Klik "Beri Tanggapan" untuk merespons laporan</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="text-left px-6 py-4 font-semibold text-sm">No</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Pelapor</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Judul</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Status</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Tanggapan</th>
                                <th class="text-left px-6 py-4 font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($laporan = mysqli_fetch_assoc($result)) : ?>
                                <tr class="border-b border-slate-100 hover:bg-slate-50 transition duration-200">
                                    <td class="px-6 py-4"><?= $no++; ?></td>
                                    <td class="px-6 py-4 font-medium"><?= htmlspecialchars($laporan["nama"]); ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($laporan["judul"]); ?></td>
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
                                    <td class="px-6 py-4 max-w-xs">
                                        <?php if (!empty($laporan["tanggapan_respon"])) : ?>
                                            <p class="text-sm line-clamp-2"><?= htmlspecialchars($laporan["tanggapan_respon"]); ?></p>
                                            <p class="text-slate-400 text-xs mt-1"><?= $laporan["tanggapan_waktu"]; ?></p>
                                        <?php else : ?>
                                            <span class="text-slate-400 text-sm italic">Belum ada tanggapan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button
                                            onclick="bukaModal(<?= $laporan['id']; ?>, '<?= addslashes(htmlspecialchars($laporan['judul'])); ?>', '<?= addslashes(htmlspecialchars($laporan['tanggapan_respon'] ?? '')); ?>')"
                                            class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                            <?= !empty($laporan["tanggapan_respon"]) ? "Edit" : "Beri Tanggapan"; ?>
                                        </button>
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

<div id="modalTanggapan" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="modal-box bg-white rounded-2xl shadow-2xl w-full max-w-lg">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold">Beri Tanggapan 💬</h3>
                <p id="modalJudul" class="text-slate-500 mt-0.5 text-sm"></p>
            </div>
            <button onclick="tutupModal()" class="text-slate-400 hover:text-slate-600 text-3xl font-bold leading-none">&times;</button>
        </div>
        <form action="simpan_tanggapan.php" method="POST" class="p-6">
            <input type="hidden" name="laporan_id" id="laporanId">
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">Isi Tanggapan <span class="text-red-500">*</span></label>
                <textarea name="respon" id="isiTanggapan" rows="5" placeholder="Tulis tanggapan Anda..." required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 resize-none"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl font-semibold transition">Kirim Tanggapan</button>
                <button type="button" onclick="tutupModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-3 rounded-xl font-semibold transition">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function bukaModal(id, judul, tanggapan) {
    document.getElementById('laporanId').value = id;
    document.getElementById('modalJudul').textContent = judul;
    document.getElementById('isiTanggapan').value = tanggapan;
    document.getElementById('modalTanggapan').classList.remove('hidden');
    document.getElementById('modalTanggapan').classList.add('flex');
}
function tutupModal() {
    document.getElementById('modalTanggapan').classList.add('hidden');
    document.getElementById('modalTanggapan').classList.remove('flex');
}
document.getElementById('modalTanggapan').addEventListener('click', function(e) {
    if (e.target === this) tutupModal();
});
</script>

</body>
</html>
