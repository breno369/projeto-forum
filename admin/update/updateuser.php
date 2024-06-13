<?php
session_start();

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['nome']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['nome']);
    session_unset();
    header('location:../cadastro_usuario/login.php?erro1');
}


if ((isset($_SESSION['email']) == true) and (isset($_SESSION['nome']) == true)) {
    include "../../pdo/PDO.php";

    $pdo = new usePDO();
    $pdo->createDB();
    $pdo->createTable();

    $permissao = $pdo->selectPermissao($_SESSION['id_user']);
    if ($permissao[0] == 1) { // Quanto mais proximo de 0 for a permissao, mais acesso e controle o usuario vai ter(se for 0 entao é root)
        echo 'Zé da manga';
        session_unset();
        header('location:../../cadastro_usuario/login.php?erro1');

    } else {
        $_SESSION['permissao'] = $permissao[0];
    }

    $iduser = $pdo->selectIdUsuarios($_SESSION['email']);
    $_SESSION['id_user'] = $iduser[0];


    if (isset($_SESSION['nome'])) {
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
    <?php

    $id = NULL;

    if (isset($_GET['id'])) {
    }
    $id = $pdo->selectID($_GET['id'], 'usuarios');

    // var_dump($_POST);
    // echo '<br><br><br>';
    // var_dump($id);


    if ($_POST != null) {
        if ($_POST['permissao'] == 0) {
            $permissao = 0;
        } else {
            $permissao = 1;
        }
        if ($_POST['senha'] == null) {
            $pdo->updateUserNSenha($_POST['nick'], $_POST['email'], $permissao, $_POST['id']);
            header('location:../user.php');
    
        } else {
            $senha = hash('sha256', $_POST['senha']);// transforma senha em hash sha256
            $pdo->updateUser($_POST['nick'], $_POST['email'], $senha, $permissao, $_POST['id']);
            header('location:../user.php');
    
        }
    }
    ?>
    <div class="container">

        <form action="" method="POST" class="col-6 p-4 needs-validation" novalidate>
            <input type="hidden" name="id" value="<?php echo $id['id']; ?>">
            <!-- <input type="hidden" name="id_user" value="
            <?php
            // echo $_GET['id_user'];
            ?>
            "> -->

            <h1 class="mb-3">Editar usuarios</h1>
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Nickname</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-file-earmark-person"></i>
                </span>
                <input type="text" class="form-control" placeholder="Nickname" aria-label="Nickname"
                    aria-describedby="basic-addon1" name="nick" required value="<?php echo $id['nick']; ?>">
                <div class="invalid-feedback">
                    Insira um Nickname!
                </div>
            </div>

            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-file-earmark-person"></i>
                </span>
                <input type="text" class="form-control" placeholder="Email" aria-label="Email"
                    aria-describedby="basic-addon1" name="email" required value="<?php echo $id['email']; ?>">
                <div class="invalid-feedback">
                    Insira um Email!
                </div>
            </div>

            <label for="colFormLabelSm" class="col-sm-auto col-form-label col-form-label-sm">Senha (insira uma senha
                apenas se for para muda-la)</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-file-earmark-person"></i>
                </span>
                <input type="text" class="form-control" placeholder="Senha" aria-label="senha"
                    aria-describedby="basic-addon1" name="senha" value="">
                <div class="invalid-feedback">
                    Insira um Senha!
                </div>
            </div>

            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Permissão</label>
            <div class="input-group mb-3 r-3 gap-3">
                <?php
                if ($id['permissao'] == 1) {
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="permissao" id="flexRadioDefault1" value="1"
                            checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            Usuario comum
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="permissao" id="flexRadioDefault2" value="0">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Administrador
                        </label>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="permissao" id="flexRadioDefault1" value="1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Usuario comum
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="permissao" id="flexRadioDefault2" value="0"
                            checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Administrador
                        </label>
                    </div>
                    <?php
                }
                ?>
            </div>

            <input type="submit" value="Salvar" class="btn btn-success">

        </form>
    </div>

</body>

</html>