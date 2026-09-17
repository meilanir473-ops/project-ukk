<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'manajer') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$data = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT
        COUNT(*) AS jumlah,
        SUM(total_harga) AS total
        FROM tb_transaksi"
    )
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Manager</title>
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

<h1>Dashboard Manager</h1>

<div class="cards">

<div class="card">
<h3>Total Transaksi</h3>
<h2><?= $data['jumlah']; ?></h2>
</div>

<div class="card">
<h3>Total Penjualan</h3>
<h2>
Rp <?= number_format($data['total'] ?? 0); ?>
</h2>
</div>

</div>

</div>

</body>
</html>