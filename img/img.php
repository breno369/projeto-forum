<?php
session_start();

$img_file = '../img/iceblog.png';

// Load file contents into variable
$bin = file_get_contents($img_file);

// Encode contents to Base64
$img_string = base64_encode($bin);
header("Content-type: image/png");
$base64 = base64_decode($img_string);
echo $base64;
// echo'<img src="'.$base64.'">';


?>
