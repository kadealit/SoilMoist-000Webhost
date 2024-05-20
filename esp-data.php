<?php
// Koneksi ke database
include 'koneksi.php';

try {
    // Query untuk mengambil baris terakhir dari tabel
    $stmt = $conn->query("SELECT * FROM sensor_data ORDER BY id DESC LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $node_status = $row['status']; // Mengambil status NodeMCU dari baris terakhir

    // Query untuk mengambil nilai terkecil dan terbesar dari kolom 'soil_moisture'
    $stmt_min = $conn->query("SELECT MIN(soil_moisture) AS min_moisture FROM sensor_data");
    $stmt_max = $conn->query("SELECT MAX(soil_moisture) AS max_moisture FROM sensor_data");

    // Ambil nilai terkecil
    $min_row = $stmt_min->fetch(PDO::FETCH_ASSOC);
    $min_moisture = $min_row['min_moisture'];

    // Ambil nilai terbesar
    $max_row = $stmt_max->fetch(PDO::FETCH_ASSOC);
    $max_moisture = $max_row['max_moisture'];
} catch(PDOException $e) {
    // Tangani kesalahan jika terjadi
    echo "Error: " . $e->getMessage();
}

//Skrip untuk mengekspor data ke file CSV
if(isset($_POST['export_csv'])) {
    // Koneksi ke database
    include 'koneksi.php';

    try {
        // Query untuk mengambil semua data dari tabel
        $stmt_export = $conn->query("SELECT * FROM sensor_data");
        $rows = $stmt_export->fetchAll(PDO::FETCH_ASSOC);

        // Header untuk file CSV
        $csv_header = "Date,Time,Node,Moisture\n";

        // Isi data ke dalam file CSV
        $csv_data = '';
        foreach($rows as $row) {
            $csv_data .= $row['date'] . ',' . $row['time'] . ',' . $row['node'] . ',' . $row['soil_moisture'] . "\n";
        }

        

        // Nama file CSV
        $filename = 'sensor_data_' . date('Y-m-d') . '.csv';

        // Set header untuk file CSV
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$filename");

        // Output data ke file CSV
        echo $csv_header . $csv_data;
        exit();
    } catch(PDOException $e) {
        // Tangani kesalahan jika terjadi
        echo "Error: " . $e->getMessage();
    }
}


?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="styles/css1.css">
    <link rel="stylesheet" href="styles/modal.css">
</head>
<body>
    <div class="bg"></div>
    <div class="container">
        <div class="header">
            <button id="btnOpenModal">Lihat tabel</button>
            <button id="btnExportCSV">Export to CSV</button>
        </div>
        <div class="body">
            <h1 class="city">
                <img src="asset/icon.png" style="width: 100px; height: auto;">
                
            </h1>
            <div class="datetime"></div>
            <div class="forecast"></div>
            <div class="icon"></div>
            <p class="temperature"></p>
            <div class="minmax">
                <p>Terkecil : <?php echo $min_moisture; ?></p>
                <p>Terbesar : <?php echo $max_moisture; ?></p>
            </div>
            <div class="nodestatus">
            <p>Status NodeMCU: <?php echo $node_status; ?></p>
            </div>
        <div class="info">
            <div class="card">
                <i class="fa-solid fa-calendar-days"></i>
                <div>
                    <p>Date</p>
                    <p class="realfeel"><?php echo $row['date']; ?></p>
                </div>
            </div>
            <div class="card">
                <i class="fa-regular fa-clock"></i>
                <div>
                    <p>Time</p>
                    <p class="humidity"><?php echo $row['time']; ?></p>
                </div>
            </div>
            <div class="card">
                <i class="fa-solid fa-microchip"></i>
                <div>
                    <p>Node</p>
                    <p class="wind"><?php echo $row['node']; ?></p>
                </div>
            </div>
            <div class="card">
                <i class="fa-solid fa-droplet"></i>
                <div>
                    <p>Moisture</p>
                    <p class="pressure"><?php echo $row['soil_moisture']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a692e1c39f.js" crossorigin="anonymous"></script>
    <!-- Modal -->
    <div id="myModal" class="modal" ;">
        <div class="content-table">     
            <!-- Include tabel.php untuk menampilkan tabel -->
            <?php include 'tabel.php'; ?>
        </div>
    </div>
    <script>
        var btnOpenModal = document.getElementById("btnOpenModal");
        var modal = document.getElementById("myModal");
        var spanClose = document.getElementsByClassName("close")[0];

        btnOpenModal.onclick = function() {
            modal.style.display = "block";
        }

        spanClose.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

<script>
    var btnExportCSV = document.getElementById("btnExportCSV");

    btnExportCSV.onclick = function() {
        // Membuat formulir tersembunyi
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo $_SERVER['PHP_SELF']; ?>';

        // Menambahkan input tersembunyi untuk memicu proses ekspor CSV
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'export_csv';
        input.value = '1';
        form.appendChild(input);

        // Menambahkan formulir ke dalam halaman
        document.body.appendChild(form);

        // Mengirim formulir
        form.submit();

        // Menghapus formulir setelah pengiriman
        document.body.removeChild(form);
    }
</script>

</body>
</html>


