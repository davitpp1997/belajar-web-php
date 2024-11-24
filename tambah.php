<?php
// Koneksi ke database
include 'koneksi.php';

// Proses penyimpanan data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    // Validasi input (pastikan tidak kosong)
    if (!empty($nama) && !empty($harga)) {
        // Menambahkan produk baru ke database
        $sql = "INSERT INTO produk (nama, harga) VALUES (?, ?)";
        if ($stmt = $koneksi->prepare($sql)) {
            $stmt->bind_param("sd", $nama, $harga); // "s" untuk string, "d" untuk double
            $stmt->execute();

            // Redirect setelah berhasil
            header('Location: list-produk.php'); // Redirect ke halaman daftar produk
            exit;
        } else {
            echo "Terjadi kesalahan saat menambahkan produk.";
        }
    } else {
        echo "Nama dan harga produk tidak boleh kosong.";
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
</head>

<body>
    <h1>Tambah Produk Baru</h1>
    <form method="POST">
        <label>Nama Produk:</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" required><br><br>

        <input type="submit" value="Tambah Produk">
    </form>
    <br>
    <a href="list-produk.php">Kembali ke Daftar Produk</a>
</body>

</html>