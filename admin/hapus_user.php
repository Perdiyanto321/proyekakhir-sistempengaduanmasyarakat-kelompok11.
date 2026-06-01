<?php

session_start();

require "../config/koneksi.php";

if (!isset($_SESSION["login_admin"])) {

    header("Location: ../auth/login_admin.php");
    exit();

}

$id = $_GET["id"];

if (isset($_GET["id"])) {
    var_dump($_GET["id"]);
}

$query = mysqli_prepare(
    $koneksi,
    "DELETE FROM users WHERE id = ?"
);

mysqli_stmt_bind_param($query, "i", $id);

mysqli_stmt_execute($query);

if (mysqli_stmt_affected_rows($query) > 0) {
    echo "<script>
            alert('User berhasil dihapus!');
            document.location.href = 'dashboard_admin.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus User!');
            document.location.href = 'dashboard_admin.php';
          </script>";
}

?>