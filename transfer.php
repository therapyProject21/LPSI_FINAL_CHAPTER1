<?php
// Konfigurasi koneksi database
$host = 'localhost';      // Alamat server database (biasanya localhost)
$dbname = 'lpsi'; // Nama database yang digunakan
$username = 'root';   // Username untuk koneksi database
$password = '';   // Password untuk koneksi database

try {
    // Membuat koneksi menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Mengatur error mode PDO ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Menangkap error jika terjadi masalah saat koneksi
    echo "Koneksi gagal: " . $e->getMessage();
    exit;
}
?>
