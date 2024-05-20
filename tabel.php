<?php
// Query untuk mengambil data dari tabel sensor_data
$stmt = $conn->query("SELECT * FROM sensor_data");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="modal-content">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Node</th>
            <th>Moisture</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row): ?>
        <tr>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['node']; ?></td>
            <td><?php echo $row['soil_moisture']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Tombol Close -->
<button class="close" onclick="closeModal()">Close</button>

<script>
    function closeModal() {
        var modal = document.querySelector('.modal');
        modal.style.display = "none";
    }
</script>
