<?php
session_start();
require "../config/koneksi.php";

if (!isset($_SESSION["login"])) { 
    header("Location: ../auth/login.php"); 
    exit(); 
}

if (isset($_POST["kirim"])) {
    $user_id = $_SESSION["user_id"];
    $judul = htmlspecialchars($_POST["judul"]);
    $isi = htmlspecialchars($_POST["isi"]);
    $lokasi = htmlspecialchars($_POST["lokasi"]);
    $foto = $_FILES["foto"]["name"];
    $tmp = $_FILES["foto"]["tmp_name"];
    $ekstensiValid = ["jpg", "jpeg", "png"];
    $ekstensi = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

    if (empty($judul)) {
        echo "<script>alert('Judul laporan tidak boleh kosong');</script>";     
    } elseif (empty($isi)) {
        echo "<script>alert('Isi laporan tidak boleh kosong');</script>"; 
    } elseif (empty($lokasi)) {
        echo "<script>alert('Lokasi laporan tidak boleh kosong');</script>"; 
    } elseif (empty($foto)) {
        echo "<script>alert('Foto laporan tidak boleh kosong');</script>"; 
    } else {
        if (!in_array($ekstensi, $ekstensiValid)) {
            echo "<script>alert('Format foto tidak valid!');</script>";
        } else {
            $namaFotoBaru = uniqid() . "." . $ekstensi;
            move_uploaded_file($tmp, "../upload/" . $namaFotoBaru);
            $query = mysqli_prepare($koneksi,
                "INSERT INTO laporan (user_id, judul, isi, lokasi, foto, status) VALUES (?, ?, ?, ?, ?, 'menunggu')");
            mysqli_stmt_bind_param($query, "issss", $user_id, $judul, $isi, $lokasi, $namaFotoBaru);
            mysqli_stmt_execute($query);
            if (mysqli_affected_rows($koneksi) > 0) {
                echo "<script>alert('Laporan berhasil dikirim'); window.location.href = 'dashboard_user.php';</script>";
            } else {
                echo "<script>alert('Laporan gagal dikirim');</script>";
            }
        }
    }

}

$activePage = 'buat';
$pageTitle  = 'Buat Laporan';
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
                <h2 class="text-2xl font-bold">Buat Laporan 📝</h2>
                <p class="text-slate-500 mt-1">Isi formulir berikut untuk mengirim laporan pengaduan</p>
            </header>

            <section class="p-6">
                <div class="card bg-white rounded-2xl shadow-sm p-8 max-w-3xl">

                    <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

                        <div>
                            <label class="block mb-2 text-sm font-semibold">Judul Laporan</label>
                            <input type="text" name="judul" placeholder="Masukkan judul laporan"
                                class="w-full border border-slate-200 rounded-xl px-5 py-3 outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold">Isi Laporan</label>
                            <textarea name="isi" rows="5" placeholder="Tuliskan detail laporan..."
                                class="w-full border border-slate-200 rounded-xl px-5 py-3 outline-none resize-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition"></textarea>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold">Lokasi Kejadian</label>
                            <input type="text" name="lokasi" placeholder="Masukkan lokasi kejadian"
                                class="w-full border border-slate-200 rounded-xl px-5 py-3 outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold">Upload Foto</label>
                            <input type="file" name="foto"
                                class="w-full border border-slate-200 rounded-xl px-5 py-3 bg-transparent">
                            <p class="text-slate-400 text-xs mt-1">Format: JPG, JPEG, PNG</p>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <a href="dashboard_user.php" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-semibold transition">Kembali</a>
                            <button type="submit" name="kirim" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-semibold transition shadow-lg hover:shadow-xl">
                                Kirim Laporan
                            </button>
                        </div>

                    </form>

                </div>
            </section>
        </main>
    </div>
</body>
</html>
