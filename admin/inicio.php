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
  <style>
    a {
      text-decoration: none;
    }
  </style>
</head>

<body>

  <h1 style="text-align:center;" class="mt-3">Parabens você tem total controle dos dados do site</h1>
  <h5 style="text-align:center;" class="mt-3">
    <a href="https://www.youtube.com/watch?v=pyTT9Q236sQ" target="_blank ">E lembre-se:</a>
  </h5>
    <a href="https://www.youtube.com/watch?v=eKUGhhQGxno" target="_blank"><img src="tio-ben.jpg" alt="com grandes poderes vem grandes responsabilidades"></a>

    <br>
    <br>

  <div class="d-grid gap-2">
    <a href="index.php" class="btn btn-outline-primary" style="margin-right: 8px;">Pessoas</a>
    <a href="user.php" class="btn btn-outline-primary" style="margin-right: 8px;">Usuarios</a>
    <a href="pergunta.php" class="btn btn-outline-primary" style="margin-right: 8px;">Perguntas</a>
    <a href="resposta.php" class="btn btn-outline-primary" style="margin-right: 8px;">Respostas</a>
    <a href="cep.php" class="btn btn-outline-primary" style="margin-right: 8px;">CEP</a>
    <a href="cidade.php" class="btn btn-outline-primary" style="margin-right: 8px;">Cidade</a>
    <a href="estado.php" class="btn btn-outline-primary" style="margin-right: 8px;">Estado</a>
    <a href="../pagina_inicial/index.php" class="btn btn-outline-primary" style="margin-right: 8px;">Voltar</a>
    <br>
    <br>
  </div>

</body>

</html>