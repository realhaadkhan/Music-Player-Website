<?php
session_start();

include('dbConnect.php');
$msg = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];
    $rePassword = $_POST['rePassword'];
    $image = $_FILES['image']['name'];
    $imageSize = $_FILES['image']['size'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageFolder = 'userPFPs/'.$image;

    $select = mysqli_query($con, "SELECT * FROM `userdetails` WHERE email = '$userEmail' AND password = '$userPassword'");

    if (!empty($userName) && !empty($userEmail) && !empty($userPassword) && !is_numeric($userName)) { 
        if ($userPassword != $rePassword){
            $msg = "Password not match!";
        }
        elseif (mysqli_num_rows($select) > 0){
            $msg = "User already Exist!";
        }
        elseif ($imageSize > 2000000){
            $msg = "Image size is too large!";
        }
        else{
            $query = "INSERT INTO `userdetails` (username, email, password, pfp) VALUES ('$userName', '$userEmail', '$userPassword', '$image')";
            mysqli_query($con, $query);
            move_uploaded_file($imageTmpName, $imageFolder);
            header("Location: login.php");
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signUpLogin_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>MicroProject(SignUp)</title>
</head>

<body>
    <header>
        <div class="left_bx1">
            <div class="content">
                <form method="post" enctype="multipart/form-data">
                    <h3>Sign Up</h3>
                    <div class="card">
                        <label for="name">Name</label>
                        <input type="text" name="userName" placeholder="Enter your username..." required>
                    </div>
                    <div class="card">
                        <label for="email">Email</label>
                        <input type="email" name="userEmail" placeholder="Enter your email..." required>
                    </div>
                    <div class="card">
                        <label for="password">Password</label>
                        <input type="password" name="userPassword" placeholder="Enter your new password..." required>
                    </div>
                    <div class="card">
                        <label for="re-password">Confirm Password</label>
                        <input type="password" name="rePassword" placeholder="Enter your password again..." required>
                    </div>
                    <div class="card">
                        <label for="image">Choose your profile picture</label>
                        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png"required>
                    </div>
                    <input type="submit" value="SignUp" class="submit">
                    <div class="check">
                        <input type="checkbox" name="" id=""><span>Remember me</span>
                    </div>
                    <p>Already have an accout? <a href="login.php">Login</a></p>
                </form>
            </div>
        </div>
        <div class="right_bx1">
            <img src="app.png" alt="">
            <!-- <h3>Incorrect Password</h3> -->
            <?php
            echo ('<h3>' . $msg . '</h3>');
            ?>
        </div>
    </header>
</body>

</html>