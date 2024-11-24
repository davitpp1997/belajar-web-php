<?php
// Menyertakan file untuk koneksi database
include "koneksi.php";

function listProduk($koneksi)
{
    $sql = "SELECT nama,harga FROM produk";
    $result = $koneksi->query($sql);

    $produk = array();
    while ($row = $result->fetch_assoc()) {
        $barang = array(
            "nama_barang" => $row['nama'],
            "harga_barang" => "Rp " . $row['harga'] . ",00",
        );
        $produk[] = $barang;
    }

    return $produk;
}

$dataProduk = listProduk($koneksi);
foreach ($dataProduk as $value) {
    echo $value['nama_barang'] . "<br>";
}
