<?php

include 'config/koneksi.php';

// Hapus user lama
mysqli_query($koneksi, "DELETE FROM tb_user");

// Password semua akun
$password = password_hash("12345", PASSWORD_DEFAULT);

// Buat akun
$sql = "INSERT INTO tb_user
(nama, username, password, role) VALUES
('Karyawan SIJUAL', 'karyawan', '$password', 'karyawan'),
('Pelanggan SIJUAL', 'pelanggan', '$password', 'pelanggan'),
('Manajer SIJUAL', 'manajer', '$password', 'manajer')";

if (mysqli_query($koneksi, $sql)) {
    echo "Akun berhasil dibuat.<br><br>";

    echo "Karyawan: karyawan / 12345<br>";
    echo "Pelanggan: pelanggan / 12345<br>";
    echo "Manajer: manajer / 12345<br>";
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}

?>