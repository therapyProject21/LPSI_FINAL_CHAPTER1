<?php
// Konfigurasi koneksi database
$host = 'localhost';      // Alamat server database (biasanya localhost)
$dbname = 'lpsi';         // Nama database yang digunakan
$username = 'root';       // Username untuk koneksi database
$password = '';           // Password untuk koneksi database

// Membuat koneksi menggunakan mysqli
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    // Jika koneksi berhasil
    // echo "Koneksi berhasil ke database: $dbname"; // Bisa diaktifkan jika perlu
}
?>
