<?php 

  //Conexion

  $servidor = "localhost";

  $usuario = "root";

  $password = "";

  $nombreBD = "attendance1";


  try {
    // forma 1

    $conn = new PDO("mysql:host=$servidor;dbname=$nombreBD;", $usuario, $password);

    //forma 2

  $conexion = new mysqli($servidor, $usuario, $password, $nombreBD);  

  } catch (PDOException $e) {
    
    if ($conexion->connect_error){

      die("La conexión ha fallado " . $conexion->connect_error);
      die('Connection Failed: ' . $e->getMessage());
    
      }
    
  }
   ?>
