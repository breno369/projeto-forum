<?php

include "../../pdo/PDO.php";

$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();

$id = NULL;

if (isset($_GET['id'])) {
}
$id = $pdo->selectID($_GET['id'], 'respostas');

// var_dump($_POST);
// echo '<br><br><br>';
// var_dump($id);

if ($_POST != null) {
    $pdo->updateResposta($_POST['resposta'], $_POST['id'], $_POST['id_user'], $_POST['id_pergunta']);
    header('location:../resposta.php');
}

?>
<html>

<head>
    <title>Editar resposta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
</head>

<body>

    <div class="container">


        <form action="" method="POST" class="col-6 p-4 needs-validation" novalidate>
            <input type="hidden" name="id" value="<?php echo $id['id']; ?>">
            <input type="hidden" name="id_user" value="<?php echo $id['id_usuario']; ?>">
            <input type="hidden" name="id_pergunta" value="<?php echo $id['id_pergunta']; ?>">

            <h1 class="mb-3">Editar respostas</h1>
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Resposta</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-file-earmark-person"></i>
                </span>
                <input type="text" class="form-control" placeholder="Resposta" aria-label="resposta"
                    aria-describedby="basic-addon1" name="resposta" required value="<?php echo $id['resposta']; ?>">
                <div class="invalid-feedback">
                    Insira uma resposta!
                </div>
            </div>
            <input type="submit" value="Salvar" class="btn btn-success">
        </form>
    </div>
</body>

</html>