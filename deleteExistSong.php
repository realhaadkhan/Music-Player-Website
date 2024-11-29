<?php
require 'dbConnect.php';
$music_id = $_POST['music_id'];
$result = mysqli_query($con, "SELECT * FROM musics_db WHERE id = $music_id");
if (mysqli_num_rows($result) == 1) {
    mysqli_query($con, "DELETE FROM musics_db WHERE id = $music_id");
}
$result1 = mysqli_query($con, "SELECT * FROM music_status WHERE music_id = $music_id");
if (mysqli_num_rows($result) != 0) {
    mysqli_query($con, "DELETE FROM music_status WHERE music_id = $music_id");
}
$file_path = 'authorPFPs/'.$music_id.'.jpg'; // specify the path of the file you want to delete
if (file_exists($file_path)) { // check if the file exists
    if (unlink($file_path)) { // delete the file
        echo 'File deleted successfully.';
    } else {
        echo 'Error deleting file.';
    }
} else {
    echo 'File does not exist.';
}
$file_path = 'audio/'.$music_id.'.mp3'; // specify the path of the file you want to delete
if (file_exists($file_path)) { // check if the file exists
    if (unlink($file_path)) { // delete the file
        echo 'File deleted successfully.';
    } else {
        echo 'Error deleting file.';
    }
} else {
    echo 'File does not exist.';
}
mysqli_close($con);
?>