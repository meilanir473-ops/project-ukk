<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_produk WHERE stok > 0"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produk</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="sidebar">

<h2>SIJUAL</h2>

<a href="produk.php">Produk</a>
<a href="pembelian.php">Pembelian</a>
<a href="../logout.php">Logout</a>

</div>

<div class="main">

<h1>Daftar Produk</h1>

<table>

<tr>
<th>No</th>
<th>Produk</th>
<th>Harga</th>
<th>Stok</th>
</tr>

<?php
$no = 1;

while ($p = mysqli_fetch_assoc($data)) {
?>

<tr>

<td><?= $no++; ?></td>
<td><?= $p['nama_produk']; ?></td>
<td>Rp <?= number_format($p['harga']); ?></td>
<td><?= $p['stok']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>