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

  include "../../pdo/PDO.php";

  $pdo = new usePDO();
  $pdo->createDB();
  $pdo->createTable();

  $id = NULL;

  if (isset($_GET['id'])) {
  }
  $id = $pdo->selectID($_GET['id'], 'pessoas');
  ?>

  <div class="container">


    <form action="" method="POST" class="col-6 p-4 needs-validation" novalidate>
      <input type="hidden" name="id" value="<?php echo $id['id']; ?>">
      <input type="hidden" name="id_user" value="<?php echo $_GET['id_user']; ?>">

      <h1 class="mb-3">Editar Pessoas</h1>

      <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Nome</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
          <i class="bi bi-file-earmark-person"></i>
        </span>
        <input type="text" class="form-control" placeholder="Nome Completo " aria-label="Nome"
          aria-describedby="basic-addon1" name="nome" required value="<?php echo $id['nome_completo']; ?>">

        <div class="invalid-feedback">
          Insira um nome!
        </div>
      </div>

      <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Data de Nascimento</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
          <i class="bi bi-calendar-heart"></i>
        </span>
        <input id="datePickerId" type="date" class="form-control" placeholder="nasc" aria-label="nasc"
          aria-describedby="basic-addon1" name="nasc" required value="<?php echo $id['data_nasc']; ?>">

        <div class="invalid-feedback">
          Preencha este campo
        </div>
      </div>

      <div class="row">
        <div class="mb-3 col-6">
          <label for="colFormLabelSm" class="col-sm-0 col-form-label col-form-label-sm">RG</label>
          <input type="number" class="form-control" placeholder="RG" aria-label="RG" aria-describedby="basic-addon1"
            name="RG" required value="<?php echo $id['rg']; ?>">
          <div class="invalid-feedback">
            Preencha este campo
          </div>
        </div>
        <div class="ms-auto mb-3 col-6">
          <label for="colFormLabelSm" class="col-sm-0 col-form-label col-form-label-sm">Órgão Emissor</label>
          <input type="text" class="form-control" placeholder="Órgão Emissor" aria-label="emissor"
            aria-describedby="basic-addon1" name="emissor" required value="<?php echo $id['orgao_emissor']; ?>">
          <div class="invalid-feedback">
            Preencha este campo
          </div>
        </div>
      </div>
      <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">CPF</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
          <i class="bi bi-file-post"></i>
        </span>
        <input type="text" class="form-control" placeholder="CPF " aria-label="CPF" aria-describedby="basic-addon1"
          name="cpf" required value="<?php echo $id['cpf']; ?>">

        <div class="invalid-feedback">
          Insira um CPF válido!
        </div>
      </div>
      <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Genero</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
          <i class="bi bi-gender-trans"></i>
        </span>
        <select name="sexo" class="form-select">
          <?php
          if ($id['sexo'] == NULL || $id['sexo'] == 4) {
            echo '<option value="4" selected>Não Informado</option>
                  <option value="2">Masculino</option>
                  <option value="3">Feminino</option>';
          } else if ($id['sexo'] == 2) {
            echo '<option value="4">Não Informado</option>
                  <option value="2" selected>Masculino</option>
                  <option value="3">Feminino</option>';
          } else {
            echo '<option value="4">Não Informado</option>
                  <option value="2">Masculino</option>
                  <option value="3" selected>Feminino</option>';
          }
          ?>
        </select>
      </div>
      <input type="submit" value="Salvar" class="btn btn-success">
    </form>
  </div>

  <?php
  // var_dump($_POST);
  echo '<br><br><br>';
  // var_dump($id);
  
  if ($_POST != null) {
    $pdo->updatePessoas($_POST['id'], $_POST['nome'], $_POST['RG'], $_POST['emissor'], $_POST['cpf'], $_POST['nasc'], $_POST['sexo'], $_POST['id_user']);
    header('location:../index.php');
  }
  ?>
</body>

</html>