<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Fungsi untuk menghitung jumlah like pada suatu jurnal
function countLikes($conn, $journalId) {
    $sql = "SELECT COUNT(*) AS total_likes FROM likes WHERE journal_id='$journalId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_likes'];
}

$username = $_SESSION['user'];
$isCurrentUser = true;

// Jika parameter user disertakan di URL, tampilkan jurnal yang diunggah oleh pengguna tersebut
if (isset($_GET['user']) && $_GET['user'] !== $_SESSION['user']) {
    $username = $_GET['user'];
    $isCurrentUser = false;
}

$currentUserId = null;
$profileUserId = null;

// Ambil id pengguna saat ini
$sqlCurrentUser = "SELECT id FROM users WHERE username='$username'";
$resultCurrentUser = mysqli_query($conn, $sqlCurrentUser);
$rowCurrentUser = mysqli_fetch_assoc($resultCurrentUser);
$currentUserId = $rowCurrentUser['id'];

// Ambil id pengguna yang sedang dilihat
if (!$isCurrentUser) {
    $sqlProfileUser = "SELECT id FROM users WHERE username='$username'";
    $resultProfileUser = mysqli_query($conn, $sqlProfileUser);
    $rowProfileUser = mysqli_fetch_assoc($resultProfileUser);
    $profileUserId = $rowProfileUser['id'];
}


// Proses penggantian foto profil
if (isset($_FILES['profile_picture'])) {
    // Membuat direktori jika belum ada
    $target_dir = "profile_pictures/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = $_FILES['profile_picture']['name'];
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $file_type = $_FILES['profile_picture']['type'];
    move_uploaded_file($file_tmp, $target_dir . $file_name);
    $sqlUpdateProfilePicture = "UPDATE users SET profile_picture='$file_name' WHERE username='$username'";
    mysqli_query($conn, $sqlUpdateProfilePicture);
    header("Location: profile.php?user=$username");
    exit();
}

// Hapus semua like yang terkait dengan jurnal
if (isset($_POST['delete_journal'])) {
    $journalId = $_POST['journal_id'];

    // Hapus semua like yang terkait dengan jurnal
    $sqlDeleteLikes = "DELETE FROM likes WHERE journal_id='$journalId'";
    mysqli_query($conn, $sqlDeleteLikes);

    // Hapus jurnal setelah menghapus semua like
    $sqlDeleteJournal = "DELETE FROM journals WHERE id='$journalId'";
    mysqli_query($conn, $sqlDeleteJournal);

    // Redirect kembali ke halaman profile setelah menghapus
    header("Location: profile.php?user=$username");
    exit();
}

// Proses edit atau tambah biografi
if (isset($_POST['submit_bio'])) {
    $bio = $_POST['bio'];
    $sqlUpdateBio = "UPDATE users SET bio='$bio' WHERE username='$username'";
    mysqli_query($conn, $sqlUpdateBio);
    header("Location: profile.php?user=$username");
    exit();
}

$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Query untuk mengambil jurnal yang diunggah oleh pengguna
$sqlJournals = "SELECT * FROM journals WHERE author='$username'";
$resultJournals = mysqli_query($conn, $sqlJournals);

// Query untuk menghitung jumlah total like dari semua jurnal yang diunggah oleh pengguna
$sqlTotalLikes = "SELECT SUM(likes) AS total_likes FROM (SELECT COUNT(*) AS likes FROM likes INNER JOIN journals ON likes.journal_id = journals.id WHERE journals.author = '$username' GROUP BY journals.id) AS likes_count";
$resultTotalLikes = mysqli_query($conn, $sqlTotalLikes);
$totalLikesRow = mysqli_fetch_assoc($resultTotalLikes);
$totalLikes = $totalLikesRow['total_likes'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Protest+Guerrilla&display=swap');

        .containerprofile{
            padding: 0px;
            display: grid;
            grid-template-columns: 135px 135px ;
            grid-template-rows: 85px 85px;
            margin-left: 2%;
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
            height: 80px;
            width:500px;
            justify-content: center;
            line-height:0%;
            grid-column: 2/3;
            grid-row:1/2;
        }
        .foto2{
            height: 175px;
            width:135px;
            align-items: center;
            justify-content: center; 
            grid-column: 1/2;
            grid-row:1/4;
        }
        .info2{
            height: 175px;
            width:500px;
            justify-content: center;
            line-height:0%;
            grid-column: 2/3;
            grid-row:1/4;
        }
        .gantibio{
            height: 55px;
            width:1000px;
            grid-column: 2/3;
            grid-row:2/3;
        }
        .gantifoto{
            display: flex;
            align-items: center;
            height: 80px;
            width:550px;
            grid-column: 1/3;
            grid-row:3/4;
        }
        .siapa{
            display: flex;
            align-items: center;
            height: 80px;
            width:550px;
            grid-column: 1/3;
            grid-row:4/5;
        }
        .jurnal{
            padding: 30%;
            padding-top: 65%;
            display: flex;
            align-items: center;
            height: 220px;
            width:1150px;
            grid-column: 1/3;
            grid-row:5/6;
            background-image: url('index.png');
            border-radius: 5px 5px 5px 5px;
            box-shadow: rgb(0, 0, 0);
            border:5px outset #999;
    
        }
        .back{
            display: flex;
            align-items: center;
            height: 80px;
            width:550px;
            grid-column: 1/3;
            grid-row:6/7;
        }
        .hapus{
            display: flex;
            align-items: center;
            height: 80px;
            width:550px;
            grid-column: 3/4;
            grid-row:5/6;
        }
        .tombolhapus{
            background-color: red;
            border-radius: 10px 10px 10px 10px;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        .tombolhapus:hover{
            background-color: rgba(255, 9, 9, 0.9);
        }
    </style>
</head>
<body>
    <h1 style="font-family: 'Montserrat'; font-size: 50px; margin-top:5%; ">Profile</h1>
    <div class="containerprofile">
        <?php if ($isCurrentUser): ?>
            <div class="foto">
                <?php if(isset($user['profile_picture']) && !empty($user['profile_picture'])): ?>
                    <img src="profile_pictures/<?php echo $user['profile_picture']; ?>" alt="Profile Picture" style="width:130px; border-radius:10px;">
                <?php else: ?>
                    <img src="profile.png" alt="Profile Picture" style="width:130px; border-radius:10px;">
                <?php endif; ?>
            </div>
            <div class="info">
                <table style="margin-top: 5%;">
                    <tr style="line-height:5%;">
                        <td>
                            <p><strong>Username</strong><p>
                        </td>
                        <td>
                            <p>:</p>
                        </td>
                        <td>
                            <p> <?php echo $user['username']; ?></p>
                        </td>
                    </tr>
                    <tr style="line-height:100%;">
                        <td>
                            <p><strong>Total Likes</strong><p>
                        </td>
                        <td>
                            <p>:</p>
                        </td>
                        <td>
                            <p> <?php echo $totalLikes; ?></p>
                        </td>
                        <?php if (!$isCurrentUser): ?>
                        <?php if(isset($user['bio']) && !empty($user['bio'])): ?>
                            <p><strong>Bio:</strong> <?php echo $user['bio']; ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                    </tr>
                </table>
            </div>
            <div class="gantibio">
                <?php if ($isCurrentUser): ?>
                    <form action="profile.php?user=<?php echo $username; ?>" method="post">
                        <table style="margin-top: 0%;">
                            <tr >
                                <td>
                                    <p><strong>Edit Bio :</strong> </p>
                                 </td>
                                <td rowspan="2">
                                    <textarea name="bio" rows="2" cols="50"><?php echo isset($user['bio']) ? $user['bio'] : ''; ?></textarea>
                                </td>
                                <td>
                                    <button type="submit" name="submit_bio" style="width:100%;">Edit</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                <?php endif; ?>
            </div>
            <div class="gantifoto">
                <form action="profile.php?user=<?php echo $username; ?>" method="post" enctype="multipart/form-data" >
                    <table>
                        <tr>
                            <td><input type="file" id="file-input" class="file-input" name="profile_picture" accept="image/*"> </td>
                            <td><button type="submit" name="submit" class="edit-profile-picture-btn" style="width:100%">Edit PP</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        <?php else: ?>
            <div class="foto2">
                <?php if(isset($user['profile_picture']) && !empty($user['profile_picture'])): ?>
                    <img src="profile_pictures/<?php echo $user['profile_picture']; ?>" alt="Profile Picture" style="width:130px; border-radius:10px;">
                <?php else: ?>
                    <img src="profile.png" alt="Profile Picture" style="width:130px; border-radius:10px;">
                <?php endif; ?>
            </div>
            <div class="info2">
            <table style="margin-top: 5%;">
                    <tr style="line-height:5%;">
                        <td>
                            <p><strong>Username</strong><p>
                        </td>
                        <td>
                            <p>:</p>
                        </td>
                        <td>
                            <p> <?php echo $user['username']; ?></p>
                        </td>
                    </tr>
                    <tr style="line-height:100%;">
                        <td>
                            <p><strong>Total Likes</strong><p>
                        </td>
                        <td>
                            <p>:</p>
                        </td>
                        <td>
                            <p> <?php echo $totalLikes; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php if (!$isCurrentUser): ?>
                                <?php if(isset($user['bio']) && !empty($user['bio'])): ?>
                                    <p><strong>Bio:</strong> <?php echo $user['bio']; ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
        <div class="siapa">
        <p style="margin-top:5%; font-family: 'Montserrat'; font-size: 20px;"><strong>
            <?php 
            if ($isCurrentUser) {
                echo "Your Upload Journals";
            } else {
                echo $username . "'s Upload Journals";
            }
            ?>
        </strong></p>
        </div>
        <div class="journals">
            <ul>
                <?php while ($row = mysqli_fetch_assoc($resultJournals)): ?>
                    <div class="jurnal">
                        <li>
                            <strong>Title:</strong> <?php echo $row['title']; ?><br>
                            <strong>Content:</strong> <?php echo $row['content']; ?><br>
                            <strong>File:</strong> <a href="uploads/<?php echo $row['file']; ?>" target="_blank"><?php echo $row['original_name']; ?></a><br>
                            <strong>Likes:</strong> <?php echo countLikes($conn, $row['id']); ?>
                            <div class="hapus">
                                <?php if ($isCurrentUser): ?>
                                    <form action="profile.php?user=<?php echo $username; ?>" method="post">
                                        <input type="hidden" name="journal_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_journal" class="tombolhapus">Hapus</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </li>
                    </div>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="back">
            <a href="index.php">Back to Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <script>
        document.getElementById("file-input").onchange = function() {
            document.getElementById("edit-profile-btn").click();
        };
    </script>
</body>
</html>
