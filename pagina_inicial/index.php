<?php
session_start();
// if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['nome']) == true)) {
// 	unset($_SESSION['email']);
// 	unset($_SESSION['nome']);
// 	session_unset();
// 	header('location:login.php?erro');
// }


if (isset($_SESSION['nome'])) {
    include "../pdo/PDO.php";
    $pdo = new usePDO();
    $pdo->createDB();
    $pdo->createTable();

    $iduser = $pdo->selectIdUsuarios($_SESSION['email']);
    if ($iduser != null) {
        $permissao = $pdo->selectPermissao($iduser[0]);
        
    }


    if ($permissao[0] != 0) { // Quanto mais proximo de 0 for a permissao, mais acesso e controle o usuario vai ter(se for 0 entao é root)
        $_SESSION['permissao'] = null;
    } else {
        $_SESSION['permissao'] = $permissao[0];
    }

    $_SESSION['id_user'] = $iduser[0];
    $nome = $_SESSION['nome'];

    // var_dump($permissao);
    // echo '<br>';
    // var_dump($_SESSION);
    // var_dump($pdo->selectImagemPessoa($iduser[0])[0]);

    if ($pdo->selectImagemPessoa($iduser[0])[0] == "") {
        $img_file = '../img/anonimo.jpg';
        $bin = file_get_contents($img_file);
        $img_string = base64_encode($bin);
        // echo 'sem foto de perfil';
        // var_dump($img_string);
        $pdo->updateImg($img_string, $iduser[0]);
    }
} else {
    $nome = '';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            grid-area: ads;
        }

        .page {
            display: grid;
            grid-template-areas:
                'header header header header header header header header'
                'main main main main main main ads ads'
                'main main main main main main ads ads'
                'main main main main main main ads ads'
                'main main main main main main ads ads'
                'main main main main main main ads ads'
                'main main main main main main ads ads'
                'main main main main main main ads ads'
            ;
            /* gap: 10px; */
            padding-top: 0px;
            padding-right: 0;
            padding-left: 0;
            padding-bottom: 4px;
            margin-bottom: 0;
            background-color: #788199;
            min-height: 100vh;
            grid-template-rows: 58px;
        }

        /*--------HEADER--------*/


        .item1 {
            background-color: #8990A2;
            gap: 0px;
            padding: 0px;
            padding-bottom: 5px;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            min-height: auto;
        }



        .container-fluid {
            color: #fff;
        }


        .container {
            max-width: 800px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;

        }

        .dropdown-menu {
            background-color: #8990A2;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 0.375rem;

        }

        .dropdown-item {
            margin: 0px;
            color: #fff;

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

        /*--------MAIN--------*/
        .item2 {
            gap: 10px;
            padding: 10px;
            padding-bottom: 10px;
            margin-left: 10px;
            min-height: auto;
            background-color: #8990A2;
            margin-top: 10px;
            margin-bottom: 10px;
            margin-right: 10px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 0.375rem;
        }

        /*--------ADS--------*/
        .item3 {
            background-color: #8990A2;
            gap: 10px;
            padding: 10px;
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

        .center {

            text-align: center;

        }

        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: 'roboto', sans-serif;

        }


        .heading {
            width: 90%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            margin: 20px auto;

        }

        .heading h2 {
            font-size: 50px;
            color: #000;
            margin-bottom: 25px;
            position: relative;

        }

        .heading h2::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 4px;
            display: block;
            margin: 0 auto;
            background-color: #666f88;

        }

        .heading P {
            font-size: 18px;
            margin-bottom: 35px;

        }

        /* .heading2 {} */

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 10px 20px;

        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 10px 20px;

        }


        .about {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;

        }

        .about-image {
            flex: 1;
            margin-right: 40px;
            overflow: hidden;

        }

        .about-image img {
            max-width: 100%;
            height: auto;
            display: block;
            transition: 0.5s ease;

        }

        .about-image:hover img {
            transform: scale(1.2);

        }

        /* p */
        .about-content {
            flex: 1;
        }

        .about-content h2 {
            font-size: 23px;
            margin-bottom: 15px;
            color: #000;
        }

        .about-content p {
            font-size: 20px;
            margin-bottom: 15px;
            color: #000;

        }

        .about-content2 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #000;

        }

        .about-content .read-more {
            display: inline-block;
            padding: 10px 20px;
            background-color: #000;
            color: #666f88;
            font-size: 19px;
            text-decoration: none;
            border-radius: 25px;
            margin-top: 15px;
            transition: 0.3s ease;

        }

        .about-content .read-more:hover {
            background-color: #666f88;

        }
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
                                <a class="nav-link active" style="color: #fff;" aria-current="page" href="../perguntas/perguntas.php">Chat</a>
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

                                    if (isset($_SESSION['permissao'])) {
                                        if ($_SESSION['permissao'] !== null) {
                                            echo '<li><a class="dropdown-item" href="../admin/inicio.php">Gerenciar</a></li>';
                                        }
                                    }

                                    if (isset($_SESSION['nome'])) {
                                    ?>
                                        <li class="dropdown dropend">
                                            <button type="button" class="editar btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" style="color: #fff;">
                                                Editar perfil
                                            </button>
                                            <a href="../usuario/pagina_usuario.php" target="_blank">Editar perfil</a>

                                            <!-- <form enctype="multipart/form-data" action="../perguntas/processa.php" method="post" class="dropdown-menu p-4">
                                                <div class="mb-3">
                                                    <div class="mb-3">
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                                                        <label for="formFileSm" class="form-label" style="color: #fff;">Procurar</label>
                                                        <input name="arquivo" class="form-control-sm" type="file" id="formFile" placeholder="buscar">
                                                    </div>
                                                    <button type="submit" class="btn btn-outline-secondary">Enviar</button>
                                                </div>
                                            </form> -->
                                        </li>
                                    <?php } ?>
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
                </div>
            </nav>

        </div>
        <!--------------------MAIN-------------------->
        <div class="item2">

            <div class="heading">
                <h2>O Mundo da Inteligência Artificial:</h2>
                <p>A inteligência artificial (IA) refere-se à simulação da inteligência humana em máquinas programadas para pensar e tomar decisões como um ser humano.Ela é um campo amplo que engloba várias abordagens e técnicas, sendo uma delas o aprendizado de máquina (ML), que por sua vez inclui o aprendizado profundo (deep learning).</p>

            </div>

            <div class="container">
                <section class="about">
                    <div class="about-image">
                        <img src="imagem3.png">
                    </div>


                    <div class="about-content">
                        <h2>O que é IA:</h2>
                        <p>A inteligência artificial busca desenvolver algoritmos e sistemas capazes de realizar tarefas que normalmente requerem inteligência humana. Isso inclui aprendizado, raciocínio, reconhecimento de padrões, resolução de problemas, compreensão de linguagem natural e até mesmo interação social.</p>


                    </div>

                    <div class="about-content2">
                        <h2>Como funciona:</h2>
                        <p>Existem várias abordagens para construir sistemas de IA, mas uma das mais poderosas e populares é o aprendizado de máquina. No aprendizado de máquina, os algoritmos são treinados usando dados para realizar tarefas específicas sem serem explicitamente programados para essas tarefas.
                            O aprendizado profundo (deep learning) é uma subárea do aprendizado de máquina que utiliza redes neurais artificiais para imitar o funcionamento do cérebro humano. Essas redes são compostas por camadas de neurônios interconectados, e o treinamento envolve ajustar os pesos dessas conexões com base nos dados de entrada.</p>

                    </div>

                    <div class="about-content2">
                        <h2>Aplicações da IA:</h2>
                        <p>A IA tem inúmeras aplicações em diversas áreas, incluindo:
                            Saúde: Diagnóstico médico, descoberta de medicamentos, personalização de tratamentos.
                        <ul>
                            <li>Finanças: Análise de riscos, detecção de fraudes, previsões de mercado.</li>
                            <li>Educação: Sistemas de tutoria personalizada, avaliação automática de desempenho.</li>
                            <li>Automotivo: Carros autônomos, sistemas de assistência ao motorista.</li>
                            <li>Tecnologia: Reconhecimento de voz, assistentes virtuais, tradução automática.</li>
                            <li>Manufatura: Controle de qualidade, manutenção preditiva, automação de processos.</li>
                        </ul>
                        </p>

                    </div>

                    <div class="about-content2">
                        <h2>Como pode ser usada:</h2>
                        <p>A implementação prática da IA envolve várias etapas:
                        <ul>
                            <li>Coleta de dados: Os algoritmos de IA precisam ser treinados com dados relevantes para aprender padrões e realizar tarefas específicas.</li>
                            <li>Treinamento do modelo: Utiliza-se um conjunto de dados para treinar o modelo de IA, ajustando os parâmetros para otimizar o desempenho.</li>
                            <li>Validação e teste: O modelo é testado com dados adicionais para garantir que ele generalize bem e funcione corretamente.</li>
                            <li>Implantação: Após o treinamento e teste bem-sucedidos, o modelo pode ser implantado em ambientes de produção para realizar tarefas em tempo real. </li>
                        </ul>
                        </p>
                    </div>

                    <div class="about-content2">
                        <h2>Desafios e ética:</h2>
                        <p>A IA também enfrenta desafios, como vieses nos dados, explicabilidade dos modelos, privacidade e questões éticas relacionadas ao seu uso em várias áreas da sociedade.
                            Em resumo, a IA é uma área multidisciplinar em constante evolução, com o potencial de transformar significativamente a forma como interagimos com o mundo e lidamos com problemas complexos.</p>

                    </div>
            </div>
            <!--------------------ADS-------------------->
            <!-- <div class="item3">

<h2>Aqui ira ficar todos os anuncios </h2>


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