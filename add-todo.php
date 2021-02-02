<?php
  session_start();
  require_once 'pdo.php';


  if (isset($_POST['todo'])) {
    $currentdate = date("Y-m-d H:i:s");
    try {
      $sql = "INSERT INTO tasks (task,category,createdtime) VALUES (:tsk,:cat,:tm)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ":tsk" => $_POST['todo'],
        ":cat" => $_POST['category'],
        ":tm" => $currentdate

      ));
      $_SESSION['lastid'] = $pdo->lastInsertId();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }

  }

 ?>
