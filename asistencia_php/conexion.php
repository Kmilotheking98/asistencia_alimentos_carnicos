<?php 

  //Conexion

 

  $servidor = "localhost";

  $usuario = "root";

  $password = "";

  $nombreBD = "attendance1";

  $conexion = new mysqli($servidor, $usuario, $password, $nombreBD);

  if ($conexion->connect_error){

  die("La conexión ha fallado " . $conexion->connect_error);

  echo "algo va mal";

  }else{

  echo "Todo ha salido bien";

  }

 

 



?>