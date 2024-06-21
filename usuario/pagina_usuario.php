<?php
session_start();
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['nome']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['nome']);
    session_unset();
    header('location:../cadastro_usuario/login.php?erro1');
}
// var_dump($_SESSION);

if ($_SESSION != null && (isset($_SESSION['email']) == true) and (isset($_SESSION['nome']) == true)) {
    include "../pdo/PDO.php";

    $pdo = new usePDO();
    $pdo->createDB();
    $pdo->createTable();

    $permissao = $pdo->selectPermissao($_SESSION['id_user']);
    // var_dump($permissao);
    if ($permissao[0] != 0) { // Quanto mais proximo de 0 for a permissao, mais acesso e controle o usuario vai ter(se for 0 entao é root)
        $_SESSION['permissao'] = null;
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../img/Iconeberg-sem-fundo.ico" type="image/x-icon">
    <!-- <style>
        body {
            padding: 0;
            margin: 0;
            color: #fff;
        }

        .item1 {
            grid-area: header;
        }

        .item2 {
            grid-area: main;
        }

        .item3 {
            grid-area: adsr;
        }

        .item4 {
            grid-area: adsl;
        }

        .item5 {
            grid-area: pag;
        }

        .item6 {
            grid-area: void;
        }

        .page {
            display: grid;
            grid-template-areas:
                'header header header header header header header header'
                'adsl adsl main main main main adsr adsr'
                'adsl adsl main main main main adsr adsr'
                'adsl adsl main main main main adsr adsr'
                'adsl adsl main main main main adsr adsr'
                'adsl adsl main main main main adsr adsr'
                'adsl adsl main main main main adsr adsr'
                'adsl adsl pag void void void adsr adsr'
            ;
            /* gap: 10px; */
            padding-top: 0px;
            padding-right: 0;
            padding-left: 0;
            padding-bottom: 4px;
            margin-bottom: 0px;
            background-color: #788199;
            min-height: 100vh;
            grid-template-rows: 58px;
        }

        /* 
        #d6d9 e2
        #a3a8 b7 
        */

        /*********MAIN*********/
        .item2 {
            background-color: #788199;
            gap: 10px;
            padding: 10px;
            padding-bottom: 0px;
            height: auto;
        }

        /*********ADS RIGHT*********/
        .item3 {
            background-color: #8990A2;
            gap: 10px;
            padding: 10px;
            padding-top: 0px;
            padding-bottom: 0px;
            margin-top: 10px;
            margin-bottom: 10px;
            margin-right: 10px;
            min-height: auto;
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 0.375rem;
        }

        /*********ADS LEFT*********/
        .item4 {
            background-color: #8990A2;
            gap: 10px;
            padding: 10px;
            padding-bottom: 0px;
            margin-top: 10px;
            margin-bottom: 10px;
            margin-left: 10px;
            min-height: auto;
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 0.375rem;
        }


        /*********PAGINATION*********/
        .item5 {
            background-color: #788199;
            margin: 1px;
            /* gap: 10px; */
            padding: 0px;
            padding-left: 10px;

        }

        .pag1 {
            margin: 0px;
        }

        .pagination1 {
            list-style-type: none;
            display: flex;
            flex-direction: row;
        }

        .pagination1 a {
            margin: 0;
            /* border: 2px solid rgba(255, 255, 255, 0.2);
            border-right: 0;
            background-color: #8990A2; */
        }

        .pagination1 a:hover {
            margin: 0;
            /* border: 2px solid rgba(255, 255, 255, 0.2);
             border-right: 0;
            style="border-color: blue; border-top: 20px;"
             
            background-color: #8990A2;*/
        }

        .page-item1 {
            margin: 0;
            padding: 0;
            width: auto;
            height: auto;
            /* border-radius: 0.375rem; */
            text-align: center;
        }

        .next {
            margin: 0;
        }

        /* .page-item1:hover {
            background-color: #788199;
            border-right: 2px solid rgba(255, 255, 255, 0.2);
             border-radius: 0.375rem; 
        } */
        /* 
        .next:hover{
            background-color: #788199;
        } */

        .page-link1 {
            border-right: 2px;
            background-color: #8990A2;
            height: auto;
            width: auto;
            padding: 5px;
            margin: 0;
            gap: 5px;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-right: 0;
            text-decoration: none;
            border-radius: 0.375rem;
        }

        .page-link1:hover {
            border-right: 2px;
            background-color: #788199;
            color: #fff;
            text-decoration: none;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-right: 0;

        }

        .next {
            margin: 0;
            border-right: 2px solid rgba(255, 255, 255, 0.2);
        }

        /*********VOID*********/
        .item6 {
            opacity: 1;
        }

        /*********DIVERSOS*********/
        .btn-sm {
            padding: 5px;
            width: 24px;
            height: 24px;
            border: none;
        }

        .col-md-3 {
            padding: 10px;
        }

        .img-fluid {
            border-radius: var(--bs-border-radius);
        }

        .card {
            background-color: #8990A2;
            min-height: auto;
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        #txtHint {
            position: absolute;
        }

        .search {
            background: #8990A2;
            margin-top: 40px;
            max-width: 199px;
            width: 199px;
            word-break: break-all;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 0.375rem;
        }

        .a {
            text-decoration: none;
            margin: 4px;
            font-size: 16px;
            color: #fff;
            width: 199px;
            max-width: 199px;
        }

        .p {
            text-decoration: none;
            margin: 4px;
            font-size: 16px;
            color: #fff;
            max-width: 199px;
            width: 199px;
        }

        /* #788199 */
    </style> -->

    <style>
        /*********HEADER*********/
        .item1 {
            background-color: #8990A2;
            gap: 0px;
            padding: 0px;
            padding-bottom: 5px;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .dropdown-menu {
            background-color: #8990A2;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 0.375rem;

        }

        .dropdown-item {
            color: #fff;
            margin: 0px;

        }

        .dropdown-menu li a:hover {
            background-color: #8990A2;
            color: #ffffffb4;

        }

        .dropdown-menu li p:hover {
            background-color: #8990A2;
            color: #fff;

        }

        .editar {
            border: none;
            background-color: #8990A2;
            padding-left: 16px;

        }

        .editar:hover {
            border: none;
            background-color: #8990A2;
            color: #ffffffb4;
        }

        .editar:focus {
            border: none;
            background-color: #8990A2;
            color: #ffffffb4;
        }

        .btn-outline-secondary {
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .btn-outline-secondary:hover {
            border: 2px solid rgba(255, 255, 255, 0.2);
            background-color: rgba(255, 255, 255, 0.2);

        }
    </style>
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>

<body>
    <div class="page">

        <!--------------------NAVBAR-------------------->
        <div class="item1">

            <nav class="navbar navbar-expand-lg " style="background-color: #8990A2;">
                <div class="container-fluid">
                    <img src="../img/Iconeberg.png" alt="iconeberg" width="auto" height="40">
                    <a class="navbar-brand" style="color: #fff;" href="../pagina_inicial/index.php">Navbar</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" style="color: #fff;" aria-current="page" href="../pagina_inicial/index.php">Inicio</a>
                            </li>
                            <li class="nav-item dropdown">
                                <!-- <a class="nav-link dropdown-toggle" style="color: #fff;" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Mais
                                </a> -->

                                <button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" style="color: #fff; height: 40px;">
                                    Mais
                                </button>

                                <ul class="dropdown-menu">
                                    <!-- <li><a class="dropdown-item" href="#">Deep Web</a></li>
                                    <li><a class="dropdown-item" href="#">Hacking</a></li>
                                    <li><a class="dropdown-item" href="#">Programação</a></li>
                                    <li>
                                        <hr class="dropdown-divider" style=" border: 1px solid rgba(255, 255, 255, 0.2);">
                                    </li> -->
                                    <li><a class="dropdown-item" href="../perguntar/index.php">Fazer uma pergunta</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" style=" border: 1px solid rgba(255, 255, 255, 0.2);">
                                    </li>
                                    <?php

                                    if (isset($_SESSION['nome'])) {
                                        echo '<li><p class="dropdown-item">Olá ' . "$nome" . '</p></li>';
                                    } else {
                                        echo '<li><a class="dropdown-item" href="../cadastro_usuario/cadastro.php">Cadastro</a></li>
                                        <li><a class="dropdown-item" href="../cadastro_usuario/login.php">Login</a></li>';
                                    }

                                    if ($_SESSION['permissao'] !== null) {
                                        echo '<li><a class="dropdown-item" href="../admin/inicio.php">Gerenciar</a></li>';
                                    }

                                    ?>
                                    <li class="dropdown dropend">
                                        <button type="button" class="editar btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" style="color: #fff;">
                                            Editar perfil
                                        </button>
                                        <!-- <form enctype="multipart/form-data" action="processa.php" method="post" class="dropdown-menu p-4">
                                            <div class="mb-3">
                                                <div class="mb-3">
                                                    <label for="formFileSm" class="form-label" style="color: #fff;">Procurar</label>
                                                    <input name="arquivo" class="form-control-sm" type="file" id="formFile" placeholder="buscar">
                                                </div>
                                                <button type="submit" class="btn btn-outline-secondary">Enviar</button>
                                            </div>
                                        </form> -->
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" style=" border: 1px solid rgba(255, 255, 255, 0.2);">
                                    </li>
                                    <li><a class="dropdown-item" href="../cadastro_usuario/logout.php">Sair</a></li>

                                </ul>
                            </li>
                        </ul>

                        <form class="d-flex" role="search">
                            <input class="form-control me-2  focus-ring py-1 px-2 text-decoration-none border rounded-2" style="--bs-focus-ring-color: rgba(#8990A2, .25)" type="search" placeholder="Search" aria-label="Search" onkeyup="showHint(this.value)">
                            <div id="txtHint"></div>
                            <button class="btn" type="submit" style="border: none;"><i class='bx bx-search'></i></button>
                        </form>
                    </div>
            </nav>

        </div>

        <!--------------------MAIN-------------------->
        <style>
            .material-symbols-outlined {
                font-variation-settings:
                    'FILL' 0,
                    'wght' 100,
                    'GRAD' 0,
                    'opsz' 24
            }
        </style>
        <style>
            .container_main {
                height: 100vh;
                background-color: #8990A2;
            }

            .link_user {
                width: 30vw;
                height: 100%;
                /* background-color: blue; */
                display: flex;
                flex-direction: column;
                justify-content: start;
                align-items: center;
                position: sticky;
                border-right: 1px solid rgba(255, 255, 255, 0.2);
            }

            .actions_user {
                height: 100%;
                width: 70vw;
                /* background-color: green; */
            }

            .img_user {
                width: 150px;
                height: 150px;
                border-radius: 100%;
                background-color: #fff;
                margin: 50px 0 0 0;
            }

            .list_link_user {
                margin: 45px 0 0 0 !important;
                width: 100%;
                padding: 0;
            }

            .list_link_user>button {
                color: #fff;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                padding: 13px 0 13px 20%;
                align-items: center;
                display: flex;
                justify-content: space-between;
                font-size: 20px;
                line-height: 45px;
                font-weight: 300;
                border-radius: 0 !important;
            }

            .list_link_user>.active {
                background-color: #ffffff33 !important;
                border-bottom: 1px solid #00000000 !important;
            }

            .nav-link:hover {
                color: #ffffff33 !important;
            }
        </style>
        <!-- <span class="material-symbols-outlined" style="font-size: 35px;">chevron_right</span> -->
        <div class="container_main">
            <div class="d-flex align-items-start">

                <div class="link_user">

                    <div style="height: auto;width: 100%;display: flex;flex-direction: column;align-items: center;">

                        <div class="img_user"></div>
                        <div class="nav flex-column nav-pills me-3 list_link_user" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                            <button class="nav-link active" id="v-pills-editarImg-tab" data-bs-toggle="pill" data-bs-target="#v-pills-editarImg" type="button" role="tab" aria-controls="v-pills-editarImg" aria-selected="true">Editar imagem de perfil</button>
                            <button class="nav-link" id="v-pills-editarNome-tab" data-bs-toggle="pill" data-bs-target="#v-pills-editarNome" type="button" role="tab" aria-controls="v-pills-editarNome" aria-selected="false">Mudar apelido</button>
                            <button class="nav-link" id="v-pills-verPerguntas-tab" data-bs-toggle="pill" data-bs-target="#v-pills-verPerguntas" type="button" role="tab" aria-controls="v-pills-verPerguntas" aria-selected="false">Ver suas perguntas</button>
                            <button class="nav-link" id="v-pills-verRespostas-tab" data-bs-toggle="pill" data-bs-target="#v-pills-verRespostas" type="button" role="tab" aria-controls="v-pills-verRespostas" aria-selected="false">Ver suas respostas</button>
                            <button class="nav-link" id="v-pills-editarInfo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-editarInfo" type="button" role="tab" aria-controls="v-pills-editarInfo" aria-selected="false">Editar informacoes pessoais</button>
                            <button class="nav-link" id="v-pills-mudarSenha-tab" data-bs-toggle="pill" data-bs-target="#v-pills-mudarSenha" type="button" role="tab" aria-controls="v-pills-mudarSenha" aria-selected="false">Mudar senha</button>
                            <button class="nav-link" id="v-pills-sair-tab" data-bs-toggle="pill" data-bs-target="#v-pills-sair" type="button" role="tab" aria-controls="v-pills-sair" aria-selected="false">Sair</button>
                            <button class="nav-link" id="v-pills-del-tab" data-bs-toggle="pill" data-bs-target="#v-pills-del" type="button" role="tab" aria-controls="v-pills-del" aria-selected="false">Deletar minha conta</button>

                        </div>
                    </div>

                </div>

                <div class="tab-content actions_user" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-editarImg" role="tabpanel" aria-labelledby="v-pills-editarImg-tab">
                        <p>
                            Area para editar foto de perfil
                        </p>
                    </div>

                    <div class="tab-pane fade" id="v-pills-editarNome" role="tabpanel" aria-labelledby="v-pills-editarNome-tab">
                        <p>
                            Area para Mudar apelido
                        </p>
                    </div>

                    <div class="tab-pane fade" id="v-pills-verPerguntas" role="tabpanel" aria-labelledby="v-pills-verPerguntas-tab">
                        <p>
                            Area para Ver suas perguntas
                        </p>
                    </div>

                    <div class="tab-pane fade" id="v-pills-verRespostas" role="tabpanel" aria-labelledby="v-pills-verRespostas-tab">
                        <p>
                            Area para ver suas respostas
                        </p>
                    </div>

                    <div class="tab-pane fade" id="v-pills-editarInfo" role="tabpanel" aria-labelledby="v-pills-editarInfo-tab">
                        <p>
                            Area para editar informacoes pessoais
                        </p>
                    </div>

                    <div class="tab-pane fade" id="v-pills-mudarSenha" role="tabpanel" aria-labelledby="v-pills-mudarSenha-tab">
                        <p>
                            Area para mudar senha
                        </p>
                    </div>

                    <div class="tab-pane fade" id="v-pills-sair" role="tabpanel" aria-labelledby="v-pills-sair-tab">
                        <p>
                            Area para sair
                        </p>
                    </div>

                    <div class="tab-pane fade" id="v-pills-del" role="tabpanel" aria-labelledby="v-pills-del-tab">
                        <p>
                            Area para deletar minha conta
                        </p>
                    </div>
                </div>

            </div>
        </div>
        <!-- <div class="d-flex align-items-start"> ------------------
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</button>
                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</button>
                        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
                        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin libero purus, ultricies sed pharetra a, rutrum ac eros. Praesent egestas ante at odio porttitor, in efficitur metus posuere. Praesent lectus odio, dictum eget convallis sit amet, aliquam ac ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam eleifend euismod libero. Quisque dui odio, lacinia nec ipsum ac, ultricies laoreet enim. Aliquam erat volutpat. Pellentesque sit amet varius sapien. Morbi non elementum ipsum. Praesent dignissim id risus sed vehicula. Aenean eu placerat magna. Donec mollis ornare dui, in varius sem sodales non. Fusce dapibus tellus nec nulla finibus tempor quis a dolor. Nunc velit tortor, suscipit quis tincidunt luctus, congue id erat. Suspendisse sollicitudin sapien et gravida vulputate. Etiam faucibus nibh non arcu tincidunt commodo.

                                Sed commodo dignissim sapien sit amet volutpat. Fusce id urna ligula. Donec est orci, fermentum nec iaculis in, imperdiet a nibh. Mauris blandit augue id velit iaculis eleifend. Praesent vulputate quis velit eu viverra. Aenean molestie augue in elit rutrum consequat. Phasellus arcu purus, scelerisque id bibendum quis, aliquam id nibh. Proin tincidunt tincidunt mi vel maximus. Sed viverra augue in rhoncus lacinia. Donec sodales quam nunc, ac tincidunt diam sodales id. Vivamus euismod sapien lectus, lacinia dapibus ante pharetra congue. Donec non ligula in dolor blandit fermentum. Quisque volutpat nulla a sem molestie ornare. Vestibulum a massa placerat, cursus turpis ac, volutpat mi. Aliquam mollis tellus in purus venenatis, auctor tristique urna varius. Integer ut ipsum ac ligula fringilla tincidunt posuere ac leo.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <p>
                                Suspendisse volutpat neque id ex rutrum sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed accumsan condimentum risus a sollicitudin. Suspendisse potenti. Vivamus nisl sem, euismod id mi et, tristique viverra massa. Duis placerat laoreet nibh sit amet iaculis. Quisque ut aliquam enim. </p>
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <p>
                                Aliquam maximus dolor dui, at efficitur ex scelerisque sit amet. Proin vitae odio eget purus rhoncus facilisis. Etiam semper turpis in diam mattis, quis rhoncus tellus fringilla. Sed vulputate justo orci, non porttitor elit venenatis et. Pellentesque at laoreet justo. Maecenas faucibus consequat nibh ac vulputate. Praesent fermentum nisl sit amet dui iaculis consectetur. Nullam augue diam, tincidunt id urna sed, iaculis egestas risus.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <p>
                                Nunc facilisis nunc ac consectetur viverra. Nulla nibh diam, vehicula sit amet volutpat eget, mattis vel risus. Vestibulum vitae velit sapien. Integer porttitor posuere nulla, ac porttitor sem elementum sit amet. Integer sollicitudin tempor quam, non dapibus quam mattis ac. Pellentesque velit nibh, malesuada eu odio in, mattis blandit leo. Cras ornare elementum tincidunt. Morbi accumsan ullamcorper pellentesque. Donec nec massa nibh. Proin venenatis volutpat libero, eu maximus leo commodo hendrerit. Donec libero velit, accumsan sed placerat at, auctor id ante.
                            </p>
                        </div>
                    </div>
                </div> -->

        <!--------------------LIBRAS-------------------->
        <div vw class="enabled">
            <div vw-access-button class="active"></div>
            <div vw-plugin-wrapper>
                <div class="vw-plugin-top-wrapper"></div>
            </div>
        </div>
        <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
        <script>
            new window.VLibras.Widget({
                rootPah: '/app',
                personalization: 'https://vlibras.gov.br/config/default_logo.json',
                opacity: 0.5,
                position: 'L',
                avatar: 'random',
            });
        </script>

        <!--------------------JS-------------------->
        <script>
            //BARRA DE PESQUISA
            function showHint(str) {
                if (str.length == 0) {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                } else {
                    const xmlhttp = new XMLHttpRequest();
                    xmlhttp.onload = function() {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                    xmlhttp.open("GET", "../pdo/pesquisa.php?q=" + str);
                    xmlhttp.send();
                }
            }
        </script>
        <!--------------------BOOTSTRAP-------------------->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>