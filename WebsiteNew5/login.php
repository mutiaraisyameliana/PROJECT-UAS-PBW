<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Periksa apakah input adalah email atau username
    $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    // Query untuk mencari pengguna berdasarkan email atau username
    $sql = "SELECT * FROM users WHERE $field = '$login'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Decrypt password yang diambil dari database
        $original_password = decryptPassword($user['password']);

        // Verifikasi password
        if ($password === $original_password) {

            // Simpan user_id ke dalam sesi
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "User not found. Please check your email or username.";
    }
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
    <title>Login</title>
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
          <h1 style="font-family: 'Montserrat'; font-size: 30px; margin-top:-10%; ">Login</h1>
          <br>
          <?php if (isset($error)): ?>
              <div class="error"><?php echo $error; ?></div>
          <?php endif; ?>
          <form action="login.php" method="post">
              <input type="text" name="login" placeholder="Email or Username" required style="wight:100em">
              <input type="password" name="password" placeholder="Password" required>
              <button type="submit" style = "width: 90%;">Login</button>
          </form>
          <p style = "margin-top: 10%; margin-left : 17%; line-height: 3px ;">Forgot your password? <strong><a href="forgot_password.php" style="color:black; text-decoration: none;">Reset here</a></strong></p>
          <p style = "margin-left : 17%; line-height: 3px ;">Don't have an account? <strong><a href="register.php" style="color:black; text-decoration: none;">Register here</a></strong></p>
      </div>
</body>
</html>
