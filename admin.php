<?php
// koneksi.php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'lpsi';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Membuat folder /upload jika belum ada
$uploadDir = __DIR__ . '/toksmu';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
?>

<!-- admin.php -->
<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['upload_teks'])) {
        // Ambil teks dari form
        $teks1 = mysqli_real_escape_string($conn, $_POST['teks1']);
        $teks2 = mysqli_real_escape_string($conn, $_POST['teks2']);
        $teks3 = mysqli_real_escape_string($conn, $_POST['teks3']);
        $teks4 = mysqli_real_escape_string($conn, $_POST['teks4']);
        $teks5 = mysqli_real_escape_string($conn, $_POST['teks5']);
        $teks6 = mysqli_real_escape_string($conn, $_POST['teks6']);

        // Cek apakah ada data yang sudah ada
        $queryCek = "SELECT * FROM informasi WHERE teks1 = '$teks1' OR teks2 = '$teks2' OR teks3 = '$teks3' OR teks4 = '$teks4' OR teks5 = '$teks5' OR teks6 = '$teks6'";
        $resultCek = mysqli_query($conn, $queryCek);

        if (mysqli_num_rows($resultCek) > 0) {
            // Jika ada, lakukan UPDATE
            $queryUpdate = "UPDATE informasi 
                            SET teks1 = '$teks1', teks2 = '$teks2', teks3 = '$teks3', teks4 = '$teks4', teks5 = '$teks5', teks6 = '$teks6'
                            WHERE teks1 = '$teks1' OR teks2 = '$teks2' OR teks3 = '$teks3' OR teks4 = '$teks4' OR teks5 = '$teks5' OR teks6 = '$teks6'";
            mysqli_query($conn, $queryUpdate);
            echo "Data berhasil diupdate.";
        } else {
            // Jika belum ada, lakukan INSERT
            $queryInsert = "INSERT INTO informasi (teks1, teks2, teks3, teks4, teks5, teks6)
                            VALUES ('$teks1', '$teks2', '$teks3', '$teks4', '$teks5', '$teks6')";
            mysqli_query($conn, $queryInsert);
            echo "Data berhasil disimpan.";
        }
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['upload_gambar']) && isset($_FILES['gambar1']) && isset($_FILES['gambar2']) && isset($_FILES['gambar3']) && isset($_FILES['gambar4']) && isset($_FILES['gambar5']) && isset($_FILES['gambar6'])) {
        
        // Ambil nama file gambar
        $gambarNames = [];
        $gambarFiles = [
            $_FILES['gambar1'], $_FILES['gambar2'], $_FILES['gambar3'], $_FILES['gambar4'], $_FILES['gambar5'], $_FILES['gambar6']
        ];

        foreach ($gambarFiles as $gambar) {
            $namaFile = $gambar['name'];
            $tmpFile = $gambar['tmp_name'];
            $path = 'toksmu/' . basename($namaFile);
            $ekstensiValid = ['jpg', 'png', 'jfif'];
            $ekstensi = pathinfo($namaFile, PATHINFO_EXTENSION);

            if (in_array(strtolower($ekstensi), $ekstensiValid)) {
                if (move_uploaded_file($tmpFile, $path)) {
                    $gambarNames[] = $namaFile;
                } else {
                    echo "Gagal mengunggah gambar.";
                }
            } else {
                echo "Ekstensi file tidak valid. Hanya JPG, PNG, atau JFIF yang diperbolehkan.";
            }
        }

        // Cek apakah gambar sudah ada di database
        $queryCekGambar = "SELECT * FROM gambar WHERE gambar1 = '{$gambarNames[0]}' OR gambar2 = '{$gambarNames[1]}' OR gambar3 = '{$gambarNames[2]}' OR gambar4 = '{$gambarNames[3]}' OR gambar5 = '{$gambarNames[4]}' OR gambar6 = '{$gambarNames[5]}'";
        $resultCekGambar = mysqli_query($conn, $queryCekGambar);

        if (mysqli_num_rows($resultCekGambar) > 0) {
            // Jika ada, lakukan UPDATE
            $queryUpdateGambar = "UPDATE gambar 
                                  SET gambar1 = '{$gambarNames[0]}', gambar2 = '{$gambarNames[1]}', gambar3 = '{$gambarNames[2]}', gambar4 = '{$gambarNames[3]}', gambar5 = '{$gambarNames[4]}', gambar6 = '{$gambarNames[5]}'
                                  WHERE gambar1 = '{$gambarNames[0]}' OR gambar2 = '{$gambarNames[1]}' OR gambar3 = '{$gambarNames[2]}' OR gambar4 = '{$gambarNames[3]}' OR gambar5 = '{$gambarNames[4]}' OR gambar6 = '{$gambarNames[5]}'";
            mysqli_query($conn, $queryUpdateGambar);
            echo "Gambar berhasil diupdate.";
        } else {
            // Jika belum ada, lakukan INSERT
            $queryInsertGambar = "INSERT INTO igambar1 (gambar1, gambar2, gambar3, gambar4, gambar5, gambar6)
                                  VALUES ('{$gambarNames[0]}', '{$gambarNames[1]}', '{$gambarNames[2]}', '{$gambarNames[3]}', '{$gambarNames[4]}', '{$gambarNames[5]}')";
            mysqli_query($conn, $queryInsertGambar);
            echo "Gambar berhasil disimpan.";
        }
    }
}

?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        textarea, input[type="file"] {
            scrollbar-width: none; /* Firefox */
        }
        textarea::-webkit-scrollbar, input[type="file"]::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6 mt-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-4xl font-bold mb-6 text-center text-blue-600">Admin Page</h1>
        
        <form method="POST" enctype="multipart/form-data" class="mb-6">
            <h2 class="text-3xl font-bold mb-4 text-gray-700">Upload Teks</h2>
            <div class="grid grid-cols-1 gap-4">
                <textarea name="teks1" placeholder="Masukkan teks 1..." class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                <textarea name="teks2" placeholder="Masukkan teks 2..." class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                <textarea name="teks3" placeholder="Masukkan teks 3..." class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                <textarea name="teks4" placeholder="Masukkan teks 4..." class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                <textarea name="teks5" placeholder="Masukkan teks 5..." class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                <textarea name="teks6" placeholder="Masukkan teks 6..." class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <button type="submit" name="upload_teks" class="mt-4 w-full bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg transition duration-300">Upload Teks</button>
        </form>
        
        <form method="POST" enctype="multipart/form-data" class="mb-6">
            <h2 class="text-3xl font-bold mb-4 text-gray-700">Upload Gambar</h2>
            <div class="grid grid-cols-1 gap-4">
                <input type="file" name="gambar1" accept="image/jpg, image/png, image/jfif" class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="file" name="gambar2" accept="image/jpg, image/png, image/jfif" class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="file" name="gambar3" accept="image/jpg, image/png, image/jfif" class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="file" name="gambar4" accept="image/jpg, image/png, image/jfif" class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="file" name="gambar5" accept="image/jpg, image/png, image/jfif" class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="file" name="gambar6" accept="image/jpg, image/png, image/jfif" class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" name="upload_gambar" class="mt-4 w-full bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg transition duration-300">Upload Gambar</button>
        </form>
    </div>
</body>
</html>