<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'manajer') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_produk"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stok</title>
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

<h1>Data Stok</h1>

<table>

<tr>
<th>No</th>
<th>Produk</th>
<th>Stok</th>
</tr>

<?php
$no = 1;

while ($p = mysqli_fetch_assoc($data)) {
?>

<tr>

<td><?= $no++; ?></td>
<td><?= $p['nama_produk']; ?></td>
<td><?= $p['stok']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>