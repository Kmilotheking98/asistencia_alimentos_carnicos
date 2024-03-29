<?php

  require 'conexion.php';

  if ( !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['permit'])) {
    $sql = "INSERT INTO user ( name, email, password, permit) VALUES (:name, :email, :password, :permit)";
    $stmt = $conn ->prepare($sql);
    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':permit', $_POST['permit']);
    

    if ($stmt->execute()) {
      $message = 'Successfully created new user';
      header('Location: login.php');
    } else {
      $message = 'Sorry there must have been an issue creating your account';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SignUp</title>
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

    <h1>SignUp</h1>
    <span>or <a href="login.php">Login</a></span>

    <form action="signup.php" method="POST">
      <input name="email" type="text" placeholder="Enter your email">
      <input name="name" type="text" placeholder="name">
      <!-- <input name="rol_id" type="number" placeholder="rol"> -->
      <select name="permit" class="form-control" placeholder="rol">
          <option disabled value="unset">--Seleccionar Rol--</option>
            <option value="1" name="permit" id="1">Administrador</option>
            <option value='2' name='permit' id='2'>Supervisor</option>
            <option value='3' name='permit' id='3'>Colaborador</option>
      </select>
      <input name="password" type="password" placeholder="Enter your Password">
      <input name="confirm_password" type="password" placeholder="Confirm Password">
      <input type="submit" value="Registrar">
    </form>

  </body>
</html>