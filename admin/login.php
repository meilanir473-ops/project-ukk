<?php

session_start();
include 'config/koneksi.php';

if (isset($_SESSION['id_user'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string(
        $koneksi,
        $_POST['username']
    );

    $password = $_POST['password'];

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM tb_user
         WHERE username='$username'"
    );

    if (mysqli_num_rows($query) == 1) {

        $user = mysqli_fetch_assoc($query);

        // Cek password
        if (password_verify($password, $user['password'])) {

            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit;

        } else {

            $error = "Password salah!";

        }

    } else {

        $error = "Username tidak ditemukan!";

    }
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Login SIJUAL</title>

</head>

<body>

<h2>LOGIN SIJUAL</h2>

<?php if ($error != "") { ?>

    <p style="color:red;">
        <?= $error; ?>
    </p>

<?php } ?>

<form method="POST">

    <label>Username</label>
    <br>

    <input
        type="text"
        name="username"
        placeholder="Masukkan username"
        required
    >

    <br><br>

    <label>Password</label>
    <br>

    <input
        type="password"
        name="password"
        placeholder="Masukkan password"
        required
    >

    <br><br>

    <button type="submit" name="login">
        Login
    </button>

</form>

</body>
</html>