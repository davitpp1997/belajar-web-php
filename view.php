<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "belajar");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM produk WHERE id = ?";

    if ($stmt = $koneksi->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $produk = $result->fetch_assoc();
        } else {
            echo "Produk tidak ditemukan";
        }
    }
} else {
    echo "ID produk tidak disertakan.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Produk</title>
</head>

<body>
    <h1>Detail Produk</h1>
    <?php if (isset($produk)): ?>
        <p>ID Produk: <?php echo $produk['id']; ?></p>
        <p>Nama Produk: <?php echo $produk['nama']; ?></p>
        <p>Harga: <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
    <?php endif; ?>
    <a href="list-produk.php">Kembali ke Daftar Produk</a>
</body>

</html>

<?php
$koneksi->close();
?>