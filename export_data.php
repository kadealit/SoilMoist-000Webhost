<?php
// Koneksi ke database
$servername = "localhost"; // Ganti dengan host database Anda
$username = "id21815823_dataalit"; // Ganti dengan username database Anda
$password = "Alit14012004."; // Ganti dengan password database Anda
$dbname = "id21815823_datatesting"; // Ganti dengan nama database Anda

// Buat koneksi baru
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel
$sql = "SELECT date, time, node, soil_moisture FROM sensor_data";
$result = $conn->query($sql);

// Buat file CSV dan tulis header
$filename = "sensor_data.csv";
$file = fopen($filename, "w");
$header = array("Date", "Time", "Node", "Soil Moisture");
fputcsv($file, $header);

// Tulis data ke dalam file CSV
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data = array($row['date'], $row['time'], $row['node'], $row['soil_moisture']);
        fputcsv($file, $data);
    }
}

// Tutup file
fclose($file);

// Set header untuk menawarkan unduhan file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

// Tampilkan isi file CSV
readfile($filename);

// Hapus file CSV setelah diunduh
unlink($filename);

// Tutup koneksi database
$conn->close();
?>
