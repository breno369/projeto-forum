<?php
session_start();
include "../pdo/PDO.php";
$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();

var_dump($_POST);


function adiciona($tabela, $valor, $id)
{
    $pdo = new usePDO();
    $pdo->createDB();
    $pdo->createTable();
    $selectabela = $pdo->selectTabela($tabela, $valor);
    
    //verifica se existe id de estado
    if ($tabela == 'cidade') { //se existir o id, executa a função de inserir na cidade

        //verifica se existe uma cidade($valor) na tabela cidade
        if ($selectabela == !' ') { //se não existir faz um insert na cidade
            $tabela = $pdo->insert($tabela, $valor, $id);
            $idTabela = intval($tabela);

            if ($idTabela == ' ') { //verifica se ocorreu algum erro
                return 'erroCidade'; //se ocorreu algum erro retorna 'erroCidade'

            } else { //se não ocorreu nenhum erro retorna o id
                return $idTabela;
            }
        } else { //se existir retorna o id da cidade
            return $selectabela[0][0];
        }
    } 
    
    
    else { //se não existir o id, vai inserir no estado

        //verifica se existe um estado($valor) na tabela estado
        if ($selectabela == !' ') { //se existir faz um insert
      
            $tabela = $pdo->insert($tabela, $valor, $id);
            $idTabela = intval($tabela);
            
            if ($idTabela == ' ') { //verifica se ocorreu algum erro
                return 'erroEstado'; //se ocorreu retorna 'erroEstado'
                
            } else {
                return $idTabela; //se nao ocorreu retorna id
            }
        } else {
            return $selectabela[0][0]; //se existe retorna o id do estado
        }
    }
}

// $_POST['email'] = 'zxv@bfd';
// $_POST['rg'] = 13329;
// $_POST['cpf'] = 13981;


$senha = hash('sha256', $_POST['senha']);// transforma senha em hash sha256
$insertuser = $pdo->insertUsuarios(
    $_POST['usuario'],
    $_POST['email'],
    $senha
);
$idUser = intval($insertuser);

if (isset($_POST['sexo'])) {
    $sexo = $_POST['sexo'];
    if ($sexo == "Não Informado") {
        $sexo = null;
    }
} else {
    $sexo = null;
}

$erro = 0;
if ($idUser == null) {
    $Insertpessoas = "ErroInsertUser";
    die();

} else {
    $Insertpessoas = $pdo->insertPessoas(
        $_POST['nome'],
        $_POST['rg'],
        $_POST['emissor'],
        $_POST['cpf'],
        $_POST['nasc'],
        $sexo,
        $idUser
    );
    $idPessoa = intval($Insertpessoas);

    if ($idPessoa == !null) {
        $idEstado = adiciona('estado', $_POST['estado'], 0);
        if ($idEstado == 'erroEstado') {
            $erro = 'erroInsertEstado';
            die();
        }
        else {
            $idCidade = adiciona('cidade', $_POST['cidade'], $idEstado);
            if ($idCidade == 'erroCidade') {
                $erro = 'erroInsertEstado';
                die();
            }
            else {
                $endereco = $pdo->insertEndereco($_POST['cep'], $_POST['num'], $_POST['logradouro'], $_POST['bairro'], $idPessoa, $idCidade);
                if ($endereco == 'ErroInsertEndereco') {
                    $erro = 'erroInsertEndereco';
                    die();
                }
            }
        }
        
    }
}


// echo '<br>';
// echo '<br>';
// var_dump($_POST);
// echo '<br>';
// echo '<br>';


if ($Insertpessoas == "ErroInsertUser") {
    // deu pau, faz o que for necessário
    // apaga o usuário, tu já tem o id
    // echo '<h1>erro inserir usuarios</h1>';
    header('location:cadastro.php?erro=user');
} elseif ($Insertpessoas == "ErroInsertPessoas") {
    $pdo->deleteUser($idUser);
    // echo '<h1>erro inserir pessoas</h1>';
    header('location:cadastro.php?erro=pessoa');

} elseif ($erro == "erroInsertEstado") {
    $pdo->deleteUser($idUser);
    // echo '<h1>erro inserir pessoas</h1>';
    header('location:cadastro.php?erro=estado');

} elseif ($Insertpessoas == "erroInsertCidade") {
    $pdo->deleteUser($idUser);
    $pdo->deleteEstado($idEstado);
    // echo '<h1>erro inserir pessoas</h1>';
    header('location:cadastro.php?erro=cidade');

} elseif ($Insertpessoas == "erroInsertEndereco") {
    $pdo->deleteUser($idUser);
    $pdo->deleteEstado($idEstado);
    // echo '<h1>erro inserir pessoas</h1>';
    header('location:cadastro.php?erro=endereco');

} else {
    // insert user, lembra de colocar tratativa igual de erro
    // lembra que tem q ser usuário primeiro que pessoa pq o relacionamento é ao contrário
    header('location:login.php?sucesso');
}
