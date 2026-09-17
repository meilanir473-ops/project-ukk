<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'karyawan') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

if (isset($_POST['simpan'])) {

    $pelanggan = $_POST['id_pelanggan'];
    $produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    $p = mysqli_fetch_assoc(
        mysqli_query(
            $koneksi,
            "SELECT * FROM tb_produk
            WHERE id_produk='$produk'"
        )
    );

    $harga = $p['harga'];
    $stok = $p['stok'];
    $subtotal = $harga * $jumlah;

    if ($jumlah > 0 && $jumlah <= $stok) {

        mysqli_query($koneksi, "INSERT INTO tb_transaksi
        (id_pelanggan, tanggal_transaksi, total_harga)
        VALUES
        ('$pelanggan', CURDATE(), '$subtotal')");

        $id_transaksi = mysqli_insert_id($koneksi);

        mysqli_query($koneksi, "INSERT INTO tb_detail_transaksi
        (id_transaksi, id_produk, jumlah, harga, subtotal)
        VALUES
        ('$id_transaksi', '$produk', '$jumlah',
        '$harga', '$subtotal')");

        mysqli_query($koneksi, "UPDATE tb_produk
        SET stok = stok - $jumlah
        WHERE id_produk='$produk'");

        echo "Transaksi berhasil";
    } else {
        echo "Stok tidak cukup";
    }
}

$pelanggan = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_pelanggan"
);

$produk = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_produk WHERE stok > 0"
);
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
<a href="produk.php">Produk</a>
<a href="pelanggan.php">Pelanggan</a>
<a href="stok.php">Stok</a>
<a href="transaksi.php">Transaksi</a>
<a href="../logout.php">Logout</a>

</div>

<div class="main">

<h1>Transaksi Penjualan</h1>

<div class="card">

<form method="POST">

<label>Pelanggan</label>

<select name="id_pelanggan" required>

<?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>

<option value="<?= $p['id_pelanggan']; ?>">
<?= $p['nama_pelanggan']; ?>
</option>

<?php } ?>

</select>

<label>Produk</label>

<select name="id_produk" required>

<?php while ($p = mysqli_fetch_assoc($produk)) { ?>

<option value="<?= $p['id_produk']; ?>">
<?= $p['nama_produk']; ?>
- Rp <?= number_format($p['harga']); ?>
</option>

<?php } ?>

</select>

<label>Jumlah</label>

<input type="number" name="jumlah" min="1" required>

<button name="simpan">
Simpan Transaksi
</button>

</form>

</div>

</div>

</body>
</html>