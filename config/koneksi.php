<?php

$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_sijual"
);

if (!$koneksi) {
    die("Koneksi database gagal");
}

?>