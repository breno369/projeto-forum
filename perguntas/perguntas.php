<?php
session_start();
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['nome']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['nome']);
    session_unset();
    header('location:../cadastro_usuario/login.php?erro1');
}
var_dump($_SESSION);

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
    <style>
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
    </style>
    <title>Document</title>
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
                                        <form enctype="multipart/form-data" action="processa.php" method="post" class="dropdown-menu p-4">
                                            <div class="mb-3">
                                                <div class="mb-3">
                                                    <label for="formFileSm" class="form-label" style="color: #fff;">Procurar</label>
                                                    <input name="arquivo" class="form-control-sm" type="file" id="formFile" placeholder="buscar">
                                                </div>
                                                <button type="submit" class="btn btn-outline-secondary">Enviar</button>
                                            </div>
                                        </form>
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
        <div class="item2">
            <!-- <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-3" style="padding: 5px;">
                        <img src="../img/foto2.jpg" class="img-fluid rounded-start" alt="...">
                        <br>
                        <button type="button" class="btn btn-sm" style="max-width: 24px;" onmousedown="blike(this)" onmouseup="wlike(this)"><i class="bx bx-like"></i></button>
                        <button type="button" class="btn btn-sm" style="max-width: 24px;" onmousedown="bdislike(this)" onmouseup="wdislike(this)"><i class='bx bx-dislike'></i></button>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Cad title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                additional content. This content is a little bit longer.</p>
                            <a href="../responder/index.php" class="btn btn-outline-secondary">Ver respostas</a>
                        </div>
                    </div>
                </div>
            </div> -->
            <?php

            foreach ($pdo->selectAsteriscoPergunta() as $pergunta) {
                // print_r($pergunta);
                $nick = $pdo->selectNickUsuario($pergunta[1]);
                // echo '<br>';
                // echo '<br>';
                // print_r($nick);  
                $img = $pdo->selectImagemPessoa($pergunta['id_usuario']);
                // echo '<br>';
                // echo '<br>';
                // print_r($img);
                echo '<div class="card mb-3">';
                echo '    <div class="row g-0">';
                echo '   <div class="col-md-3" style="padding: 5px;">';
                echo '     <img src="data:image/jpg; base64,' . $img[0] . '" style="max-height: 132px;"class="img-fluid rounded-start" alt="...">';
                echo '     <br>';
                // var_dump($pdo->userLikeDislike($pergunta[0], $userid, 'like'));
                $userid = $pergunta[1];
                if ($pdo->userLikeDislike($pergunta[0], $userid, 'like') == 1) {
                    echo '<i class="fa like-btn fa-thumbs-up" data-id="' . $pergunta[0] . '"></i>';
                    echo '<span class="likes">' . $pdo->getLikeDislike($pergunta[0], 'like') . '</span>';
                } else {
                    echo '<i class="fa like-btn fa-thumbs-o-up" data-id="' . $pergunta[0] . '"></i>';
                    echo '<span class="likes">' . $pdo->getLikeDislike($pergunta[0], 'like') . '</span>';
                }

                echo '&nbsp;&nbsp;&nbsp;&nbsp;';

                // var_dump($pdo->userLikeDislike($pergunta[0], $userid, 'dislike'));

                if ($pdo->userLikeDislike($pergunta[0], $userid, 'dislike') == 1) {
                    echo '<i class="fa dislike-btn fa-thumbs-down" data-id="' . $pergunta[0] . '"></i>';
                    echo '<span class="dislikes">' . $pdo->getLikeDislike($pergunta[0], 'dislike') . '</span>';
                } else {
                    echo '<i class="fa dislike-btn fa-thumbs-o-down" data-id="' . $pergunta[0] . '"></i>';
                    echo '<span class="dislikes">' . $pdo->getLikeDislike($pergunta[0], 'dislike') . '</span>';
                }

                echo '    </div>';
                echo '    <div class="col-md-8">';
                echo '        <div class="card-body">';
                echo '            <h5 class="card-title">' . $nick[0][0] . '</h5>';
                echo '            <p class="card-text">' . $pergunta['pergunta'] . '</p>';
                echo '            <a href="../responder/index.php?id=' . $pergunta['id'] . '" class="btn btn-outline-secondary">Ver respostas</a>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
                echo '</div>';
            }
            ?>

        </div>
        <!--------------------NAV-------------------->
        <div class="item3">


            <div class="d-inline-flex p-2">I'm an inline flexbox container!</div>

        </div>
        <!--------------------ADS-------------------->
        <div class="item4">

            <div class="d-inline-flex p-2">I'm an inline flexbox container!</div>

        </div>
        <!--------------------PAGINATION-------------------->
        <div class="item5">
            <!-- <nav class="pag" aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true"><i class='bx bx-chevron-left'></i></span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link nexit" href="#" aria-label="Next">
                            <span aria-hidden="true"><i class='bx bx-chevron-right'></i></span>
                        </a>
                    </li>
                </ul>
            </nav> -->


            <!-- <nav class="pag1" aria-label="Page navigation example">
                <ul class="pagination1">
                    <li class="page-item1">
                        <a class="page-link1" href="#" aria-label="Previous">
                            <span aria-hidden="true"><i class='bx bx-chevron-left'></i></span>
                        </a>
                    </li>
                    <li class="page-item1"><a class="page-link1" href="#">1</a></li>
                    <li class="page-item1"><a class="page-link1" href="#">2</a></li>
                    <li class="page-item1"><a class="page-link1" href="#">3</a></li>
                    <li class="page-item1">
                        <a class="page-link1 next" href="#" aria-label="Next">
                            <span aria-hidden="true"><i class='bx bx-chevron-right'></i></span>
                        </a>
                    </li>
                </ul>
            </nav> -->
        </div>

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