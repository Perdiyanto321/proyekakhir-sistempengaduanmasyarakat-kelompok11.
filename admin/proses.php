<?php

session_start();

require "../config/koneksi.php";

if (!isset($_SESSION["login_admin"])) {

    header("Location: ../auth/login.php");
    exit();

}

$id = $_GET["id"];

$query = mysqli_prepare($koneksi,
"UPDATE laporan 
SET status = 'proses'
WHERE id = ?");

mysqli_stmt_bind_param($query, "i", $id);

mysqli_stmt_execute($query);

if (mysqli_stmt_affected_rows($query) > 0) {
    echo "<script>
            alert('Data berhasil di update');
            document.location.href = 'dashboard_admin.php';
          </script>";
} else {
    echo "<script>
            alert('Data gagal di update');
            document.location.href = 'dashboard_admin.php';
          </script>";
}

?>