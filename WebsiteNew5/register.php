<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Pastikan email memiliki domain unsika.ac.id
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@.*unsika\.ac\.id$/', $email)) {
        $error = "Please enter a valid email with unsika.ac.id domain.";
    } else {
        // Check if username or email already exists
        $check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $check_result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username or email already exists.";
        } else {
            // Encrypt password
            $encrypted_password = encryptPassword($password);

            // Insert user data into the database
            $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$encrypted_password', '$email')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['user'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}

// Function to encrypt password
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
    <title>Register</title>
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
    </a>
    <div class="container2">
        <h1 style="font-family: 'Montserrat'; font-size: 30px; margin-top:-10%; ">Register</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="register.php" method="post" style="margin-top:7%;">
            <input type="email" name="email" placeholder="Email (unsika.ac.id)" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit" style = "width: 91%;">Buat Akun</button>
        </form>
        <p style = "margin-top: 10%; margin-left : 18%; line-height: 3px;">Already have an account?<strong><a href="login.php" style="color:black; text-decoration: none;"> Login Here</a></strong></p>
    </div>
</body>
</html>
