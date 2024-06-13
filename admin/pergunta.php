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

    <h1 style="text-align:center;" class="my-3">Perguntas</h1>
    <div class="d-flex justify-content-center my-3">
        <a href="inicio.php" class="btn btn-primary" style="margin-right: 8px;">Voltar para o inicio</a>
        <a href="../pagina_inicial/index.php" class="btn btn-primary" style="margin-right: 8px;">Voltar para pagina
            inicial</a>
        <button class="btn btn-primary" onclick="limpaurl()">Mostrar todos</button>
        <script>
            function limpaurl() {
                // Obtenha a string de consulta da URL
                const queryString = window.location.search;

                // Crie um objeto URLSearchParams a partir da string de consulta
                const params = new URLSearchParams(queryString);

                params.delete('id'); // Remove um parâmetro

                // Obtenha a nova string de consulta
                // const novaQueryString = params.toString();

                // Atualize a URL com a nova string de consulta (sem recarregar a página)
                const novaURL = `${window.location.pathname}`;
                window.history.replaceState({}, '', novaURL);
                location.reload();

            }
        </script>
    </div>

    <?php

    // var_dump($pdo->selectAsterisco());
    echo '<div class="container"><table class="table table-striped text-center align-middle">';
    echo '<thead> <tr class="table-dark">
      <th scope="col">Id</th>
      <th scope="col">Usuario</th>
      <th scope="col">Resposta</th>
      <th scope="col">Pergunta</th>
      <th scope="col" colspan="2">Ações</th>
    </tr>
  </thead>
  <tbody>';

    // $permissao = $pdo->selectUser();
    
    // print_r($_GET);
    if(isset($_GET['id_user'])) {
        $iduser = $_GET['id_user'];

        foreach($pdo->selectAsteriscoPerguntaUser($iduser) as $pergunta) {

            // $idresposta = $pdo->selectIdRespostaPergunta($pergunta['id']);
            // var_dump($idresposta);
            //   $idpessoa = $pdo->selectPessoaIduser($usuario['id']);
            //   var_dump($pergunta);
    
            echo "<tr>
          <td>{$pergunta['id']}</td>
          <td><a href=".'user.php?id='.$pergunta[1].">".$pergunta[1]."</a></td>
          <td><a href=".'resposta.php?id_resposta='.$pergunta[0].">Resposta/s</a></td>
           <td>{$pergunta['pergunta']}</td>".
                '<td>
           <a href="update/updatepergunta.php?id='.$pergunta['id'].'">
           <i class="bi bi-pencil text-primary"></i>
           </a>
           </td>
               <td>
               <a href="deletar.php?id='.$pergunta['id'].'&tabela=perguntas">
                   <i class="bi bi-trash-fill text-danger"></i>
                   </a>
                   </td>
                   </tr>';
        }
    } elseif(isset($_GET['id_pergunta'])) {

        $id = $_GET['id_pergunta'];
        // $id = $pdo->selectIdPergunta($_GET['id_resposta']);
        foreach($pdo->selectAsteriscoPerguntaId($id) as $pergunta) {
            // $idresposta = $pdo->selectIdRespostaPergunta($pergunta['id']);
            // var_dump($idresposta);
            //   $idpessoa = $pdo->selectPessoaIduser($usuario['id']);
            //   var_dump($idresposta);
            //   echo '<br>';
            //   echo '<br>';
            //   echo '<br>';
            // var_dump($pergunta);

            echo "<tr>
                  <td>{$pergunta['id']}</td>
                  <td><a href=".'user.php?id='.$pergunta['id_usuario'].">".$pergunta['id_usuario']."</a></td>
                  <td><a href=".'resposta.php?id_resposta='.$pergunta[0].">Resposta/s</a></td>
                  <td>{$pergunta['pergunta']}</td>".
                '<td>
                   <a href="update/updatepergunta.php?id='.$pergunta['id'].'">
                   <i class="bi bi-pencil text-primary"></i>
                   </a>
                   </td>
                       <td>
                       <a href="deletar.php?id='.$pergunta['id'].'&tabela=perguntas">
                           <i class="bi bi-trash-fill text-danger"></i>
                           </a>
                           </td>
                           </tr>';
        }
    } else {
        foreach($pdo->selectAsteriscoPergunta() as $pergunta) {

            //   $idpessoa = $pdo->selectPessoaIduser($usuario['id']);
            // $idresposta = $pdo->selectIdRespostaPergunta($pergunta['id']);
    
            // var_dump($pergunta);
    
            // <td><a href=".'#'.">".$usuario['id_usuario']."</a></td>
    
            echo "<tr>
      <td>{$pergunta['id']}</td>
      <td><a href=".'user.php?id='.$pergunta[1].">".$pergunta[1]."</a></td>
      <td><a href=".'resposta.php?id_resposta='.$pergunta[0].">Resposta/s</a></td>
      <td>{$pergunta['pergunta']}</td>".
                '<td> 
         <a href="update/updatepergunta.php?id='.$pergunta['id'].'">
         <i class="bi bi-pencil text-primary"></i>
         </a>
         </td>
             <td>
             <a href="deletar.php?id='.$pergunta['id'].'&tabela=perguntas">
                 <i class="bi bi-trash-fill text-danger"></i>
                 </a>
                 </td>
                 </tr>';
        }
    }
    echo '</div></tbody></table>';
    ?>

</body>

</html>