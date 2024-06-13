<html>
<head>
  <title>Cadastro de Pessoas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
</head>
<body>

	<h1 style="text-align:center;" class="my-3">Cadastros</h1>
	<div class="d-flex justify-content-center my-3">
		<a href="index.php" class="btn btn-primary">Novo Cadastro</a>
	</div>

<?php 
session_start();
include "PDO.php";

$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();

// var_dump($pdo->selectAsterisco());
echo '<div class="container"><table class="table table-striped text-center align-middle">';
echo '<thead> <tr class="table-dark">
      <th scope="col">ID</th>
      <th scope="col">Nome Completo</th>
      <th scope="col">RG</th>
      <th scope="col">Órgão Emissor</th>
      <th scope="col">CPF</th>
      <th scope="col">Data de Nascimento</th>
      <th scope="col">Sexo</th>
      <th scope="col" colspan="2">Ações</th>
    </tr>
  </thead>
  <tbody>';


foreach ($pdo->selectAsterisco() as $pessoa){
	if($pessoa['sexo'] == NULL){
		$sexo = 'Não informado';
	}
	else if($pessoa['sexo'] == 'M'){
		$sexo = 'Masculino';
	}
	else{
		$sexo = 'Feminino';
	}

	$nasc = DateTime::createFromFormat('Y-m-d', $pessoa['data_nasc']);
	$data_nasc = $nasc->format('d/m/Y');

	echo "<tr>
			<td>{$pessoa['ID']}</td>
      		<td>{$pessoa['nome_completo']}</td>
      		<td>{$pessoa['rg']}</td>
      		<td>{$pessoa['orgao_emissor']}</td>
      		<td>{$pessoa['cpf']}</td>
      		<td>{$data_nasc}</td>
      		<td>{$sexo}</td>".
      		'<td>
      			<a href="index.php?id='. $pessoa['ID'] .'">
				  <i class="bi bi-pencil-square text-primary"></i>
      			</a>
				</td>
				<td>
				<a href="deletar.php?id='. $pessoa['ID'] .'">
				  <i class="bi bi-trash-fill text-danger"></i>
			  </a>
      		</td>
    	</tr>';
}
	echo '</div></tbody></table>';
?>

</body>
</html>