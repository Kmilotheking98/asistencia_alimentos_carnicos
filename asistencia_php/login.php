<?php
    session_start();
    require 'conexion.php';
  if (isset($_SESSION['user'])) {
    header('Location: login.php');
  }
  

  if (!empty($_POST['name']) && !empty($_POST['password'])) {
    $records = $conn ->prepare('SELECT * FROM user WHERE name = :name or email = :name');
    $records->bindParam(':name', $_POST['name']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if (count($results) > 0  && password_verify($_POST['password'], $results['password'])) {
 
      $_SESSION['user'] = $results['name'];
      $_SESSION['permit'] = $results['permit'];
      header("Location: index.php");

      
    

    } else {
      $message = 'Sorry, those credentials do not match';
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title >Login</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
  </head>
  <body class="login">
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Login</h1>

    <span>or <a href="signup.php">SignUp</a></span>

    <form action="login.php" method="POST">
      <input name="name" type="text" placeholder="Introduce tu nombre de usuario">
      <input name="password" type="password" placeholder="Introduce tucontraseña">
      <input class="btn btn__me" type="submit" value="Entrar">
    </form>
  </body>
</html>
