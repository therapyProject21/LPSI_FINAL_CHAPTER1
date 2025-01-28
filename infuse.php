<?php
include 'koneksi.php';

// Mendapatkan waktu saat ini
$current_time = date('Y-m-d H:i:s');

// Query untuk mengambil data yang diperbarui dalam 24 jam terakhir dari tabel informasi
$queryInformasi = "SELECT * FROM informasi WHERE updated_at >= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY updated_at DESC";
$resultInformasi = mysqli_query($conn, $queryInformasi);

// Query untuk mengambil data yang diperbarui dalam 24 jam terakhir dari tabel flayer
$queryFlayer = "SELECT * FROM gambar WHERE updated_at >= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY updated_at DESC";
$resultFlayer = mysqli_query($conn, $queryFlayer);

// Mengambil satu data dari setiap query
$rowInformasi = mysqli_fetch_assoc($resultInformasi);
$rowFlayer = mysqli_fetch_assoc($resultFlayer);

?>