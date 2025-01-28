
<?php
include 'koneksi.php';

// Mendapatkan waktu saat ini
$current_time = date('Y-m-d H:i:s');

// Mengambil data yang diperbarui dalam 24 jam terakhir dari tabel informasi1
$queryInformasi = "SELECT * FROM informasi1 WHERE updated_at >= DATE_SUB('$current_time', INTERVAL 1 SECOND) ORDER BY updated_at DESC";
$resultInformasi = mysqli_query($conn, $queryInformasi);

// Mengambil data yang diperbarui dalam 24 jam terakhir dari tabel flayer1
$queryFlayer = "SELECT * FROM igambar1 WHERE updated_at >= DATE_SUB('$current_time', INTERVAL 1 SECOND) ORDER BY updated_at DESC";
$resultFlayer = mysqli_query($conn, $queryFlayer);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body>
    <h1>Halaman User</h1>
    <h2>Informasi Terbaru</h2>
    <?php while ($row = mysqli_fetch_assoc($resultInformasi)): ?>
        <p><?php echo htmlspecialchars($row['teks']); ?></p>
    <?php endwhile; ?>

    <a class="flex-shrink-0 w-40 bg-white shadow-md rounded-lg p-2 relative" href="#">
      <img src="<?php while ($row = mysqli_fetch_assoc($resultFlayer)): ?>upload/<?php echo ($row['gambar']); ?><?php endwhile; ?>" alt="Gambar" class="h-24 w-full rounded" width="150" height="150">
      <p class="text-gray-700 mt-2"><?php while ($row = mysqli_fetch_assoc($resultInformasi)): ?><?php echo htmlspecialchars($row['teks']); ?><?php endwhile; ?></p>
    </a>
</body>
</html>
