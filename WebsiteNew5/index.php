<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: home.php");
    exit();
}
include 'config.php';


// Fungsi untuk menghitung jumlah like pada suatu jurnal
function countLikes($conn, $journalId) {
    $sql = "SELECT COUNT(*) AS total_likes FROM likes WHERE journal_id='$journalId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_likes'];
}

// Query untuk mengambil jurnal dari database
$sql = "SELECT * FROM journals";

// Jika ada parameter fakultas yang diberikan, saring berdasarkan fakultas
if (isset($_GET['faculty'])) {
    $faculty = $_GET['faculty'];
    // Jika hanya satu fakultas yang dipilih
    if (strpos($faculty, ',') === false) {
        $sql .= " WHERE FIND_IN_SET('$faculty', faculty)";
    } else {
        // Jika lebih dari satu fakultas yang dipilih
        $faculties = explode(',', $faculty);
        $facultyCondition = '';
        foreach ($faculties as $f) {
            $facultyCondition .= " OR FIND_IN_SET('$f', faculty)";
        }
        $facultyCondition = ltrim($facultyCondition, ' OR');
        $sql .= " WHERE $facultyCondition";
    }
    $facultyName = "Fakultas $faculty";
} else {
    $facultyName = "All Faculties";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Protest+Guerrilla&display=swap');
        .journal{
            margin : 2%;
            padding-left: 37%;
            padding-top:2%;
            height: 560px;
            width: max;
            background-image: url('Index.png');
            border-radius: 5px 5px 5px 5px;
            box-shadow: rgb(0, 0, 0);
            border:5px outset #999;
        
        }
        p{
            line-height: 3px ;       
         }
         .cariuser{
            padding-top: 10px;
            display: grid;
            grid-template-columns: 135px 135px ;
            grid-template-rows: 85px 85px;
            background-color: rgba(172, 172, 172, 0.2);
            border-radius: 10px 10px 10px 10px;
            box-shadow: rgb(0, 0, 0);
            border:8px outset #999;
            -webkit-box-shadow: 5px 5px 15px rgba(0,0,0,0.4);
            -moz-box-shadow: 5px 5px 15px rgba(0,0,0,0.4);
            align-items: center;
            height: 200px;
            width:max;
            margin : 2%;
         }

         .foto{
            height: 175px;
            width:135px;
            align-items: center;
            justify-content: center; 
            grid-column: 1/2;
            grid-row:1/3;
        }
        .info{
            margin-top: 60%;
            padding-top:70%;
            padding-left: 3%;
            height: 175px;
            width:500px;
            justify-content: center;
            line-height:0%;
            grid-column: 2/3;
            grid-row:1/3;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   
</head>
<body>
    <?php
    // Query untuk mencari user yang berhubungan dengan query
    if(isset($_GET['query']) && !empty($_GET['query'])) {
        $query = $_GET['query'];
        $userSql = "SELECT * FROM users WHERE username LIKE '%$query%' OR bio LIKE '%$query%'";
        $userResult = mysqli_query($conn, $userSql);
        $numUserRows = mysqli_num_rows($userResult);
    } else {
        $numUserRows = 0;
    }


    // Tambahkan pencarian berdasarkan judul atau penulis
    if(isset($_GET['query']) && !empty($_GET['query'])) {
        $query = $_GET['query'];
        if (strpos($sql, 'WHERE') !== false) {
            $sql .= " AND (title LIKE '%$query%' OR author LIKE '%$query%')";
        } else {
            $sql .= " WHERE (title LIKE '%$query%' OR author LIKE '%$query%')";
        }
    }

    $sql .= " ORDER BY upload_time DESC"; // Tambahkan ORDER BY untuk menyortir jurnal berdasarkan waktu unggah

    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);

    ?>

    <nav class="navbar bg-primary shadow-sm p-3 mb-5 rounded" display-1 id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand fw-semibold text-dark" href="index.php" style="font-family: 'Protest Guerrilla', sans-serif; font-size: 30px;">
                <img src="logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                <i class="text-light"> Aksatal </i>
            </a>
            
            <ul class="nav justify-content-end" style="margin-top: 1%">
                <form class="d-flex" action="index.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
                <li class="nav-item">
                    <a class="nav-link text-light fw-bold" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light fw-bold" href="upload.php">Upload</a>
                </li>
                <li class="nav-item dropdown text-light">
                    <a class="nav-link dropdown-toggle text-light fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo "Journal $facultyName"; ?></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="index.php?faculty=Ilmu Komputer">Ilmu Komputer</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Keguruan dan Ilmu Pendidikan">Keguruan dan Ilmu Pendidikan</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Hukum">Hukum</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Ekonomi dan Bisnis">Ekonomi dan Bisnis</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Pertanian">Pertanian</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Agama Islam">Agama Islam</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Teknik">Teknik</a></li>
                        <li><a class="dropdown-item" href="index.php?faculty=Ilmu Sosial dan Ilmu Politik">Ilmu Sosial dan Ilmu Politik</a></li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light fw-bold" href="logout.php">LogOut</a>
                </li>
                <li class="nav-item" style="margin-top: -1%">
                    <a class="nav-link text-secondary" href="profile.php"> <img src="profile.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top "> </a>
                </li>
            </ul>
        </div>
    </nav>

    <h1>Welcome to Journal & Makalah Portal</h1>
    <h2 style="font-family: 'Montserrat'; font-size: 20px; margin-left:2%; margin-top:2%; "><?php echo (isset($_GET['query']) && !empty($_GET['query'])) ? 'Search Results' : 'Recent Journals & Makalah'; ?></h2>

    <div class="journals">
        <?php
        if ($numUserRows > 0) {
            while ($userRow = mysqli_fetch_assoc($userResult)): ?>
                <div class="cariuser">
                    <div class="foto">
                        <?php if( $userRow['profile_picture'] && !empty($userRow['profile_picture']) ): ?>
                            <img src="profile_pictures/<?php echo $userRow['profile_picture']; ?>" alt="Profile Picture" width="130" style="margin-left:3%">
                        <?php else: ?>
                            <img src="profile.png" alt="Profile Picture" width="130">
                        <?php endif; ?>
                    </div>
                    <div class="bio">
                        <div class="info">
                            <table style="margin-top: 5%;">
                                <tr style="line-height:5%;">
                                    <td>
                                        <p><strong>Nama</strong><p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                        <p> <?php echo $userRow['username']; ?></p>
                                    </td>
                                </tr>
                                <tr style="line-height:5%;">
                                    <td>
                                        <p><strong>Profile</strong><p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                        <p><i> <a href="profile.php?user=<?= $userRow['username']; ?>&show_all=true"><?= $userRow['username']; ?></a></i></p>
                                    </td>
                                </tr>
                                <tr style="line-height:100%;">
                                    <td>
                                        <p><strong>Bio</strong><p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                        <p><?php echo $userRow['bio']; ?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        }

        if ($numRows > 0) {
            while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="journal">
                    <p><strong>Title:</strong> <?= $row['title']; ?></p>
                    <p><strong>Author:</strong> <a href="profile.php?user=<?= $row['author']; ?>&show_all=true"><?= $row['author']; ?></a></p>
                    <?php if ($row['file']): ?>
                        <?php $fileExt = pathinfo($row['file'], PATHINFO_EXTENSION); ?>
                        <?php if (in_array($fileExt, array('jpg', 'jpeg', 'png', 'gif'))): ?>
                            <img src="uploads/<?= $row['file']; ?>" alt="<?= $row['title']; ?>" class="journal-image">
                        <?php elseif ($fileExt === 'pdf'): ?>
                            <iframe src="pdf-viewer.html?file=uploads/<?= $row['file']; ?>" width="100%" height="400px" style="margin-left:-30%;"></iframe>
                        <?php endif; ?>
                        <p style="margin-top:2%;"><strong>Content:</strong><?= $row['content']; ?></p>
                        <div class="button-group">
                            <a href="uploads/<?= $row['file']; ?>" target="_blank" class="btn btn-primary">View</a>
                            <a href="uploads/<?= $row['file']; ?>" download class="btn btn-secondary">Download</a>
                            <form action="like.php" method="post" style="display: inline-block;">
                                <input type="hidden" name="journal_id" value="<?= $row['id']; ?>">
                                <?php
                                    $journalId = $row['id'];
                                    $userId = $_SESSION['user_id']; // Pastikan 'user_id' adalah kunci yang benar
                                    $likeSql = "SELECT * FROM likes WHERE journal_id='$journalId' AND user_id='$userId'";
                                    $likeResult = mysqli_query($conn, $likeSql);
                                    $isLiked = mysqli_num_rows($likeResult) > 0;
                                ?>
                                <button type="submit" name="<?= $isLiked ? 'unlike' : 'like'; ?>" class="btn btn-<?php echo $isLiked ? 'danger' : 'success'; ?>" style="width: 70px;"><?php echo $isLiked ? 'Unlike' : 'Like'; ?></button>
                                <span><?= countLikes($conn, $row['id']); ?></span>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile;
                       
        } else {
            echo "<p> <br><br><br><strong>No journals available for the selected faculty.</strong></p>";
        }
        ?>
    </div>


    <script src="algoritma.js"></script>
</body>
</html>
