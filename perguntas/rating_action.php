<?php
session_start();
include "../pdo/PDO.php";

$pdo = new usePDO();
$pdo->createDB();
$pdo->createTable();

// var_dump($_SESSION);
// echo '<br>';
// var_dump($_POST);


if (isset($_SESSION['email'])) {
  $userid = $_SESSION['id_user'];
}
// $userid = 1;
// var_dump($userid);

if (isset($_POST['action'])) {

  $postid = $_POST['post_id'];
  $action = $_POST['action'];
  switch ($action) {
    case 'like':
      $vote_action = 'like';
      $pdo->insert_vote($userid, $postid, $vote_action);
      // var_dump($vote_action);
      break;
    case 'dislike':
      $vote_action = 'dislike';
      $pdo->insert_vote($userid, $postid, $vote_action);
      // var_dump($vote_action);
      break;
    case 'unlike':
      $pdo->delete_vote($userid, $postid);
      // var_dump($vote_action);
      break;
    case 'undislike':
      $pdo->delete_vote($userid, $postid);
      // var_dump($vote_action);
      break;
    default:
  }
  // execute query to effect changes in the database ...
  echo $pdo->getRating($postid);
  exit(0);
}
