<?php 
include "PDO.php";

$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();


if(isset($_POST['sexo'])){
	$sexo = $_POST['sexo'];
	if($sexo == "Não Informado"){
		$sexo = NULL;
	}
}
else{
	$sexo = NULL;
}

$pdo->update($_POST['ID'], $_POST['nome'], $_POST['RG'], 
	$_POST['emissor'], $_POST['cpf'], 
	$_POST['nasc'], $sexo);

 header("location:leitura.php");

?>