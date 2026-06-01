<?php

session_start();

require "../config/koneksi.php";

if (!isset($_SESSION["login_admin"])) {

    header("Location: ../auth/login.php");
    exit();

}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: tanggapan.php");
    exit();

}

$laporan_id = (int) $_POST["laporan_id"];
$respon     = trim($_POST["respon"]);

if (empty($respon)) {

    echo "<script>
            alert('Tanggapan tidak boleh kosong!');
            history.back();
          </script>";
    exit();

}

$cek = mysqli_prepare($koneksi, "SELECT id FROM tanggapan WHERE laporan_id = ?");
mysqli_stmt_bind_param($cek, "i", $laporan_id);
mysqli_stmt_execute($cek);
$cekResult = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($cekResult) > 0) {

    $existing = mysqli_fetch_assoc($cekResult);
    $query = mysqli_prepare(
        $koneksi,
        "UPDATE tanggapan SET respon = ?, created_at = NOW() WHERE laporan_id = ?"
    );
    mysqli_stmt_bind_param($query, "si", $respon, $laporan_id);

} else {

    $query = mysqli_prepare(
        $koneksi,
        "INSERT INTO tanggapan (laporan_id, respon) VALUES (?, ?)"
    );
    mysqli_stmt_bind_param($query, "is", $laporan_id, $respon);

}

mysqli_stmt_execute($query);

if (mysqli_stmt_affected_rows($query) > 0) {

    header("Location: tanggapan.php?berhasil=1");
    exit();

} else {

    echo "<script>
            alert('Gagal mengirim tanggapan, silakan coba lagi.');
            history.back();
          </script>";

}

?>
