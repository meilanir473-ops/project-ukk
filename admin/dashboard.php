<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'karyawan') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$produk = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM tb_produk")
);

$pelanggan = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM tb_pelanggan")
);

$transaksi = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM tb_transaksi")
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Karyawan</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="sidebar">
    <h2>SIJUAL</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="produk.php">Produk</a>
    <a href="pelanggan.php">Pelanggan</a>
    <a href="stok.php">Stok</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="main">

    <h1>Dashboard Karyawan</h1>

    <p>
        Selamat datang,
        <b><?= $_SESSION['nama']; ?></b>
    </p>

    <div class="cards">

        <div class="card">
            <h3>Produk</h3>
            <h2><?= $produk['jumlah']; ?></h2>
        </div>

        <div class="card">
            <h3>Pelanggan</h3>
            <h2><?= $pelanggan['jumlah']; ?></h2>
        </div>

        <div class="card">
            <h3>Transaksi</h3>
            <h2><?= $transaksi['jumlah']; ?></h2>
        </div>

    </div>

</div>

</body>
</html>