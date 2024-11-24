<?php

// Menyertakan file untuk koneksi database
include 'koneksi.php';

// Mengambil request method (GET, POST, PUT, DELETE)
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Fungsi untuk membaca data produk
function getProduk($koneksi)
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

// Fungsi untuk menambahkan produk baru
function createProduk($koneksi, $nama, $harga)
{
    $sql = "INSERT INTO produk (nama, harga) VALUES ('$nama', '$harga')";
    return $koneksi->query($sql);
}

// Fungsi untuk mengupdate produk
function updateProduk($koneksi, $id, $nama, $harga)
{
    $sql = "UPDATE produk SET nama='$nama', harga='$harga' WHERE id=$id";
    return $koneksi->query($sql);
}

function updateHarga($koneksi, $id, $harga)
{
    $sql = "UPDATE produk SET harga='$harga' WHERE id=$id";
    return $koneksi->query($sql);
}

// Fungsi untuk menghapus produk
function deleteProduk($koneksi, $id)
{
    $sql = "DELETE FROM produk WHERE id=$id";
    return $koneksi->query($sql);
}

// Menentukan aksi berdasarkan request method
switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            echo $id;
            break;
        }
        // Mendapatkan data produk
        $produk = getProduk($koneksi);
        echo json_encode($produk);
        break;

    case 'POST':
        // Menambahkan produk baru
        $data = json_decode(file_get_contents("php://input"));
        $nama = $data->nama_barang;
        $harga = $data->harga_barang;

        if (empty($nama)) {
            echo "nama tidak boleh kosong";
            break;
        }

        if (createProduk($koneksi, $nama, $harga)) {
            echo json_encode(["message" => "Produk berhasil ditambahkan"]);
        } else {
            echo json_encode(["message" => "Gagal menambahkan produk"]);
        }
        break;

    case 'PUT':
        // Mengupdate produk
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;
        $nama = $data->nama;
        $harga = $data->harga;

        if (updateProduk($koneksi, $id, $nama, $harga)) {
            echo json_encode(["message" => "Produk berhasil diupdate"]);
        } else {
            echo json_encode(["message" => "Gagal mengupdate produk"]);
        }
        break;

    case 'DELETE':
        // Menghapus produk
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;

        if (deleteProduk($koneksi, $id)) {
            echo json_encode(["message" => "Produk berhasil dihapus"]);
        } else {
            echo json_encode(["message" => "Gagal menghapus produk"]);
        }
        break;

    case 'PATCH':
        // Menghapus produk
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->id;
        $harga = $data->harga;

        if (updateHarga($koneksi, $id, $harga)) {
            echo json_encode(["message" => "Produk berhasil diupdate"]);
        } else {
            echo json_encode(["message" => "Gagal mengupdate produk"]);
        }
        break;

    default:
        echo json_encode(["message" => "Request method tidak valid"]);
        break;
}
