<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'karyawan') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

if (isset($_POST['update'])) {

    $id = $_POST['id_produk'];
    $stok = $_POST['stok'];

    mysqli_query(
        $koneksi,
        "UPDATE tb_produk
        SET stok='$stok'
        WHERE id_produk='$id'"
    );
}

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
    <a href="produk.php">Produk</a>
    <a href="pelanggan.php">Pelanggan</a>
    <a href="stok.php">Stok</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="main">

<h1>Kelola Stok</h1>

<table>

<tr>
<th>No</th>
<th>Produk</th>
<th>Stok</th>
<th>Update</th>
</tr>

<?php
$no = 1;

while ($p = mysqli_fetch_assoc($data)) {
?>

<tr>

<td><?= $no++; ?></td>

<td><?= $p['nama_produk']; ?></td>

<td><?= $p['stok']; ?></td>

<td>

<form method="POST">

<input
type="hidden"
name="id_produk"
value="<?= $p['id_produk']; ?>">

<input
type="number"
name="stok"
value="<?= $p['stok']; ?>"
required>

<button name="update">Update</button>

</form>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>