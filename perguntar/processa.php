<?php
session_start();
include "../pdo/PDO.php";

// var_dump($_POST);

$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();


if (isset($_POST['pergunta'])) {
	$pdo->insertPerguntas($_POST['pergunta'], $_SESSION['id_user']);
	
}
// print_r($_POST);

if (isset($_FILES['arquivo'])) {
	$img = $_FILES['arquivo']; 
	$img_file = $img['tmp_name']; 
	$bin = file_get_contents($img_file);
	$img_string = base64_encode($bin);
	$pdo->updateImg($img_string, $_SESSION['id_user']);		
}

if (!isset($_GET['erro'])) {
	header('location:../perguntas/perguntas.php');
	
}
else {
	header('location:index.php?erro');
}

// echo $senha;
// var_dump($pdo);


?>