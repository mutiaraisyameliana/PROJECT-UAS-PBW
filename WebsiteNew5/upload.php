<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_SESSION['user'];
    $content = $_POST['content'];

    $faculty = isset($_POST['faculty']) ? implode(", ", $_POST['faculty']) : ''; // Mengambil nilai fakultas yang dipilih

    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
            $fileDestination = 'uploads/' . $fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);

            // Simpan nama asli file ke dalam kolom original_name
            $originalName = $_FILES['file']['name'];

            $sql = "INSERT INTO journals (title, author, content, file, original_name, faculty) VALUES ('$title', '$author', '$content', '$fileNameNew', '$originalName', '$faculty')";
            mysqli_query($conn, $sql);

            header("Location: index.php");
            exit();
        } else {
            $error = "Error uploading file!";
        }
    } else {
        $error = "Only PDF files are allowed!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Journal</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,400;0,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <br>
    <br>
    <br>
    <br>
    <br>
      <div class="container2">
          <h1 style="font-family: 'Montserrat'; font-size: 30px; margin-top:-10%; ">Upload</h1>
          <br>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="content" placeholder="Content" required></textarea>
            <label style="margin-left: 5%;">Fakultas </label>
            <select name="faculty[]" id="fakultas">
                <option name="faculty[]" value="Keguruan dan Ilmu Pendidikan"> Keguruan dan Ilmu Pendidikan</option>
                <option name="faculty[]" value="Ilmu Komputer"> Ilmu Komputer</option>
                <option name="faculty[]" value="Hukum"> Hukum</option>
                <option name="faculty[]" value="Ekonomi dan Bisnis"> Ekonomi dan Bisnis</option>
                <option name="faculty[]" value="Pertanian"> Pertanian</option>
                <option name="faculty[]" value="Agama Islam"> Agama Islam</option>
                <option name="faculty[]" value="Teknik"> Teknik</option>
                <option name="faculty[]" value="Ilmu Sosial dan Ilmu Politik"> Ilmu Sosial dan Ilmu Politik</option>
            </select>
            <br>
            <br>
            <input type="file" name="file" accept=".pdf" required>
            <button type="submit">Upload</button>
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
