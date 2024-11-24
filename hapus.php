<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "belajar");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus produk dari database
    $sql = "DELETE FROM produk WHERE id = ?";
    if ($stmt = $koneksi->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo "Produk berhasil dihapus.";
        header('Location: list-produk.php'); // Redirect ke halaman daftar produk setelah hapus
        exit;
    }
} else {
    echo "ID produk tidak disertakan.";
}
?>

<?php
$koneksi->close();
?>
