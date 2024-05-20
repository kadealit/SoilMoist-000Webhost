<?php
// Informasi koneksi ke database
$servername = "localhost";
$username = "id21815823_dataalit"; // Ganti dengan username database Anda
$password = "Alit14012004."; // Ganti dengan password database Anda
$dbname = "id21815823_datatesting"; // Ganti dengan nama database Anda

try {
    // Membuat koneksi PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Atur mode error untuk menampilkan pesan error jika terjadi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Atur mode fetch ke associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Atur encoding karakter ke UTF-8
    $conn->exec("SET NAMES 'utf8'");
} catch(PDOException $e) {
    // Jika terjadi error saat koneksi, tampilkan pesan error
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
