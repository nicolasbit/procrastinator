<?php
  require_once 'pdo.php';

  if (isset($_POST['delete_id'])) {
    $sql = "DELETE FROM tasks WHERE task_id=:tid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ":tid" => $_POST['delete_id']
    ));
  }

 ?>
