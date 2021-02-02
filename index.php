<?php
session_start();
require_once 'pdo.php';

$sql = "SELECT * FROM tasks ORDER BY createdtime";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$last_id = 0;

if (isset($_SESSION['lastid'])) {
  $last_id = $_SESSION['lastid'];
}else {
  try {
    $sql1 = "SELECT task_id FROM tasks ORDER BY createdtime DESC LIMIT 1";
    $stmt1 = $pdo->query($sql1);
    $fetch_id = $stmt1->fetch(PDO::FETCH_ASSOC);
    if ($fetch_id == true) {
      $last_id = $fetch_id['task_id'];
    }

  } catch (PDOException $e) {
    echo $e->getMessage();
  }


}

 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Procrastinator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="css/master.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <script src="js/index.js" charset="utf-8"></script>

    <script src="https://kit.fontawesome.com/68830fe0e1.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="container move-down">
      <h1>Procrastinator</h1>

      <form id="addTodo" method="post">
        <div class="row">
          <div class="col-6">
            <div class="form-floating mb-1 mt-3">
              <input type="text" class="form-control" id="NewTodo" name="NewTodo"  placeholder="Task">
              <label for="NewTodo">Enter New Task</label>
            </div>
            <div class="row">
              <div class="col-lg-7 col-sm-12">
                <p class="text-muted">eg. Go grocery shopping</p>
              </div>
              <div class="col-lg-5">
                <div class="options mt-1">
                  <button type="button" name="today" class="btn btn-outline-primary btn-option" id="today"><i class="fas fa-tasks"></i><span class="d-none d-lg-inline"> Today</span></button>
                  <button type="button" name="general" class="btn btn-outline-secondary btn-option" id="general"><i class="fas fa-inbox"></i><span class="d-none d-lg-inline"> General</span></button>
                </div>
              </div>

            </div>

          </div>
          <div class="col-4 mt-4">
            <button type="submit" name="submit" class="btn btn-lg btn-danger btn-submit" data-lastid="<?=$last_id ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Submit" disabled><i class="far fa-paper-plane"></i></button>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-6">
          <div class="todays-list mt-5">
            <h3>Today's List</h3>
            <?php foreach ($rows as $row): ?>
              <?php if ($row['category'] === 'today'): ?>
                <div class="form-check" id="<?=$row['task_id'] ?>">
                  <input class="form-check-input check" type="checkbox" data-id="<?=$row['task_id'] ?>" id="<?='check'.$row['task_id'] ?>">
                  <label class="form-check-label" for="<?='check'.$row['task_id'] ?>"><?=$row['task'] ?></label>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>

          </div>
        </div>


        <div class="col-6">
          <div class="general-list">
            <h3>General List</h3>
            <?php foreach ($rows as $row): ?>
              <?php if ($row['category'] === 'general'): ?>
                <div class="form-check" id="<?=$row['task_id'] ?>">
                  <input class="form-check-input check" type="checkbox" data-id="<?=$row['task_id'] ?>" id="<?='check'.$row['task_id'] ?>">
                  <label class="form-check-label" for="<?='check'.$row['task_id'] ?>"><?=$row['task'] ?></label>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

      </div>
    </div>
  </body>
</html>
