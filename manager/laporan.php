<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'manajer') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$data = mysqli_query(
    $koneksi,
    "SELECT
    tanggal_transaksi,
    COUNT(*) AS jumlah,
    SUM(total_harga) AS total
    FROM tb_transaksi
    GROUP BY tanggal_transaksi
    ORDER BY tanggal_transaksi DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
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

<h1>Laporan Penjualan</h1>

<table>

<tr>
<th>No</th>
<th>Tanggal</th>
<th>Jumlah Transaksi</th>
<th>Total Penjualan</th>
</tr>

<?php
$no = 1;

while ($l = mysqli_fetch_assoc($data)) {
?>

<tr>

<td><?= $no++; ?></td>

<td><?= $l['tanggal_transaksi']; ?></td>

<td><?= $l['jumlah']; ?></td>

<td>
Rp <?= number_format($l['total']); ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>