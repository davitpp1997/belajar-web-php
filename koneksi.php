<?php

// Konfigurasi koneksi database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'indoweb';

// Membuat koneksi ke MySQL
$koneksi = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
