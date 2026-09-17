<?php

session_start();

include "config/koneksi.php";

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM tb_user
        WHERE username='$username'"
    );

    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'karyawan') {

            header("Location: admin/dashboard.php");

        } elseif ($user['role'] == 'pelanggan') {

            header("Location: pelanggan/produk.php");

        } elseif ($user['role'] == 'manajer') {

            header("Location: manager/dashboard.php");
        }

        exit;

    } else {

        $error = "Username atau password salah";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Login SIJUAL</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="card login">

<h2>LOGIN SIJUAL</h2>

<?php if ($error) { ?>

<p><?= $error; ?></p>

<?php } ?>

<form method="POST">

<label>Username</label>

<input
type="text"
name="username"
required>

<label>Password</label>

<input
type="password"
name="password"
required>

<button name="login">
Login
</button>

</form>

</div>

</body>

</html>