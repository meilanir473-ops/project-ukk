<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'manajer') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$data = mysqli_query($koneksi, "
SELECT
tb_transaksi.*,
tb_pelanggan.nama_pelanggan
FROM tb_transaksi
LEFT JOIN tb_pelanggan
ON tb_transaksi.id_pelanggan =
tb_pelanggan.id_pelanggan
ORDER BY id_transaksi DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="sidebar">

<h2>SIJUAL</h2>

<a href="dashboard.php">Dashboard</a>
<a href="stok.php">Stok</a>
<a href="transaksi.php">Transaksi</a>
<a href="laporan.php">Laporan</a>
<a href="../logout.php">Logout</a>

</div>

<div class="main">

<h1>Data Transaksi</h1>

<table>

<tr>
<th>No</th>
<th>Tanggal</th>
<th>Pelanggan</th>
<th>Total</th>
</tr>

<?php
$no = 1;

while ($t = mysqli_fetch_assoc($data)) {
?>

<tr>

<td><?= $no++; ?></td>
<td><?= $t['tanggal_transaksi']; ?></td>
<td><?= $t['nama_pelanggan'] ?? '-'; ?></td>
<td>
Rp <?= number_format($t['total_harga']); ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>