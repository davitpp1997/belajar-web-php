<?php
// Koneksi ke database (misalnya menggunakan MySQLi)
$koneksi = new mysqli("localhost", "root", "", "belajar");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data produk dari database
$sql = "SELECT * FROM produk";
$result = $koneksi->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Produk</title>
    <link rel="stylesheet" href="styles.css"> <!-- Jika ingin menambahkan CSS khusus -->
</head>

<body>
    <h1>Daftar Produk</h1>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data produk dalam tabel
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . number_format($row['harga'], 0, ',', '.') . "</td>";
                    echo "<td>
                            <a href='view.php?id=" . $row['id'] . "'>View</a> | 
                            <a href='edit.php?id=" . $row['id'] . "'>Edit</a> | 
                            <a href='hapus.php?id=" . $row['id'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus?\")'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data produk</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>

</html>

<?php
$koneksi->close();
?>