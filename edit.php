<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "belajar");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Ambil data produk untuk di-edit
    $sql = "SELECT * FROM produk WHERE id = ?";
    if ($stmt = $koneksi->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $produk = $result->fetch_assoc();
        } else {
            echo "Produk tidak ditemukan.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    // Update data produk
    $sql = "UPDATE produk SET nama = ?, harga = ? WHERE id = ?";
    if ($stmt = $koneksi->prepare($sql)) {
        $stmt->bind_param("sdi", $nama, $harga, $id);
        $stmt->execute();

        echo "Produk berhasil diperbarui.";
        header('Location: list-produk.php'); // Redirect ke halaman daftar produk setelah update
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
</head>

<body>
    <h1>Edit Produk</h1>
    <?php if (isset($produk)): ?>
        <form method="POST">
            <label>Nama Produk:</label><br>
            <input type="text" name="nama" value="<?php echo $produk['nama']; ?>"><br><br>
            <label>Harga:</label><br>
            <input type="number" name="harga" value="<?php echo $produk['harga']; ?>"><br><br>
            <input type="submit" value="Update Produk">
        </form>
    <?php endif; ?>
    <a href="list-produk.php">Kembali ke Daftar Produk</a>
</body>

</html>

<?php
$koneksi->close();
?>