<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Periksa apakah email ada di database
    $sql_check_email = "SELECT * FROM users WHERE email='$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // Periksa apakah password baru dan konfirmasi password cocok
        if ($new_password === $confirm_password) {
            // Enkripsi password baru
            $encrypted_password = encryptPassword($new_password);

            // Update password di database
            $sql_update_password = "UPDATE users SET password='$encrypted_password' WHERE email='$email'";
            mysqli_query($conn, $sql_update_password);

            // Redirect ke halaman login
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Password baru dan konfirmasi password tidak cocok.";
        }
    } else {
        $error_message = "Email tidak ditemukan. Silakan periksa alamat email Anda.";
    }
}

// Fungsi untuk melakukan enkripsi password
function encryptPassword($password) {
    global $encryption_key;
    return openssl_encrypt($password, 'AES-128-ECB', $encryption_key);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,400;0,700;1,900&display=swap" rel="stylesheet">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container-fluid">
        <a class="navbar-brand fw-semibold text-dark" href="index.php" style="font-family: 'Protest Guerrilla', sans-serif; font-size: 30px;">
                <img src="logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                <i class="text-black"> Aksatal </i>
            </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="home.php">Home</a>
              </li>
      </nav>
      <br>
      <br>
      <br>
    <div class="container2">
        <h1 style="font-family: 'Montserrat'; font-size: 30px; margin-top:-8%;">Forget Password</h1>
        <?php if(isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="forgot_password.php" method="post" style="margin-top:7%;">
            <input type="email" name="email" placeholder="Masukkan alamat email Anda" required>
            <input type="password" name="new_password" placeholder="Masukkan password baru" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi password baru" required>
            <button type="submit" style = "width: 90%;">Ganti Password</button>
        </form>
        <p style = "margin-top: 10%; margin-left : 25%; line-height: 3px ;">Back to login? <strong><a href="login.php" style="color:black; text-decoration: none;"> Login Here</a></strong></p>
    </div>
</body>
</html>
