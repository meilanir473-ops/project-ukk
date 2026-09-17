<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'karyawan') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

/* TAMBAH */
if (isset($_POST['simpan'])) {

    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    mysqli_query($koneksi, "INSERT INTO tb_produk
    (nama_produk, harga, stok, deskripsi)
    VALUES
    ('$nama', '$harga', '$stok', '$deskripsi')");

    header("Location: produk.php");
    exit;
}

/* HAPUS */
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    mysqli_query(
        $koneksi,
        "DELETE FROM tb_produk WHERE id_produk='$id'"
    );

    header("Location: produk.php");
    exit;
}

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_produk ORDER BY id_produk DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produk</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/script.js"></script>
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

<h1>Data Produk</h1>

<div class="card">

<form method="POST">

    <label>Nama Produk</label>
    <input type="text" name="nama_produk" required>

    <label>Harga</label>
    <input type="number" name="harga" required>

    <label>Stok</label>
    <input type="number" name="stok" required>

    <label>Deskripsi</label>
    <textarea name="deskripsi"></textarea>

    <button name="simpan">Simpan</button>

</form>

</div>

<table>

<tr>
    <th>No</th>
    <th>Nama Produk</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Aksi</th>
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

<td>

<a
class="btn btn-danger"
onclick="return hapusData()"
href="?hapus=<?= $p['id_produk']; ?>">
Hapus
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>