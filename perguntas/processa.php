<?php
session_start();
include "../pdo/PDO.php";

// var_dump($_POST);

$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();


// print_r($_SESSION);
// echo '<br>';
// echo '<br>';
// print_r($_FILES['arquivo']);
// echo '<br>';
// echo '<br>';

$img = $_FILES['arquivo']; 
$img_file = $img['tmp_name']; 
$bin = file_get_contents($img_file);
$img_string = base64_encode($bin);

// print_r($img_string);

$pdo->updateImg($img_string, $_SESSION['id_user']);
header('location:perguntas.php');

// if (!isset($_GET['erro'])) {
	
// }
// else {
// 	header('location:perguntas.php?erro');
// 	$pdo -> delete($id[0]);
// }



?>