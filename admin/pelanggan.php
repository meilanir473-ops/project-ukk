<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'karyawan') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    mysqli_query($koneksi, "INSERT INTO tb_pelanggan
    (nama_pelanggan, alamat, no_hp)
    VALUES
    ('$nama', '$alamat', '$no_hp')");

    header("Location: pelanggan.php");
    exit;
}

if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    mysqli_query(
        $koneksi,
        "DELETE FROM tb_pelanggan
        WHERE id_pelanggan='$id'"
    );

    header("Location: pelanggan.php");
    exit;
}

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_pelanggan"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pelanggan</title>
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

<h1>Data Pelanggan</h1>

<div class="card">

<form method="POST">

<label>Nama Pelanggan</label>
<input type="text" name="nama_pelanggan" required>

<label>Alamat</label>
<textarea name="alamat"></textarea>

<label>No HP</label>
<input type="text" name="no_hp">

<button name="simpan">Simpan</button>

</form>

</div>

<table>

<tr>
<th>No</th>
<th>Nama</th>
<th>Alamat</th>
<th>No HP</th>
<th>Aksi</th>
</tr>

<?php
$no = 1;

while ($p = mysqli_fetch_assoc($data)) {
?>

<tr>

<td><?= $no++; ?></td>
<td><?= $p['nama_pelanggan']; ?></td>
<td><?= $p['alamat']; ?></td>
<td><?= $p['no_hp']; ?></td>

<td>
<a
class="btn btn-danger"
href="?hapus=<?= $p['id_pelanggan']; ?>"
onclick="return confirm('Hapus data?')">
Hapus
</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>