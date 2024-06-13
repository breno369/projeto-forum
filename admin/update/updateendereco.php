<?php

include "../../pdo/PDO.php";

$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();

if (isset($_GET['id'])) {
    $cep = $pdo->selectID($_GET['id'], 'endereco');
    $cidade = $pdo->selectID($cep['id_cidade'], 'cidade');
    $estado = $pdo->selectID($cidade['id_estado'], 'estado');
}

if ($_POST != null) {
    $id = intval($_POST['id']);
    $id_pessoa = intval($_POST['id_pessoa']);
    $id_cidade = intval($_POST['id_cidade']);
    $id_estado = intval($_POST['id_estado']);
    $updateestado = $pdo->update('estado', $_POST['estado'], $_POST['id_estado'], null);
    $updatecidade = $pdo->update('cidade', $_POST['cidade'], $id_cidade, $_POST['id_estado']);
    $updateendereco = $pdo->updateEndereco($id, $_POST['cep'], $_POST['num'], $_POST['logradouro'], $_POST['bairro'], $id_pessoa, $_POST['id_cidade']);
    header("location:../cep.php");
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

    <div class="container">
        <form action="" method="POST" class="col-6 p-0 needs-validation" novalidate>
            <input type="hidden" name="id" value="<?php echo $cep['id']; ?>">
            <input type="hidden" name="id_pessoa" value="<?php echo $cep['id_pessoa']; ?>">
            <input type="hidden" name="id_cidade" value="<?php echo $cep['id_cidade']; ?>">
            <input type="hidden" name="id_estado" value="<?php echo $cidade['id_estado']; ?>">

            <h1 class="mb-3">Editar endereco</h1>

            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Numero Residencial</label>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-file-earmark-person"></i>
                </span>
                <input type="number" name="num" class="form-control" placeholder="Numero Residencial" aria-label="num"
                    aria-describedby="basic-addon1" value="<?php echo $cep['numero']; ?>" required>
                <div class="invalid-feedback">
                    Insira uma numero!
                </div>
            </div>

            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">CEP</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-file-earmark-person"></i>
                </span>
                <input type="text" id="cep" class="form-control" placeholder="CEP " aria-label="CEP"
                    aria-describedby="basic-addon1" name="cep" required value="<?php echo $cep['cep']; ?>"
                    maxlength="8">
                <button type="button" class="btn btn-outline-info" onclick="buscaCEP()">Buscar CEP</button>
                <div class="invalid-feedback">
                    Insira uma cep!
                </div>
            </div>

            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Logradouro</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-file-earmark-person"></i>
                </span>
                <input type="text" id="logradouro" class="form-control" placeholder="Logradouro" aria-label="Logradouro"
                    aria-describedby="basic-addon1" name="logradouro" value="<?php echo $cep['logradouro']; ?>"
                    required>
                <div class="invalid-feedback">
                    Insira um logradouro!
                </div>
            </div>

            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Bairro</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-file-earmark-person"></i>
                </span>
                <input type="text" id="bairro" class="form-control" placeholder="Bairro" aria-label="Bairro"
                    aria-describedby="basic-addon1" name="bairro" required value="<?php echo $cep['bairro']; ?>">
                <div class="invalid-feedback">
                    Insira um bairro!
                </div>
            </div>

            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Cidade</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-file-earmark-person"></i>
                </span>
                <input type="text" class="form-control" placeholder="Cidade" aria-label="Cidade"
                    aria-describedby="basic-addon1" name="cidade" required value="<?php echo $cidade['cidade']; ?>">

                <div class="invalid-feedback">
                    Insira uma cidade!
                </div>
            </div>

            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Estado</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i class="bi bi-file-earmark-person"></i>
                </span>
                <input type="text" class="form-control" placeholder="Estado " aria-label="Estado"
                    aria-describedby="basic-addon1" name="estado" required value="<?php echo $estado['estado']; ?>">
                <div class="invalid-feedback">
                    Insira um estado!
                </div>
            </div>

            <input type="submit" value="Salvar" class="btn btn-success">
        </form>
    </div>
    <script>
        function buscaCEP() {

            var cep = document.getElementById('cep').value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'https://viacep.com.br/ws/' + cep + '/json/', true);
            console.log(xhr);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var data = JSON.parse(xhr.responseText);
                    if (data.erro) {
                        alert('CEP não foi encontrado');
                        // cep não encontrado
                    } else {
                        document.getElementById('logradouro').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                        document.getElementById('estado').value = data.uf;
                    }
                } else {
                    alert('erro ao buscar cep');
                }
            };
            xhr.send();
        }
    </script>

</body>

</html>