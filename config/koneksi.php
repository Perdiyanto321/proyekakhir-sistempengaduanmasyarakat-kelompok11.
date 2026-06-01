<?php

$koneksi = mysqli_connect("Localhost", "root", "", "db_pengaduan");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
} 

?>