<?php
session_start();

if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['nome']) == true)) {
  unset($_SESSION['email']);
  unset($_SESSION['nome']);
  session_unset();
  header('location:../cadastro_usuario/login.php?erro1');
}


if((isset($_SESSION['email']) == true) and (isset($_SESSION['nome']) == true)) {
  include "../pdo/PDO.php";

  $pdo = new usePDO();
  $pdo->createDB();
  $pdo->createTable();

  $permissao = $pdo->selectPermissao($_SESSION['id_user']);
  if($permissao[0] == 1) { // Quanto mais proximo de 0 for a permissao, mais acesso e controle o usuario vai ter(se for 0 entao é root)
    echo 'Zé da manga';
    session_unset();
    header('location:../cadastro_usuario/login.php?erro1');

  } else {
    $_SESSION['permissao'] = $permissao[0];
  }

  $iduser = $pdo->selectIdUsuarios($_SESSION['email']);
  $_SESSION['id_user'] = $iduser[0];


  if(isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
  } else {
    $nome = '';
  }
}
?>
<html>

<head>
	<title>Cadastro de Pessoas</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
		crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
</head>

<body>
	<div class="container my-3">
		<div class="alert alert-success" role="alert">

			<?php
			$tabela = $_GET['tabela'];
			// var_dump($_GET);
			switch($tabela) {
				case "pessoas":
					$pdo->delete($_GET['id'], $tabela);
					echo "Pessoa de ID ".$_GET['id']." deletado com sucesso!";
					echo "</div>";
					echo '<a href="index.php" class="btn btn-success">Voltar</a>';

					break;
				case "usuarios":
					$pdo->delete($_GET['id'], $tabela);
					echo "Usuario de ID ".$_GET['id']." deletado com sucesso!";
					echo "</div>";
					echo '<a href="user.php" class="btn btn-success">Voltar</a>';

					break;
				case "perguntas":
					$pdo->delete($_GET['id'], $tabela);
					echo "Pergunta de ID ".$_GET['id']." deletado com sucesso!";
					echo "</div>";
					echo '<a href="pergunta.php" class="btn btn-success">Voltar</a>';

					break;
				case "respostas":
					$pdo->delete($_GET['id'], $tabela);
					echo "Resposta de ID ".$_GET['id']." deletado com sucesso!";
					echo "</div>";
					echo '<a href="resposta.php" class="btn btn-success">Voltar</a>';

					break;
				case "endereco":
					$pdo->delete($_GET['id'], $tabela);
					echo "Endereco de ID ".$_GET['id']." deletado com sucesso!";
					echo "</div>";
					echo '<a href="cep.php" class="btn btn-success">Voltar</a>';

					break;
				case "cidade":
					$pdo->delete($_GET['id'], $tabela);
					echo "Cidade de ID ".$_GET['id']." deletado com sucesso!";
					echo "</div>";
					echo '<a href="cidade.php" class="btn btn-success">Voltar</a>';

					break;
				case "estado":
					// $pdo->delete($_GET['id'], $tabela);	
					echo "Estado de ID ".$_GET['id']." deletado com sucesso!";
					echo "</div>";
					echo '<a href="estado.php" class="btn btn-success">Voltar</a>';

					break;
				default:
					echo "DEU ERRADO";
					echo "</div>";
					echo '<a href="inicio.php" class="btn btn-success">Voltar para o inicio</a>';

			}

			?>

		</div>
</body>

</html>