<?php
// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirim dari perangkat ESP8266 dan lakukan validasi
    $date = isset($_POST["Date"]) ? date("Y-m-d", strtotime($_POST["Date"])) : "";
    $time = isset($_POST["Time"]) ? $_POST["Time"] : "";
    $node = isset($_POST["Node"]) ? $_POST["Node"] : "";
    $soilMoisture = isset($_POST["SoilMoisture"]) ? floatval($_POST["SoilMoisture"]) : 0.0;

    // Pastikan waktu tidak kosong sebelum menjalankan query MySQL
    if (!empty($time)) {
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

        // Query untuk menyimpan data ke dalam tabel dengan parameterized query
        $sql = "INSERT INTO sensor_data (date, time, node, soil_moisture) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssd", $date, $time, $node, $soilMoisture);

        if ($stmt->execute()) {
            echo "Data berhasil disimpan.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Waktu tidak boleh kosong.";
    }
} else {
    // Jika metode yang digunakan bukan POST, kirimkan pesan error
    echo "Metode yang diterima bukan POST.";
}
?>
