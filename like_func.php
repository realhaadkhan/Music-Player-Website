<?php
require 'dbConnect.php';

$music_id = $_POST["music_id"];
$user_id = $_POST["user_id"];
$status = $_POST["status"];

$ratings = mysqli_query($con, "SELECT * FROM music_status WHERE music_id = $music_id AND user_id = $user_id");
if (mysqli_num_rows($ratings) > 0) {
    $ratings = mysqli_fetch_assoc($ratings);
    if ($ratings['status'] == $status) {
        mysqli_query($con, "DELETE FROM music_status WHERE music_id = $music_id AND user_id = $user_id");
        echo "delete" . $status;
    } else {
        mysqli_query($con, "UPDATE music_status SET status = '$status' WHERE music_id = $music_id AND user_id = $user_id");
        echo "changeto" . $status;
    }
} else {
    mysqli_query($con, "INSERT INTO music_status VALUES('', '$music_id', '$user_id' '$status')");
    echo "new" . $status;
}
?>