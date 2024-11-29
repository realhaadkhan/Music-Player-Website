<?php
include('dbConnect.php');
session_start();
$msg = false;
if (isset($_POST['userName'])) {
    $userName = $_POST['userName'];
    $userPassword = $_POST['userPassword'];

    $query = "SELECT * from userdetails WHERE username = '".$userName."' AND password = '".$userPassword."' limit 1";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        if($userPassword == $row['password']){
        header("Location: index.php");
        }
    } 
    else if($userName == 'admin' &&  $userPassword == 'admin123'){
        header("Location: admin_main.php");
    }
    else {
        $msg = "Incorrect Password";
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
    <title>MicroProject(Login)</title>
</head>

<body>
<header>
    <div class="left_bx1">
        <div class="content">
            <form method="post">
                <h3>Login</h3>
                <div class="card">
                    <label for="name">Name</label>
                    <input type="text" name="userName" placeholder="Enter your username..." required>
                </div>
                <div class="card">
                    <label for="password">Password</label>
                    <input type="password" name="userPassword" placeholder="Enter your password..." required>
                </div>
                <input type="submit" value="Login" class="submit">
                <div class="check">
                    <input type="checkbox" name="" id=""><span>Remember me</span>
                </div>
                <p>Don't have an account yet? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </div>
    <div class="right_bx1">
        <img src="app.png" alt="">
        <!-- <h3>Incorrect Password</h3> -->
        <?php
        echo ('<h3>' .$msg. '</h3>');
        ?>
    </div>
</header>
</body>

</html>