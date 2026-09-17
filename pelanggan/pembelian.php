<?php
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$id_user = $_SESSION['id_user'];

$cek = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_pelanggan
    WHERE id_user='$id_user'"
);

$pelanggan = mysqli_fetch_assoc($cek);

if (!$pelanggan) {

    mysqli_query($koneksi, "INSERT INTO tb_pelanggan
    (id_user, nama_pelanggan)
    VALUES
    ('$id_user', '{$_SESSION['nama']}')");

    $id_pelanggan = mysqli_insert_id($koneksi);

} else {

    $id_pelanggan = $pelanggan['id_pelanggan'];
}

if (isset($_POST['beli'])) {

    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    $produk = mysqli_fetch_assoc(
        mysqli_query(
            $koneksi,
            "SELECT * FROM tb_produk
            WHERE id_produk='$id_produk'"
        )
    );

    if ($jumlah <= $produk['stok']) {

        $subtotal = $produk['harga'] * $jumlah;

        mysqli_query($koneksi, "INSERT INTO tb_transaksi
        (id_pelanggan, tanggal_transaksi, total_harga)
        VALUES
        ('$id_pelanggan', CURDATE(), '$subtotal')");

        $id_transaksi = mysqli_insert_id($koneksi);

        mysqli_query($koneksi, "INSERT INTO tb_detail_transaksi
        (id_transaksi, id_produk, jumlah, harga, subtotal)
        VALUES
        ('$id_transaksi', '$id_produk', '$jumlah',
        '{$produk['harga']}', '$subtotal')");

        mysqli_query($koneksi, "UPDATE tb_produk
        SET stok = stok - $jumlah
        WHERE id_produk='$id_produk'");

        echo "Pembelian berhasil";

    } else {

        echo "Stok tidak cukup";
    }
}

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_produk WHERE stok > 0"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pembelian</title>
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

<h1>Pembelian Produk</h1>

<div class="card">

<form method="POST">

<label>Produk</label>

<select name="id_produk" required>

<?php while ($p = mysqli_fetch_assoc($data)) { ?>

<option value="<?= $p['id_produk']; ?>">

<?= $p['nama_produk']; ?>

- Rp <?= number_format($p['harga']); ?>

</option>

<?php } ?>

</select>

<label>Jumlah</label>

<input type="number" name="jumlah" min="1" required>

<button name="beli">Beli</button>

</form>

</div>

</div>

</body>
</html>