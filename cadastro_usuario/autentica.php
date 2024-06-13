<?php 
include '../pdo/PDO.php';
session_start();

$login = $_POST['email'];
$senha = hash('sha256', $_POST['senha']);

$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();

$user = $pdo->selectAstericoUser($login);
// var_dump($user);

if($login == $user['email'] and $senha == $user['senha']) {
	$_SESSION['email'] = $login;
	$_SESSION['nome'] = $user['nick'];
	header('location:../pagina_inicial/index.php');
}
else{
	unset ($_SESSION['email']);
  	unset ($_SESSION['nome']);
	session_unset();
	header('location:login.php?erro');
}

?>