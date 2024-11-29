<?php
require 'dbConnect.php';
$music_id = $_POST['music_id'];
// $imageName = $_POST['imageName'];
// $poster = $_POST['imagee'];
$songName = $_POST['songName'];
$songArtist = $_POST['artistName'];
$duration = $_POST['duration'];
$ratings = $_POST['ratings'];

$newImageName = $music_id.'.jpg';
$newAudioName = $music_id.'.mp3';

$destImageFolder = 'authorPFPs/';
$destAudioFolder = 'audio/';

$result = mysqli_query($con, "SELECT * FROM musics_db WHERE id = $music_id");
if (mysqli_num_rows($result) == 0) {
    move_uploaded_file($_FILES['imagee']['tmp_name'], $destImageFolder . $newImageName) && move_uploaded_file($_FILES['audio']['tmp_name'], $destAudioFolder . $newAudioName);
    $result = mysqli_query($con, "INSERT INTO musics_db VALUES('$music_id', '$songName', '$songArtist', 'authorPFPs/$music_id.jpg', '$duration', '$ratings')");

    if (!$result) {
        die('Error: ' . mysqli_error($con));
    }
}
mysqli_close($con);
?>