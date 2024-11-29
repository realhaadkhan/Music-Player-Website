<?php
require 'dbConnect.php';
$music_id = $_POST['music_id'];
$user_id = $_POST['user_id'];
$result = mysqli_query($con, "SELECT * FROM music_status WHERE music_id = $music_id AND user_id = $user_id");
if (mysqli_num_rows($result) == 1) {
    mysqli_query($con, "DELETE FROM music_status WHERE music_id = $music_id AND user_id = $user_id");
    $Cntresult = mysqli_query($con, "SELECT COUNT(*) as count FROM music_status WHERE music_id = $music_id");
    $row = mysqli_fetch_assoc($Cntresult);
    $count = $row['count'];
    mysqli_query($con, "UPDATE musics_db SET ratings = '$count' WHERE id = '$music_id'");
} else if (mysqli_num_rows($result) == 0) {
    mysqli_query($con, "INSERT INTO  music_status VALUES('', '$user_id', '$music_id')");
    $Cntresult = mysqli_query($con, "SELECT COUNT(*) as count FROM music_status WHERE music_id = $music_id");
    $row = mysqli_fetch_assoc($Cntresult);
    $count = $row['count'];
    mysqli_query($con, "UPDATE musics_db SET ratings = '$count' WHERE id = '$music_id'");
}
mysqli_close($con);
?>