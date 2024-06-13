<?php
session_start();
include "../pdo/PDO.php";

// var_dump($_POST);

$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();

if (isset($_POST['resposta'])) {
	$id_pergunta = $_GET['id'];
	$id_pergunta = intval($id_pergunta);
	$pdo->insertResposta($_POST['resposta'], $_SESSION['id_user'], $id_pergunta);
}

if (isset($_FILES['arquivo'])) {
	$img = $_FILES['arquivo']; 
	$img_file = $img['tmp_name']; 
	$bin = file_get_contents($img_file);
	$img_string = base64_encode($bin);
	$pdo->updateImg($img_string, $_SESSION['id_user']);		
}

if (!isset($_GET['erro'])) {
	header('location:index.php?id=' . $_GET['id'] . '');
} else {
	header('location:index.php?erro');
}


// echo $senha;
// var_dump($pdo);
