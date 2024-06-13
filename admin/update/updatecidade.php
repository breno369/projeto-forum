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
    $id = $pdo->selectID($_GET['id'], 'cidade');
  // var_dump($id);
  }
  ?>

  <div class="container">


    <form action="" method="POST" class="col-6 p-4 needs-validation" novalidate>
      <input type="hidden" name="id" value="<?php echo $id['id']; ?>">
      <input type="hidden" name="id_estado" value="<?php echo $id['id_estado']; ?>">

      <h1 class="mb-3">Editar cidade</h1>
      <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Cidade</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">
          <i class="bi bi-file-earmark-person"></i>
        </span>
        <input type="text" class="form-control" placeholder="Cidade " aria-label="Cidade"
          aria-describedby="basic-addon1" name="cidade" required value="<?php echo $id['cidade']; ?>">

        <div class="invalid-feedback">
          Insira uma cidade!
        </div>
      </div>

      <input type="submit" value="Salvar" class="btn btn-success">
  </div>
  </form>

  <?php
  // var_dump($_POST);
  // echo '<br><br><br>';
  // var_dump($id);
  
  if ($_POST != null) {
    $pdo->update('cidade', $_POST['cidade'], $_POST['id'], $_POST['id_estado']);
    header('location:../cidade.php');
  }
  ?>
  </div>