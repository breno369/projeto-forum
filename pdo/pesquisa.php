<?php

session_start();
include "../pdo/PDO.php";

$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();

$a = $pdo->selectAsteriscoPergunta();

// print_r($a);

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
  $q = strtolower($q);
  $len = strlen($q);
  foreach ($a as $name) {

    // var_dump($name['id']);
    // echo '<br><br><br>';
    // var_dump($name['pergunta']);
    // echo '<br><br><br>';

    if (stristr($q, substr($name['pergunta'], 0, $len))) {
      if ($hint === "") {
        $hint .= '<a class="a" href="../responder/index.php?id=' . $name['id'] .  '.html">' . $name['pergunta'] . '</a><hr style="margin: 0px;">';
      } else {
        $hint .= '<a class="a" href="../responder/index.php?id=' . $name['id'] .  '.html">' . $name['pergunta'] . '</a><hr style="margin: 0px;">';
        //'
      }
    }
  }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? '<div class="search"><p class="p">num achô</p></div>' : '<div class="search">'.$hint.'</div>';
