<?php 

  //Conexion

 

  $servidor = "localhost";

  $usuario = "root";

  $password = "";

  $nombreBD = "attendance1";

  $conexion = new mysqli($servidor, $usuario, $password, $nombreBD);

  if ($conexion->connect_error){

  die("La conexión ha fallado " . $conexion->connect_error);


  }else{



  }

 

 



?>